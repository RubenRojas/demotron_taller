<?php
if(is_dir("/var/www/html/taller")){
	$baseDir = "/var/www/html/taller/includes/";
}
else{
	$baseDir = "c:/wamp/www/taller/includes/";
}

include($baseDir."conexion.php");
extract($_GET);

$query = "select marca, modelo, anio, placa, codigo from maquina where id='$id' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
echo $arr['marca']." ".$arr['modelo']." ".$arr['anio']." ---  <b>".$arr['placa']."</b> [".$arr['codigo']."]";