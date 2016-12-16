<?php
if(is_dir("/var/www/html/taller")){
	$baseDir = "/var/www/html/taller/includes/";
}
else{
	$baseDir = "c:/wamp/www/taller/includes/";
}

include($baseDir."conexion.php");
extract($_POST);


$id_usuario = insert("maquina", $_POST, $mysqli);


$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Se ha registrado una nueva maquina correctamente";

header("Location: ../index.php");