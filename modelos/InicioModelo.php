<?php
class Modelo{
	public function __construct(){
		include_once("conexion.php");
		$db = new Conectar();
		$this->db = $db->conexion();
	}

	/**************** METODOS PARA INICIO DE SESION *****************/

	//Metodo para iniciar sesion
	public function iniciar_sesion($usuario, $pass){
		$md5 = md5($pass);
		$consulta = $this->db->prepare("select a.nom_usuario, a.pass_usu, b.nombre1_usu, b.ape1_usu, b.mail_usu, b.telefono_usu, b.direccion_usu, b.doc_usu from login as a inner join usuario as b on a.nom_usuario = b.usu_usuario where a.nom_usuario = :usuario and a.pass_usu = '".$md5."'");
		$consulta->bindParam(":usuario",$usuario);
		$consulta->execute();
		$error = $consulta->errorInfo();
		if($error[1]!=0){
			//echo "Error SQL en funcion iniciar_sesion ".$error[2];
			$respuesta = array("success" => false, "mensaje" => $error[2]);
			echo json_encode($respuesta);
			exit;
		}
		return $consulta->fetchAll();
		/*$respuesta = array("success" => true, "data" => $consulta->fetchAll());
		return json_encode($respuesta);*/
	}

	// Metodo para crear usuario
	
	public function registrar_cliente($doc_usu, $mail_usu, $usu_usuario, $nombre1_usu, $nombre2_usu, $ape1_usu, $ape2_usu, $telefono_usu, $direccion_usu, $pass){
		$md5 = md5($pass);
		$consulta = $this->db->prepare("insert into login values(:usu_usuario, '".$md5."')");
		$consulta->bindParam(":usu_usuario",$usu_usuario);
		$consulta->execute();
		$error = $consulta->errorInfo();
		if($error[1]!=0){
			$respuesta = array("success" => false, "mensaje" => $error[2]);
			echo json_encode($respuesta);
			exit;
		} else {
			$consulta2 = $this->db->prepare("insert into usuario values(:doc_usu, :mail_usu, :usu_usuario, :nombre1_usu, :nombre2_usu, :ape1_usu, :ape2_usu, :telefono_usu, :direccion_usu)");
			$consulta2->bindParam(":doc_usu",$doc_usu);
			$consulta2->bindParam(":mail_usu",$mail_usu);
			$consulta2->bindParam(":usu_usuario",$usu_usuario);
			$consulta2->bindParam(":nombre1_usu",$nombre1_usu);
			$consulta2->bindParam(":nombre2_usu",$nombre2_usu);
			$consulta2->bindParam(":ape1_usu",$ape1_usu);
			$consulta2->bindParam(":ape2_usu",$ape2_usu);
			$consulta2->bindParam(":telefono_usu",$telefono_usu);
			$consulta2->bindParam(":direccion_usu",$direccion_usu);
			$consulta2->execute();
			$error2 = $consulta2->errorInfo();
			if($error2[1]!=0){
				$respuesta = array("success" => false, "mensaje" => $error2[2]);
				echo json_encode($respuesta);
				exit;
			}
		}
		return true;
	}

	// Metodo para verificar documento repetido
	
	public function verificar_documento_repetido($doc_usu){
		$consulta = $this->db->prepare("select doc_usu from usuario where doc_usu = :doc_usu");
		$consulta->bindParam(":doc_usu",$doc_usu);
		$consulta->execute();
		$error = $consulta->errorInfo();
		if($error[1]!=0){
			$respuesta = array("success" => false, "mensaje" => $error[2]);
			echo json_encode($respuesta);
			exit;
		}
		return $consulta->fetchAll();
	}

	// Metodo para verificar usuario repetido
	
	public function verificar_usuario_repetido($doc_usu){
		$consulta = $this->db->prepare("select doc_usu from usuario where doc_usu = :doc_usu");
		$consulta->bindParam(":doc_usu",$doc_usu);
		$consulta->execute();
		$error = $consulta->errorInfo();
		if($error[1]!=0){
			$respuesta = array("success" => false, "mensaje" => $error[2]);
			echo json_encode($respuesta);
			exit;
		}
		return $consulta->fetchAll();
	}

	/**************** FIN METODOS PARA INICIO DE SESION *****************/

	/**************** METODOS PARA CONTROL DE PROCESOS *****************/


	// Metodo para traer todos los procesos habilitados
	
	public function todos_procesos(){
		$consulta = $this->db->prepare("select * from proceso");
		$consulta->execute();
		$error = $consulta->errorInfo();
		if($error[1]!=0){
			echo "Error SQL en funcion todos_procesos ".$error[2];
		}
		return $consulta->fetchAll();
	}

