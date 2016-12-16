<?php
function getObjeto($objeto, $mysqli){
	$lista = select("taller_app_".$objeto, array("id, nombre"), array(), array("order by"=>"nombre asc"), $mysqli);
	return $lista;
}

function getObjetoByNombre($objeto, $mysqli){
	$lista = select("taller_app_objeto", array("id, nombre"), array("nombre"=>$objeto), array("limit"=>"1"), $mysqli);
	return $lista;
}