<?php
if(is_dir("/var/www/html/taller")){
	$baseDir = "/var/www/html/taller/includes/";
}
else{
	$baseDir = "c:/wamp/www/taller/includes/";
}

include($baseDir."conexion.php");
extract($_POST);

update("centro_costo" ,$_POST, array("id"=>$id), array("limit"=>"1"), $mysqli);



$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Se ha actualizado el Centro de Costo correctamente";

header("Location: ../index.php");