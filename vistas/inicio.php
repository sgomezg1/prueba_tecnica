<?php include("navbar.php");?>
<div class = "container-fluid">
	<div class = "row">
		<div class="col-xs-0"></div>
		<div class="col-xs-12">
			<h2 class = "color_azul">Administración Procesos</h2>

			<div class = "contenedor_fechas">
				<label>Ingrese un rango de fechas</label><br>
				<div class = "width_minimo">
					<p id="date_filter">
					    <span id="date-label-from" class="date-label">Desde: </span><input class="date_range_filter date" type="text" id="datepicker_from" />
					</p>
				</div>
				<div class = "width_minimo">
					<p id="date_filter">
					    <span id="date-label-from" class="date-label">Hasta: </span><input class="date_range_filter date" type="text" id="datepicker_to" />
					</p>
				</div>
			</div>
			<table style = "width:100%;" id = "datatablaProcesos" class = "table  borderless anchofull">
				<thead>
					<tr>
						<th class = "fondo_diferente_tabla">Numero Proceso</th>
						<th class = "fondo_diferente_tabla">Descripcion Proceso</th>
						<th class = "fondo_diferente_tabla">Fecha Creacion</th>
						<th class = "fondo_diferente_tabla">Sede</th>
						<th class = "fondo_diferente_tabla">Precio</th>
						<th class = "fondo_diferente_tabla">Precio Dolares</th>
						<th class = "fondo_diferente_tabla"></th>
						<th class = "fondo_diferente_tabla"></th>
						<th class = "fondo_diferente_tabla">
							<button class="agregar_proceso mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
							    Agregar Proceso
							</button>
						</th>
					</tr>
				</thead>

				<tbody>
				</tbody>
			</table>
		</div>
		<div class="col-xs-0"></div>
	</div>
</div>
<div class = "avisos_al_actualizar">
	<span class="mdl-chip mdl-chip--deletable">
	    <span class="mdl-chip__text texto_aviso"></span>
	    <button type="button" class="mdl-chip__action"><img class = "cerrar_equis" src = "img/cerrar_aviso.png"></button>
	</span>
