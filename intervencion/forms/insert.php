<?php
if(is_dir("/var/www/html/taller")){
	$baseDir = "/var/www/html/taller/includes/";
}
else{
	$baseDir = "c:/wamp/www/taller/includes/";
}

include($baseDir."conexion.php");
extract($_POST);

$campos = array(
	"id_maquina"=>$id_maquina, 
	"kilometraje"=>$kilometraje, 
	"horometro"=>$horometro, 
	"fecha"=>$fecha, 
	"turno"=>$turno, 
	"hora_inicio"=>$hora_inicio, 
	"hora_termino"=>$hora_termino, 
	"horas_totales"=>$horas_totales, 
	"valor_horas"=>$valor_horas, 
	"tipo_intervencion"=>$tipo_intervencion, 
	"valor_total"=>$valor_total, 
	"observaciones"=>$observaciones, 
	"mecanico_1"=>$mecanico_1,
	"mecanico_2"=>$mecanico_2,
	"mecanico_3"=>$mecanico_3,
	"prox_km"=>$prox_km,
	"prox_hr"=>$prox_hr,
	"tipo_mantencion"=>$tipo_mantencion,
	"tipo_prox_mant"=>$tipo_prox_mant
);

$id_intervencion = insert("taller_intervencion", $campos, $mysqli);

for ($i=1; $i <= 10; $i++) { 
	$campos = array(
		"tipo_trabajo"=>$_POST["trabajo_".$i."_tipo"],
		"detalle"=>$_POST["trabajo_".$i."_detalle"],
		"valor"=>$_POST["trabajo_".$i."_valor"],
		"id_intervencion"=>$id_intervencion
	);
	if($_POST["trabajo_".$i."_detalle"]!= ""){
		insert("taller_intervencion_trabajo", $campos, $mysqli);	
	}
}

update("maquina",array("horometro"=>$horometro, "kilometraje"=>$kilometraje), array("id"=>$id_maquina), array("limit"=>"1"), $mysqli);


for ($i=1; $i <= 100; $i++) { 
	$campos = array(
		"cantidad"=>$_POST["lubricante_".$i."_cantidad"],
		"tipo"=>$i,
		"valor_unitario"=>$_POST["lubricante_".$i."_valor"],
		"id_intervencion"=>$id_intervencion
	);
	if($_POST["lubricante_".$i."_cantidad"]!= ""){
		insert("taller_intervencion_lubricantes", $campos, $mysqli);	
	}
}

$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Se ha registrado una nueva intervención correctamente";

header("Location: ../index.php");