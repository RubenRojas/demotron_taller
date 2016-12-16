<?php
if(is_dir("/var/www/html/taller")){
	$baseDir = "/var/www/html/taller/includes/";
}
else{
	$baseDir = "c:/wamp/www/taller/includes/";
}

include($baseDir."conexion.php");
extract($_POST);


deleteDB("taller_usuario", array("id"=>$id), array("limit"=>"1"), $mysqli);
deleteDB("taller_usuario_permiso", array("usuario"=>$id), array(), $mysqli);

$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Usuario ".$nombre." ha sido eliminado del sistema";

header("Location: ../index.php");