<?php
if(is_dir("/var/www/html/taller")){
	$baseDir = "/var/www/html/taller/includes/";
}
else{
	$baseDir = "c:/wamp/www/taller/includes/";
}
include($baseDir."conexion.php");

extract($_POST);

$query = "select * from taller_usuario where correo='$correo' and pass='$pass' limit 1";
$result = $mysqli->query($query);

if($result->num_rows > 0){
	$arr = $result->fetch_assoc();
	$_SESSION['id'] = $arr['id'];
	$_SESSION['nombre'] = $arr['nombre'];
	$_SESSION['mensaje']['texto'] = "Bienvenido ".$arr['nombre'];
	header("Location: /taller/principal.php");
}
else{
	$_SESSION['error']['location'] = "/taller/login";
	$_SESSION['error']['mensaje'] = "Datos Incorrectos, intente nuevamente";
	header("Location: /taller/error/index.php");
}