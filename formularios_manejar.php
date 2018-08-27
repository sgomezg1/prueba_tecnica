<?php
$carpetaControladores = "formularios_modales/";
$controladorPredefinido = "formularios";
$accionPredefinida = "formulario_agregar_servicio";
$_POST = $_REQUEST;
if(! empty($_POST['controlador'])){
      $controlador = $_POST['controlador'];}
else{
      $controlador = $controladorPredefinido;
}
if(! empty($_POST['accion'])){
      $accion = $_POST['accion'];}
else{
     $accion = $accionPredefinida;
}
$controlador = $carpetaControladores . $controlador . '.php';

if(is_file($controlador))
{
      require_once $controlador;
	  $control=new formularios();
}
else
{
      die('El controlador no existe - 404 not found');
}

if(method_exists($control,$accion)){
      $control->$accion();
}
else{
      die('La accion no existe - 404 not found');
}
?>