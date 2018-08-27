<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Procesos - Prueba Tecnica</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- CSS Personalizado -->

		<link rel="stylesheet" href = "css/style.css">

		<!-- JQuery -->

		<script src = "js/jquery.js"></script>

		<!-- JQuery validate forms-->

		<script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
		<script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>

		<!-- JQuery UI -->

		<link data-require="jqueryui@*" data-semver="1.10.0" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/css/smoothness/jquery-ui-1.10.0.custom.min.css" />
	    <script data-require="jqueryui@*" data-semver="1.10.0" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/jquery-ui.js"></script>

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
		<link rel = "stylesheet" href = "css/mdl-jquery-modal-dialog.css">

		

		<!-- Material Design Colores -->

		<link rel="stylesheet" href = "css/material.min.css">

		<!-- Data Tables de JQuery -->
		<link rel="stylesheet" type="text/css" href="css/datatable.css"/>
	 	<script type="text/javascript" src="js/datatable.js"></script>

		<!-- Ventanas modales material desing lite -->
		
		<script src = "js/showdialog.js"></script>

	 	<!-- Fuente de Material Design Lite -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
		<!-- TinyMCE para textareas -->

		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
		<script type="text/javascript">
		tinymce.init({
    		selector: "#descr_servicio2, #descr_servicio",
			theme: "modern",
			
			toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview fullpage | forecolor backcolor emoticons",
			plugins: [
		         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
		         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
		         "save table contextmenu directionality emoticons template paste textcolor"],
			language: 'es_MX',
			height: '400px',
			setup: function (editor) {
		        editor.on('change', function () {
		            tinymce.triggerSave();
		        });
		    }
		});
		</script>
	</head>
	<body>
		<!-- Always shows a header, even in smaller screens. -->
		<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
			<header class="mdl-layout__header">
				<div class="mdl-layout__header-row">
				  <!-- Title -->
					<span class="mdl-layout-title">Prueba Tecnica</span>
					<!-- Add spacer, to align navigation to the right -->
					<div class="mdl-layout-spacer"></div>
					<!-- Navigation. We hide it in small screens. -->
					<nav class="mdl-navigation mdl-layout--large-screen-only">
						<a class="mdl-navigation__link" href="procesos.php">Procesos</a>
						<a class="mdl-navigation__link" href="logout.php">Cerrar Sesión</a>
					</nav>
				</div>
			</header>
			<div class="mdl-layout__drawer">
				<span class="mdl-layout-title">Title</span>
				<nav class="mdl-navigation">
					<a class="mdl-navigation__link" href="procesos.php">Procesos</a>
					<a class="mdl-navigation__link" href="logout.php">Cerrar Sesión</a>
				</nav>
			</div>
			<main class="mdl-layout__content">
				<div class="page-content">