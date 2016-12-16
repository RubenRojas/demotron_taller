<?php
if(is_dir("/var/www/html/taller")){
	$baseDir = "/var/www/html/taller/includes/";
}
else{
	$baseDir = "c:/wamp/www/taller/includes/";
}
include($baseDir."conexion.php");

if(isset($_SESSION['id'])){
	$objeto = getObjetoByNombre('MAQUINARIA', $mysqli);
	$pUser = getPermisosObjeto($_SESSION['id'], $objeto['id'], $mysqli);
	/* 1:CREATE,  2:READ,  3:UPDATE,  4:DELETE */
}
else{
	header("Location: /taller/index.php");
}

if(!in_array("2", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/taller/index.php";
	header("location: /taller/error/index.php");
}

extract($_GET); //id

$query = "select * from maquina where id='$id' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();

print_head();
print_menu();

?>

<div class="container">
	<div class="row">
		<h3 class="center">Detalle Maquina</h3>
		
		<div class="row">
			<div class="col s5 input-field">
				<label class="active">Equipo</label>
				<span class="dato"><?=get_campo("tipo_maquina", "nombre", $arr['equipo'], $mysqli)?></span>
				
			</div>
			
			<div class="col s3 m3 input-field">
				<label class="active">Marca</label>
				<span class="dato"><?=$arr['marca']?></span>
			</div>
			<div class="col s2 input-field">
				<label class="active">Placa</label>
				<span class="dato"><?=$arr['placa']?></span>
			</div>
			<div class="col s2 m2 input-field">
				<label class="active">Codigo</label>
				<span class="dato"><?=$arr['codigo']?></span>
			</div>
			<div class="col s3 m3 input-field">
				<label class="active">Modelo</label>
				<span class="dato"><?=$arr['modelo']?></span>
			</div>
			<div class="col s2 m3 input-field">
				<label class="active">Año</label>
				<span class="dato"><?=$arr['anio']?></span>
			</div>
			<div class="col s4 m3 input-field">
				<label class="active">N° Chasis</label>
				<span class="dato"><?=$arr['chasis']?></span>
			</div>
			<div class="col s3 m3 input-field">
				<label class="active">N° Serie</label>
				<span class="dato"><?=$arr['serie']?></span>
			</div>
			<div class="col s4 m3 input-field">
				<label class="active">Modelo Motor</label>
				<span class="dato"><?=$arr['modelo_motor']?></span>
			</div>
			<div class="col s3 m3 input-field">
				<label class="active">Kilometraje</label>
				<span class="dato"><?=$arr['kilometraje']?></span>
			</div>
			<div class="col s2 m3 input-field">
				<label class="active">Horometro</label>
				<span class="dato"><?=$arr['horometro']?></span>
			</div>
			<div class="col s3 m3 input-field">
				<label class="active">Estado</label>
				<span class="dato"><?=get_campo("taller_maquina_estado", "nombre", $arr['estado'], $mysqli)?></span>
				
			</div>
			<div class="col s4 m3 input-field">
				<label class="active">Faena</label>
				<span class="dato"><?=get_campo("centro_costo", "nombre", $arr['faena'], $mysqli)?></span>
				
			</div>
			<div class="col s4 m3 input-field">
				<label class="active">Chofer</label>
				<span class="dato"><?=$arr['chofer']?></span>
			</div>

			<div class="col s12 input-field">
				<label class="active">observaciones</label>
				<span class="dato"><?=$arr['observaciones']?></span>
				
			</div>
			
		
		</div>
		
		<div class="row historial">
			<h5 class="center">Historial de Mantenciones</h5>
			<h6 class="center" style="margin-top: 20px;">No existen mantenciones registradas para esta máquina.</h6>
		</div>



		<div class="col s12" style="margin-top: 50px">
			<a href="Javascript:history.back()" class="btn left red">Volver</a>
			<a href="Javascript:window.print();" class="btn right indigo">Imprimir</a>
		</div>
	</div>
</div>





<?=print_footer();?>