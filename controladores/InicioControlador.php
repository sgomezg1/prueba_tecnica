<?php
//session_start();
class Controlador{
	public function __construct(){
		$modelo = include_once("modelos/InicioModelo.php");
		$this->modelo = new Modelo();
	}

	// Llamado a las vistas que se mostraran al usuario.

	public function vista_login(){
		require'vistas/login.php';
	}

	public function vista_procesos(){
		if(isset($_SESSION['usu_usuario'])){
			require'vistas/inicio.php';
		} else {
			header("location:index.php");
		}
	}
	public function vista_detalle(){
		if(isset($_SESSION['usu_usuario'])){
			$detalle_proceso = $this->modelo->datos_proceso_por_id($_GET['num_proc']);
			require'vistas/detalle.php';
		} else {
			header("location:index.php");
		}
	} 
	
	/******************* METODOS AUXILIARES *******************/

	public function addEncode($array){
        $envio = array();
        foreach ($array as $key => $value) {
            if(is_array($value)){
                $envio[$key] = $this->addEncode($value);
            }
            else{
                $envio[$key] = utf8_encode($value);
            }
        }
        return $envio;
    }

    public function addDecode($array){
        $envio = array();
        foreach ($array as $key => $value) {
            if(is_array($value)){
                $envio[$key] = $this->addDecode($value);
            }
            else{
                $envio[$key] = utf8_decode($value);
            }
        }
        return $envio;
    }

    // Metodo para convertir dinero a dolares de cada precio de proceso
    
    public function currencyConverter($amount) {
		$json = file_get_contents("http://free.currencyconverterapi.com/api/v5/convert?q=COP_USD&compact=y");
		$obj = json_decode($json, true);
		$total = $amount * $obj['COP_USD']['val'];
		return number_format($total, 2, '.', '');
	}	

    /******************* FIN METODOS AUXILIARES *******************/
	/******************* METODOS QUE TRAEN DATOS PARA DATATABLES ********************/

	// Metodo para traer todos los procesos en un datatable
	
	public function todos_procesos(){
		header("Content-type:application/json");
		$procesos = $this->modelo->todos_procesos();
		echo json_encode($this->addEncode($procesos));
		exit;
	}

	/******************* FIN METODOS QUE TRAEN DATOS PARA DATATABLES ********************/

	// Metodos de operacion para hacer log en la aplicacion

	// Metodo para iniciar sesion en la aplicacion

	public function login(){
		header("Content-type:application/json");
		if(empty($_POST['usuario'])){
			echo "Por favor ingresa el usuario";
			exit;
		}
		if(empty($_POST['passw'])){
			echo "por favor ingresa la contraseña";
			exit;
		}
		$datos_log = $this->modelo->iniciar_sesion($_POST['usuario'], $_POST['passw']);
		//print_r($datos_log);
		if(sizeof($datos_log)>=1){
			foreach($datos_log as $datos){
				$_SESSION['doc_usu'] = $datos['doc_usu'];
				$_SESSION['usu_usuario'] = $datos['nom_usuario'];
				
				$respuesta = array("success" => true, "mensaje" => "Bienvenido a nuestro sistema");
				echo json_encode($respuesta);
				exit;
			}
		} else {
			$respuesta = array("success" => false, "mensaje" => "Error, Usuario o contraseña Incorrectos");
			echo json_encode($respuesta);
			exit;
		}
	}

	// Metodo para crear usuarios
	
