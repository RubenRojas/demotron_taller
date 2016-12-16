<?php
if(is_dir("/var/www/html/taller")){
	$baseDir = "/var/www/html/taller/includes/";
}
else{
	$baseDir = "c:/wamp/www/taller/includes/";
}

include($baseDir."conexion.php");
extract($_POST);

$campos = array("nombre"=>$nombre, "correo"=>$correo, "pass"=>$pass);

update("taller_usuario", $campos, array("id"=>$id), array("limit"=>"1"), $mysqli);
deleteDB("taller_usuario_permiso", array("usuario"=>$id), array(), $mysqli);


$permisos = $_POST["permiso"];
if(count($permisos)>0){
	foreach ($permisos as $permiso) {
		$data = explode("_", $permiso);
		
		insert("taller_usuario_permiso", array("objeto"=>$data[0], "permiso"=>$data[1], "usuario"=>$id), $mysqli);
	}
}
$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Usuario ".$nombre." ha sido actualizado correctamente";

header("Location: ../index.php");