	// Metodo para validar que no hayan procesos repetidos
	
	public function verificar_procesos_repetidos($num_proc){
		$consulta = $this->db->prepare("select num_proc from proceso where num_proc = :num_proc");
		$consulta->bindParam(":num_proc",$num_proc);
		$consulta->execute();
		$error = $consulta->errorInfo();
		if($error[1]!=0){
			echo "Error SQL en funcion verificar_procesos_repetidos ".$error[2];
		}
		return $consulta->fetchAll();
	}

	// Metodo para traer los datos de un proceso por su ID

	public function datos_proceso_por_id($num_proc){
		$consulta = $this->db->prepare("select * from proceso where num_proc = :num_proc");
		$consulta->bindParam(":num_proc",$num_proc);
		$consulta->execute();
		$error = $consulta->errorInfo();
		if($error[1]!=0){
			$respuesta = array("success" => false, "mensaje" => $error[2]);
			echo json_encode($respuesta);
			exit;
		}
		return $consulta->fetchAll();
	}

	// Metodo para agregar proceso a la base de datos

	public function agregar_proceso($num_proc, $desc_proc, $fecha_creacion, $sede, $pres_proc, $estado_proceso, $usuario_crea_proceso, $precio_dolares){
		$consulta = $this->db->prepare("insert into proceso values(:num_proc, :desc_proc, :fecha_creacion, :sede, :pres_proc, :estado_proceso, :usuario_crea_proceso, :precio_dolares)");
		$consulta->bindParam(":num_proc",$num_proc);
		$consulta->bindParam(":desc_proc",$desc_proc);
		$consulta->bindParam(":fecha_creacion",$fecha_creacion);
		$consulta->bindParam(":sede",$sede);
		$consulta->bindParam(":pres_proc",$pres_proc);
		$consulta->bindParam(":estado_proceso",$estado_proceso);
		$consulta->bindParam(":usuario_crea_proceso",$usuario_crea_proceso);	
		$consulta->bindParam(":precio_dolares",$precio_dolares);	
		$consulta->execute();
		$error = $consulta->errorInfo();
		if($error[1]!=0){
			$respuesta = array("success" => false, "mensaje" => "Error en la funcion agregar_proceso ".$error[2]);
			echo json_encode($respuesta);
			exit;
		}
		return $consulta->rowCount();
	}

	//Metodo para eliminar un proceso

	public function eliminar_proceso($num_proc){
		$consulta = $this->db->prepare("delete from proceso where num_proc = :num_proc");
		$consulta->bindParam(":num_proc",$num_proc);	
		$consulta->execute();
		$error = $consulta->errorInfo();
		if($error[1]!=0){
			$respuesta = array("success" => false, "mensaje" => "Error en la funcion eliminar_proceso ".$error[2]);
			echo json_encode($respuesta);
			exit;
		}
		return true;
	}

	// Metodo para actualizar datos de proceso

	public function actualizar_proceso($num_proc, $desc_proc, $sede, $pres_proc, $precio_dolares){
		$consulta = $this->db->prepare("update proceso set desc_proc = :desc_proc, sede = :sede, pres_proc = :pres_proc, precio_dolares = :precio_dolares where num_proc = :num_proc");
		$consulta->bindParam(":num_proc",$num_proc);	
		$consulta->bindParam(":desc_proc",$desc_proc);
		$consulta->bindParam(":sede",$sede);
		$consulta->bindParam(":pres_proc",$pres_proc);
		$consulta->bindParam(":precio_dolares",$precio_dolares);
		$consulta->execute();
		$error = $consulta->errorInfo();
		if($error[1]!=0){
			$respuesta = array("success" => false, "mensaje" => "Error en la funcion actualizar_proceso ".$error[2]);
			echo json_encode($respuesta);
			exit;
		}
		return $consulta->rowCount();
	}

	// Metodo para habilitar o deeshabilitar un proceso

	public function hab_deshab_proceso($num_proc, $estado_proceso){
		$consulta = $this->db->prepare("update proceso set estado_proceso = :estado_proceso where num_proc = :num_proc");
		$consulta->bindParam(":num_proc",$num_proc);
		$consulta->bindParam(":estado_proceso",$estado_proceso);
		$consulta->execute();
		$error = $consulta->errorInfo();
		if($error[1]!=0){
			$respuesta = array("success" => false, "mensaje" => "Error en la funcion hab_deshab_proceso ".$error[2]);
			echo json_encode($respuesta);
			exit;
		}
		return $consulta->rowCount();
	}

	/**************** FIN METODOS PARA INICIO DE SESION *****************/
}
?>