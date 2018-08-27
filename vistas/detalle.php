<?php include("navbar.php"); ?>
	<?php
		foreach($detalle_proceso as $detalle){
			?>
			<div class = "container_fluid">
				<div class = "col-xs-0"></div>
				<div style = "text-align: center;"class = "col-xs-12">
					<h2>DETALLE PROCESO:</h2>
					<h5>NUMERO_PROCESO: <?php echo $detalle['num_proc'];?></h5>
					<label>PRECIO PROCESO: <?php echo $detalle['pres_proc'];?></label><br>
					<label>PRECIO DOLARES: <?php echo $detalle['precio_dolares'];?></label><br>
					<label>FECHA CREACION: <?php echo $detalle['fecha_creacion'];?></label><br><br>
					<h5>DESCRIPCION PROCESO:</h5>
					<p><?php echo $detalle['desc_proc']; ?></p>
					<button class = "btn btn-md btn-success" type = "button" id = "boton_volver">VOLVER</button>
				</div>
				<div class = "col-xs-0"></div>
			</div>

			<?php
		}
	?>
	<script>
		$(document).ready(function(){
			$("#boton_volver").click(function(){
				window.location.href="procesos.php";
			});
		});
	</script>
<?php include("footer.php"); ?>