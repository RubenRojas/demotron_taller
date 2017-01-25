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

if(!in_array("3", $pUser)){ //actualizar
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/taller/maquinaria/index.php";
	header("location: /taller/error/index.php");
}

print_head();
print_menu();

?>

<div class="container_form">
	<div class="row">
		<h3 class="center">Actualizar Hr / Km Maquina</h3>
		<form action="forms/update_km_hr.php" method="post">

			<div class="col s4 input-field">
				<label for="equipo" class="active">Codigo Equipo</label>
				<select name="equipo" id="equipo" onchange="setDatosMaquina(this.value)">
					<option value=""></option>
					<?=show_option_campos("maquina", "", array("id, codigo"), array(), array("order by"=>"codigo asc"), $mysqli)?>
				</select>
			</div>
			
			<div class="col s8 input-field">
				<label class="active">Datos </label>
				<span class="dato" id="datos"></span>
			</div>
			<div class="col s12">
				<div class="col s4 input-field">
					<label for="placa">KM Actual</label>
					<input type="text" name="km" id="placa">
				</div>
				<div class="col s4 input-field">
					<label for="codigo">HR. Actual</label>
					<input type="text" name="hr" id="codigo">
				</div>
			</div>
			
			<div class="col s12" style="margin-top: 50px">
				<input type="hidden" name="id" id="id">
				<a href="Javascript:history.back()" class="btn left red">Volver</a>
				<input type="submit" value="Guardar" class="btn right indigo">
			</div>


		</form>
	</div>
</div>

<?=print_footer();?>