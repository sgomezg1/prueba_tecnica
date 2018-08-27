<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Inicio de Sesion</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- CSS Personalizado -->

	<link rel="stylesheet" href = "css/style.css">

	<!-- JQuery -->

	<script src = "js/jquery.js"></script>

	<!-- JQuery validate forms-->

	<script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
	<script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>


	<!-- Bootstrap -->

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<!-- Material Design Lite -->

	<link rel="stylesheet" href = "css/material.css">
	<script src = "js/material.js"></script>

	<!-- Material Design Lite Ventanas Modales -->

	<script src = "js/material-modal.js"></script>
	<link rel="stylesheet/less" type="text/css" href="css/material-modal.less" />
	<link rel="stylesheet" href="css/docs.min.css">

	<!-- Material Design Colores -->

	<link rel="stylesheet" href = "css/material.min.css">

	<!-- Data Tables de JQuery -->
	<link rel="stylesheet" type="text/css" href="css/datatable.css"/>
 	<script type="text/javascript" src="js/datatable.js"></script>

	<!-- Ventanas modales material desing lite -->
	
	<script src = "js/showdialog.js"></script>

 	<!-- Fuente de Material Design Lite -->
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">

	<title>Inicio</title>
</head>
<body>
	<div class = "container-fluid">
		<div class = "row">
			<div class="col-xs-1 col-md-4"></div>
			<div class="col-xs-10 col-md-4">
				<div class = "formulario-login">
					<form method = "post" id = "login-aplicacion">
						<input type = "hidden" name = "accion" value = "login">
						<h4 class = "centrar">Inicio de Sesión</h4>
						<table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
							<tbody>
								<tr>
									<td colspan = "2">
										<div class = "flex login1">
											<span class="glyphicon glyphicon-user"></span> &nbsp; 
										</div>
										<div class = "flex login2">
											<input type = "hidden" name = "accion" value = "login">
											<input class = "form-control" type="text" name="usuario" placeholder="Usuario">	
										</div>
									</td>
								</tr>
								<tr>
									<td colspan = "2">
										<div class = "flex login1">
											<span class="glyphicon glyphicon-lock"></span>&nbsp; 
										</div>
										<div class = "flex login2">
											<input class = "form-control" type="password" name="passw" placeholder="Contraseña">
										</div>
									</td>
								</tr>
								<tr>
									<td style = "text-align:center;">
										<button type = "button" class="boton_registrar mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
											Registrarse
										</button>
									</td>
									<td style = "text-align:center;">
										<button type = "submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary">
											Iniciar Sesion
										</button>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>
			</div>
			<div class="col-xs-1 col-md-4"></div>
		</div>
		<div class = "mostrar_alerta">
			<div class="alert alert-danger alert-dismissable alerta_peligro">
			  	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			</div>	
		</div>
		<div class = "mostrar_alerta2">
			<div class="alert alert-success alert-dismissable alerta_tranquilo">
			  	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			</div>	
		</div>
		<div class = "cargando_modal">
			<div class = "capa1_modal">
				CARGANDO ...<br><br>
				<div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			var submitted;
			$("#login-aplicacion").submit(function(e){
				e.preventDefault();
				var formdata = new FormData(this);
				$.ajax({
					url : 'index.php',
					data : formdata,
					type : 'POST',
					cache: false,
					contentType: false,
					processData: false,
					success : function(data) {
						if(data.success==true){
							$(".mostrar_alerta2").css("display","block");
							$(".mostrar_alerta2 .alerta_tranquilo").append(data.mensaje);
							window.location.href = "procesos.php";
						}
						else{
							console.log(data);
							$(".mostrar_alerta").css("display","block");
							$(".mostrar_alerta .alerta_peligro").append(data.mensaje);
						}
						
					},
					error : function(data) {
						console.log(data);
						alert(data.mensaje);
					}
				});
			});
			$(".boton_registrar").click(function(e){
				e.preventDefault();
				$.ajax({
					url : 'formularios_manejar.php',
					data : {accion: "formulario_agregar_usuario"},
					type : 'POST',
					cache: false,
					/*contentType: false,
					processData: false,*/
					success : function(data) {
						if(data.success){
							showDialog({
						        // Aca se pinta el formulario html que agrega la sede
						        text: data.html, 
						        negative: {
						            title: 'Cerrar'
						        },
						        positive: {
						            title: 'Agregar Usuario',
						            onClick: function () {

						            	// Validacion de formulario
						            	
						            	var validator = $("#form-agregar-usuario").validate({
											rules: {
									        	doc_usu	: {
									            	required: true,
									            	number: true,
									            	minlength: 6
												},
												pass_usu	: {
									            	required: true,
									            	minlength: 6
												},
												mail_usu: {
									            	required: true,
									            	email: true
												},
												usu_usuario: {
									            	required: true,
									            	minlength:6
												},
												nombre1_usu: {
									            	required: true,
												},
												ape1_usu: {
									            	required: true,
												},
												telefono_usu: {
									            	required: true,
									            	digits:true
												},
												direccion_usu: {
									            	required: true,
												}
											},		
											messages: {
												doc_usu: {
											    	minlength: jQuery.validator.format("El numero de documento debe tener minimo {0} caracteres"),
											    	number: jQuery.validator.format("El numero de documento solo admite numeros"),
											    	required: jQuery.validator.format("El campo numero de documento es obligatorio")
												},
												pass_usu: {
											    	minlength: jQuery.validator.format("La contraseña debe tener minimo {0} caracteres"),
											    	required: jQuery.validator.format("Contraseña requerida")
												},
												mail_usu: {
													email: jQuery.validator.format("Debe ingresar un email valido"),
											    	required: jQuery.validator.format("El campo descripcion de proceso es obligatorio")
												},
												usu_usuario: {
											    	minlength: jQuery.validator.format("El nombre de usuario debe tener minimo {0} caracteres"),
											    	required: jQuery.validator.format("Es obligatorio el nombre de usuario")
												},
												nombre1_usu: {
											    	required: jQuery.validator.format("Nombre obligatorio")
												},
												ape1_usu: {
											    	required: jQuery.validator.format("Apellido obligatorio")
												},
												telefono_usu: {
											    	digits: jQuery.validator.format("El telefono solo debe contener numeros"),
											    	required: jQuery.validator.format("El numero de telefono es obligatorio")
												},
												direccion_usu: {
											    	required: jQuery.validator.format("Direccion obligatoria")
												}
											},//end messages
										    errorPlacement: function(error, element) {
										        if( element.is(':radio') || element.is(':checkbox')) {
										            error.appendTo(element.parent());
										        } else {
										            error.insertAfter(element);
										        }
										    },//end errorPlacement
										    showErrors: function(errorMap, errorList) {
										        if (submitted) {
										            var summary = "Tienes los siguientes errores:\n";
										            $.each(errorList, function() { 
										            	summary += " * " + this.message + "\n"; 
										            });
										            submitted = false;
										        	alert(summary);
										        }
										        this.defaultShowErrors();
										    },     
										    invalidHandler: function(form, validator) {
										        submitted = true;
										    }
										});

										// Comprobamos si todas las validaciones se cumplen para enviar el formulario
										
										var validator = $("#form-agregar-usuario").valid();
										if(validator){
											var form = $('#form-agregar-usuario')[0];
							            	var formData = new FormData(form);
											$.ajax({
												url : 'index.php',
												data : formData,
												type : 'POST',
												cache: false,
												//dataType: 'json',
												contentType: false,
												processData: false,
												success : function(data) {
													if(data.success == true){
														$(".mostrar_alerta2 .texto_aviso").empty();
														$(".mostrar_alerta2").css("display","block");
														$(".mostrar_alerta2 .alerta_tranquilo").append(data.mensaje);
													}
													else{
														$(".mostrar_alerta .texto_aviso").empty();
														$(".mostrar_alerta").css("display","block");
														$(".mostrar_alerta .alerta_tranquilo").append(data.mensaje);
													}
													
												},
												error : function(data) {
													console.log(data);
													alert(data.mensaje);
												}
											});
										}				            	
						            }
						        }
						    });
						}
						else{
							console.log(data);
							alert(data.mensaje);	
						}
						
					},
					error : function(data) {
						console.log(data);
						alert(data.mensaje);
					}
				});
			});
		});
	</script>
</body>
</html>