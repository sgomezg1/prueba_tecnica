<?php
	class formularios{
		public function __construct(){
			$modelo = include_once("modelos/InicioModelo.php");
			$this->modelo = new Modelo();
			$controlador = include_once("controladores/InicioControlador.php");
			$this->controlador = new Controlador();
		}

		public function formulario_agregar_usuario(){
			header("Content-type:application/json");
			$html = 
			'	
				<form id = "form-agregar-usuario" method = "post">
					<input type = "hidden" name = "accion" value = "ingresar_nuevo_usuario">
					<table class = "ancho-total table-condensed">
						<tr>
							<td style = "width: 50%;">
								<label>Usuario</label><br>
								<input type = "text" class = "form-control" id = "usu_usuario" name = "usu_usuario" placeholder="Usuario">
							</td>
							<td style = "width: 50%;">
								<label>Contraseña</label><br>
								<input type = "password" class = "form-control" id = "pass_usu" name = "pass_usu" placeholder="Contraseña">
							</td>
						</tr>
						<tr>
							<td style = "width: 50%;">
								<label>Primer Nombre</label><br>
								<input type = "text" class = "form-control" id = "nombre1_usu" name = "nombre1_usu" placeholder="Primer Nombre" required>
							</td>
							<td style = "width: 50%;">
								<label>Segundo nombre</label><br>
								<input type = "text" class = "form-control" id = "nombre2_usu" name = "nombre2_usu" placeholder="Segundo nombre">
							</td>
						</tr>
						<tr>
							<td style = "width: 50%;">
								<label>Primer Apellido</label><br>
								<input type = "text" class = "form-control" id = "ape1_usu" name = "ape1_usu" placeholder="Primer Apellido" required>
							</td>
							<td style = "width: 50%;">
								<label>Segundo Apellido</label><br>
								<input type = "text" class = "form-control" id = "ape2_usu" name = "ape2_usu" placeholder="Segundo Apellido">
							</td>
						</tr>
						<tr>
							<td style = "width: 50%;">
								<label>Documento de identidad</label><br>
								<input type = "text" class = "form-control" id = "doc_usu" name = "doc_usu" placeholder="Documento de identidad">
							</td>
							<td style = "width: 50%;">
								<label>Correo Electronico</label><br>
								<input type = "text" class = "form-control" id = "mail_usu" name = "mail_usu" placeholder="Correo Electronico">
							</td>
						</tr>
						<tr>
							<td>
								<label>Telefono Celular</label><br>
								<input type = "text" class = "form-control" id = "telefono_usu" name = "telefono_usu" placeholder="Telefono Celular">
							</td>
							<td>
								<label>Direccion</label><br>
								<input type = "text" class = "form-control" id = "direccion_usu" name = "direccion_usu" placeholder="Direccion">
							</td>
						</tr>
					</table>
				</form>
			';
			$respuesta = array("success"=>true, "html"=>$html);
			echo json_encode($respuesta);
			exit;
		}
		public function formulario_agregar_proceso(){
			header("Content-type:application/json");
			$html = 
			'	
				<h3 class = "color_azul">Agregar Proceso</h3>
				<form id = "form-agregar-proceso" method = "post">
					<input type = "hidden" name = "accion" value = "agregar_proceso">
					<table class = "table table-condensed no-bordes">
						<tr>
							<td>
								<label class = "color_azul" for = "num_proc">Numero del Proceso</label>
								<input type = "text" class = "form-control" name = "num_proc" id = "num_proc">
							</td>
							<td>
								<label class = "color_azul" for = "pres_proc">Precio del Proceso</label>
								<input type = "number" class = "form-control" name = "pres_proc" id = "pres_proc">
						    </td>
						</tr>
						<tr>
							<td colspan = "2">
								<label class = "color_azul" for = "desc_proc">Descripción del Proceso</label><br>
								<textarea class = "form-control" name="desc_proc" id="desc_proc"></textarea>
							</td>
						</tr>
						<tr>
							<td colspan = "2">
								<label class = "color_azul" for = "sede">Sede</label><br>
								<select class = "form-control" name = "sede" id = "sede">
									<option value = "Bogotá" selected>Bogotá</option>
									<option value = "México">México</option>
									<option value = "Peru">Peru</option>
								</select>
							</td>
						</tr>
					</table>
				</form>
			';
			$respuesta = array("success"=>true, "html"=>$html);
			echo json_encode($respuesta);
			exit;
		}
		public function formulario_editar_proceso(){
			header("Content-type:application/json");
			$datos_proceso_a_editar = $this->modelo->datos_proceso_por_id($_POST['num_proc']);
			$datos_decodificados = $this->controlador->addEncode($datos_proceso_a_editar);
			foreach($datos_decodificados as $datos){
				$html = 
				'
					<h3 class = "color_azul">Editar Proceso</h3>
					<form id = "form-editar-proceso" method = "post">
						<input type = "hidden" name = "accion" value = "actualizar_proceso">
						<input type = "hidden" name = "num_proc" value = "'.$datos['num_proc'].'">
						<table class = "table table-condensed no-bordes">
							<tr>
								<td colspan = "2">
									<label class = "color_azul" for = "pres_proc">Precio del Proceso</label>
									<input type = "text" class = "form-control" name = "pres_proc" id = "pres_proc" value = "'.$datos['pres_proc'].'">
							    </td>
							</tr>
							<tr>
								<td colspan = "2">
									<label class = "color_azul" for = "desc_proc">Descripción del Proceso</label><br>
									<textarea class = "form-control" name="desc_proc" id="desc_proc">'.$datos['desc_proc'].'</textarea>
								</td>
							</tr>
							<tr>
								<td>
									<label class = "color_azul" for = "sede_anterior">Anterior Sede</label><br>
									<input type = "text" class = "form-control" name = "sede_anterior" id = "sede_anterior" value = "'.$datos['sede'].'" readonly>
								</td>
								<td>
									<label class = "color_azul" for = "sede">Sede</label><br>
									<select class = "form-control" name = "sede" id = "sede">
										<option value = "">-- Seleccione un valor --</option>
										<option value = "Bogotá">Bogotá</option>
										<option value = "México">México</option>
										<option value = "Peru">Peru</option>
									</select>
								</td>
							</tr>
						</table>
					</form>
				';
			}
			$respuesta = array("success"=>true, "html"=>$html);
			echo json_encode($respuesta);
			exit;
		}
	}
?>