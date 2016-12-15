<?php
if(is_dir("/var/www/html/taller")){
	$baseDir = "/var/www/html/taller/includes/";
}
else{
	$baseDir = "c:/wamp/www/taller/includes/";
}

include($baseDir."conexion.php");

if($_SESSION['id']== ""){
	header("Location: login/index.php");
}
else{
	header("Location: principal.php");
}