	public function ingresar_nuevo_usuario(){
		header("Content-type:application/json");
		//var_dump($_FILES);
		$verificar_documento_repetido = $this->modelo->verificar_documento_repetido($_POST['usu_usuario']);
		$verificar_usuario_repetido = $this->modelo->verificar_usuario_repetido($_POST['doc_usu']);
		if(sizeof($verificar_documento_repetido)>=1){
			$success = false;
			$mensaje = "Este usuario con este numero de documento ya se ha registrado";
		} else if (sizeof($verificar_usuario_repetido)>=1){
			$success = false;
			$mensaje = "Este usuario con este nombre de usuario ya se ha registrado";
		} else {
			$insertar_cliente = $this->modelo->registrar_cliente($_POST['doc_usu'], $_POST['mail_usu'], $_POST['usu_usuario'], $_POST['nombre1_usu'], $_POST['nombre2_usu'], $_POST['ape1_usu'], $_POST['ape2_usu'], $_POST['telefono_usu'], $_POST['direccion_usu'], $_POST['pass_usu']);
			if($insertar_cliente >= 1){
				$success = true;
				$mensaje = "Usuario registrado con exito";
			} else {
				$success = false;
				$mensaje = "Error al registrar usuario";
			}
		}
		
		$respuesta = array("success" => $success, "mensaje"=>$mensaje);
		echo json_encode($respuesta);
		exit;
	}

	/******************** METODOS PARA CONTROL DE PROCESOS **************************/

	// Metodo para agregar un vehiculo nuevo

	public function agregar_proceso(){
		header("Content-type:application/json");
		$validar_proceso_repetido = $this->modelo->verificar_procesos_repetidos($_POST['num_proc']);
		if(sizeof($validar_proceso_repetido) >= 1){
			$success = false;
			$mensaje = "Ya hay un proceso con este id";
		} else {
			$convertir_dolares = $this->currencyConverter($_POST['pres_proc']);			
			$agregar = $this->modelo->agregar_proceso($_POST['num_proc'], utf8_decode($_POST['desc_proc']), date("Y-m-d"), utf8_decode($_POST['sede']), $_POST['pres_proc'], "Habilitado", $_SESSION['usu_usuario'], $convertir_dolares);
			if($agregar >= 1){
				$success = true;
				$mensaje = "Proceso agregado correctamente, sera habilitado automaticamente";

			} else {
				$success = false;
				$mensaje = "Error al agregar proceso";
			}
		}
		$respuesta = array("success" => $success, "mensaje"=>$mensaje);
		echo json_encode($respuesta);
		exit;
		
	}

	// Metodo para actualizar datos de un vehiculo especifico

	public function actualizar_proceso(){
		header("Content-type:application/json");
		$sede = ($_POST['sede']== "") ? $_POST['sede_anterior'] : $_POST['sede'];
		$convertir_dolares = $this->currencyConverter($_POST['pres_proc']);
		$editar = $this->modelo->actualizar_proceso($_POST['num_proc'], utf8_decode($_POST['desc_proc']), utf8_decode($sede), $_POST['pres_proc'], $convertir_dolares);
		if($editar >= 1){
			$success = true;
			$mensaje = "Proceso editado correctamente";

		} else {
			$success = false;
			$mensaje = "Error al editar proceso";
		}
		$respuesta = array("success" => $success, "mensaje"=>$mensaje);
		echo json_encode($respuesta);
		exit;
	}

	// Metodo para eliminar vehiculo especifico

	public function eliminar_proceso(){
		header("Content-type:application/json");
		//var_dump($_POST);
		$eliminar = $this->modelo->eliminar_proceso($_POST['num_proc']);
		$respuesta = array("success" => true, "mensaje" => "Proceso eliminado con exito");
		echo json_encode($respuesta);
		exit;
		
	}
	// Metodo para eliminar vehiculo especifico

	public function hab_deshab_proceso(){
		header("Content-type:application/json");
		if($_POST['estado_proceso'] == "Habilitado"){
			$estado = "Inhabilitado";
		} else {
			$estado = "Habilitado";
		}
		$habilitar_deshabilitar = $this->modelo->hab_deshab_proceso($_POST['num_proc'], $estado);
		$respuesta = array("success" => true, "mensaje" => "Proceso ".$estado." con exito");
		echo json_encode($respuesta);
		exit;
	}

	/******************** FIN METODOS PARA CONTROL DE PROCESOS **************************/
}
?>