</div>
<script>
	$(document).ready(function(){
		var submitted;
		var datatablaProcesos = $('#datatablaProcesos').DataTable({
			'columns': [{
			  'data': 'num_proc',
			  "render": function ( data, type, full, meta ) {
					return '<a href = "detalle.php?num_proc='+data+'">'+data+'</a>';
			    }
			},{
			   'data': 'desc_proc',
			   "render": function ( data, type, full, meta ) {
			   		if(data.length>50){
			   			return data.substring(0,50)+" ...";
			   		} else {
			   			return data;
			   		}
			    }
			},{
			   'data': 'fecha_creacion'
			},{
			   'data': 'sede'
			},{
			   'data': 'pres_proc'
			},{
			   'data': 'precio_dolares'
			},{
				'data': 'num_proc',
				"render": function ( data, type, full, meta ) {
					return '<img data-proceso = '+data+' class = "editar_proceso" src = "img/editar.png"><br>Editar Proceso';
			    }
			},{
			   'data': 'num_proc',
			   "render": function ( data, type, full, meta ) {
					return '<img data-proceso = '+data+' class = "eliminar_proceso" src = "img/eliminar.png"><br>Eliminar Proceso';
			    }
			},{
				'data': 'estado_proceso',
				"render": function ( data, type, full, meta ) {
					if(data == "Habilitado"){
						return '<label class="switch"><input class = "hab_deshab_proceso" data-proceso = "'+full.num_proc+'" data-habilitado = "'+full.estado_proceso+'" type="checkbox" checked><span class="slider round"></span></label><br>Habilitar/Deshabilitar';
					} else {
						return '<label class="switch"><input class = "hab_deshab_proceso" data-proceso = "'+full.num_proc+'" data-habilitado = "'+full.estado_proceso+'" type="checkbox"> <span class="slider round"></span> </label><br>Habilitar/Deshabilitar'; }
			    }
			}],
			"ajax":{
				"url":"index.php",
				"data": {"accion": 'todos_procesos'},
				"dataSrc":"",
				"type": "post",
				"dataType": 'JSON'
			},
			"oLanguage": {
				"sSearch": "Buscar: ",
				"sProcessing":    "Procesando...",
				"sLengthMenu":    "Mostrar _MENU_ registros",
				"sZeroRecords":   "No se encontraron resultados",
				"sEmptyTable":    "Ningún dato disponible en esta tabla",
				"sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				"sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
				"sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
				"sInfoPostFix":   "",
				"sSearch":        "Buscar:",
				"sUrl":           "",
				"sInfoThousands":  ",",
				"sLoadingRecords": "Cargando...",
				"oPaginate": {
					"sFirst":    "Primero",
					"sLast":     "Ultimo",
					"sNext":     "Siguiente",
					"sPrevious": "Anterior"
				},
		        
			},		
		});
		$("#datepicker_from").datepicker({
			showOn: "button",
			buttonImage: "img/calendar.png",
			buttonImageOnly: false,
			"onSelect": function(date) {
				maxDateFilter = new Date(date).getTime();
				datatablaProcesos.draw();
			}
			}).keyup(function() {
				maxDateFilter = new Date(this.value).getTime();
				datatablaProcesos.draw();
			});

		$("#datepicker_to").datepicker({
			showOn: "button",
			buttonImage: "img/calendar.png",
			buttonImageOnly: false,
			"onSelect": function(date) {
				maxDateFilter = new Date(date).getTime();
				datatablaProcesos.draw();
			}
			}).keyup(function() {
				maxDateFilter = new Date(this.value).getTime();
				datatablaProcesos.draw();
			});
			

		// Date range filter
		minDateFilter = "";
		maxDateFilter = "";

		$.fn.dataTableExt.afnFiltering.push(
			function(oSettings, aData, iDataIndex) {
				if (typeof aData._date == 'undefined') {
					aData._date = new Date(aData[2]).getTime();
				}

				if (minDateFilter && !isNaN(minDateFilter)) {
					if (aData._date < minDateFilter) {
						return false;
					}
				}

				if (maxDateFilter && !isNaN(maxDateFilter)) {
					if (aData._date > maxDateFilter) {
						return false;
					}
				}

				return true;
			}
		);
		$("#datatablaProcesos").on('click', ".agregar_proceso", function(e){
			e.preventDefault();
			$.ajax({
				url : 'formularios_manejar.php',
				data : {accion: "formulario_agregar_proceso"},
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
					            title: 'Agregar Proceso',
					            onClick: function () {

					            	// Validacion de formulario
					            	
					            	$("#form-agregar-proceso").validate({
										rules: {
								        	num_proc: {
								            	required: true,
								            	maxlength: 8,
								            	minlength: 8,
											},
											pres_proc: {
								            	required: true,
      											number: true
											},
											desc_proc: {
								            	required: true
											},
										},		
										messages: {
											num_proc: {
										    	minlength: jQuery.validator.format("El campo numero de proceso debe tener minimo {0} caracteres"),
										    	maxlength: jQuery.validator.format("El campo numero de proceso debe tener maximo {0} caracteres"),
										    	required: jQuery.validator.format("El campo numero de proceso es obligatorio")
											},
											pres_proc: {
										    	number: jQuery.validator.format("Solo se aceptan numeros en el campo del precio del proceso"),
										    	required: jQuery.validator.format("El campo precio de proceso es obligatorio")
											},
											desc_proc: {
										    	required: jQuery.validator.format("El campo descripcion de proceso es obligatorio")
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
									
									var validator = $("#form-agregar-proceso").valid();
									if(validator){
										var form = $('#form-agregar-proceso')[0];
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
													$(".avisos_al_actualizar .texto_aviso").empty();
													$(".avisos_al_actualizar").css("display","block");
													$(".avisos_al_actualizar .texto_aviso").append(data.mensaje);
													datatablaProcesos.ajax.reload();
												}
												else{
													$(".avisos_al_actualizar .texto_aviso").empty();
													$(".avisos_al_actualizar").css("display","block");
													$(".avisos_al_actualizar .texto_aviso").append(data.mensaje);
													datatablaProcesos.ajax.reload();
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
		
		$("#datatablaProcesos").on('click', ".editar_proceso", function(e){
			tinymce.triggerSave();
			e.preventDefault();
			$.ajax({
				url : 'formularios_manejar.php',
				data : {accion: "formulario_editar_proceso", num_proc:$(this).attr("data-proceso")},
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
					            title: 'Guardar Cambios',
					            onClick: function () {
					            	$("#form-editar-proceso").validate({
										rules: {
											pres_proc: {
								            	required: true,
      											number: true
											},
											desc_proc: {
								            	required: true
											},
										},		
										messages: {
											pres_proc: {
										    	number: jQuery.validator.format("Solo se aceptan numeros en el campo del precio del proceso"),
										    	required: jQuery.validator.format("El campo precio de proceso es obligatorio")
											},
											desc_proc: {
										    	required: jQuery.validator.format("El campo descripcion de proceso es obligatorio")
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
									
									var validator = $("#form-editar-proceso").valid();
									if(validator){
										var form = $('#form-editar-proceso')[0];
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
													$(".avisos_al_actualizar .texto_aviso").empty();
													$(".avisos_al_actualizar").css("display","block");
													$(".avisos_al_actualizar .texto_aviso").append(data.mensaje);
													datatablaProcesos.ajax.reload();
												}
												else{
													$(".avisos_al_actualizar .texto_aviso").empty();
													$(".avisos_al_actualizar").css("display","block");
													$(".avisos_al_actualizar .texto_aviso").append(data.mensaje);
													datatablaProcesos.ajax.reload();
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
		$("#datatablaProcesos").on('click', ".eliminar_proceso", function(e){
			$.ajax({
				url : 'index.php',
				data : {accion: "eliminar_proceso", num_proc: $(this).attr("data-proceso")},
				type : 'POST',
				cache: false,
				//dataType: 'json',
				/*contentType: false,
				processData: false,*/
				success : function(data) {
					if(data.success == true){
						$(".avisos_al_actualizar .texto_aviso").empty();
						$(".avisos_al_actualizar").css("display","block");
						$(".avisos_al_actualizar .texto_aviso").append(data.mensaje);
						datatablaProcesos.ajax.reload();
					}
					else{
						$(".avisos_al_actualizar .texto_aviso").empty();
						$(".avisos_al_actualizar").css("display","block");
						$(".avisos_al_actualizar .texto_aviso").append(data.mensaje);
						datatablaProcesos.ajax.reload();
					}
					
				},
				error : function(data) {
					console.log(data);
					alert(data.mensaje);
				}
			});
		});
		$("#datatablaProcesos").on('click', ".hab_deshab_proceso", function(e){
			$.ajax({
				url : 'index.php',
				data : {accion: "hab_desah_proceso", num_proc:$(this).attr("data-proceso"), estado_proceso: $(this).attr("data-habilitado")},
				type : 'POST',
				cache: false,
				//dataType: 'json',
				contentType: false,
				processData: false,
				success : function(data) {
					if(data.success == true){
						$(".avisos_al_actualizar .texto_aviso").empty();
						$(".avisos_al_actualizar").css("display","block");
						$(".avisos_al_actualizar .texto_aviso").append(data.mensaje);
						datatablaProcesos.ajax.reload();
					}
					else{
						$(".avisos_al_actualizar .texto_aviso").empty();
						$(".avisos_al_actualizar").css("display","block");
						$(".avisos_al_actualizar .texto_aviso").append(data.mensaje);
						datatablaProcesos.ajax.reload();
					}
					
				},
				error : function(data) {
					console.log(data);
					alert(data.mensaje);
				}
			});
		});
		$(".cerrar_equis").click(function(e){
			$(".avisos_al_actualizar").css("display","none");
		});
	});
</script>
<?php include("footer.php");?>