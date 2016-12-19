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

if(!in_array("3", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/taller/maquinaria/index.php";
	header("location: /taller/error/index.php");
}

extract($_GET); //id

$query = "select * from maquina where id='$id' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();

print_head();
print_menu();

?>

<div class="container_form">
	<div class="row">
		<h3 class="center">Editar Maquina</h3>
		<form action="forms/update.php" method="post">

			<div class="col s4 input-field">
				<label for="equipo" class="active">Equipo</label>
				<select name="equipo" id="equipo">
					<?=show_option("tipo_maquina", $arr['equipo'], $mysqli)?>
				</select>
			</div>
			
			<div class="col s3 input-field">
				<label for="marca">Marca</label>
				<input type="text" name="marca" value="<?=$arr['marca']?>" id="marca">
			</div>
			<div class="col s2 input-field">
				<label for="placa">Placa</label>
				<input type="text" name="placa" value="<?=$arr['placa']?>" id="placa">
			</div>
			<div class="col s2 input-field">
				<label for="codigo">Codigo</label>
				<input type="text" name="codigo" value="<?=$arr['codigo']?>" id="codigo">
			</div>
			<div class="col s3 input-field">
				<label for="modelo">Modelo</label>
				<input type="text" name="modelo" value="<?=$arr['modelo']?>" id="modelo">
			</div>
			<div class="col s3 input-field">
				<label for="anio">Año</label>
				<input type="text" name="anio" value="<?=$arr['anio']?>" id="anio">
			</div>
			<div class="col s3 input-field">
				<label for="chasis">N° Chasis</label>
				<input type="text" name="chasis" value="<?=$arr['chasis']?>" id="chasis">
			</div>
			<div class="col s3 input-field">
				<label for="serie">N° Serie</label>
				<input type="text" name="serie" value="<?=$arr['serie']?>" id="serie">
			</div>
			<div class="col s3 input-field">
				<label for="modelo_motor">Modelo Motor</label>
				<input type="text" name="modelo_motor" value="<?=$arr['modelo_motor']?>" id="modelo_motor">
			</div>
			<div class="col s3 input-field">
				<label for="kilometraje">Kilometraje</label>
				<input type="text" name="kilometraje" value="<?=$arr['kilometraje']?>" id="kilometraje">
			</div>
			<div class="col s3 input-field">
				<label for="horometro">Horometro</label>
				<input type="text" name="horometro" value="<?=$arr['horometro']?>" id="horometro">
			</div>
			<div class="col s3 input-field">
				<label for="estado" class="active">Estado</label>
				<select name="estado" id="estado" id="">
					<?=show_option("taller_maquina_estado", $arr['estado'], $mysqli)?>
				</select>
			</div>
			<div class="col s3 input-field">
				<label for="faena" class="active">Faena</label>
				<select name="faena" id="faena" id="">
					<?=show_option("centro_costo", $arr['faena'], $mysqli)?>
				</select>
			</div>
			<div class="col s3 input-field">
				<label for="chofer">Chofer</label>
				<input type="text" name="chofer" value="<?=$arr['chofer']?>" id="chofer">
			</div>

			<div class="col s12 input-field">
				<label for="observaciones" class="active">Observaciones</label>
				<textarea name="observaciones" id="observaciones" id="" cols="30" rows="10"><?=$arr['observaciones']?></textarea>
			</div>
			<div class="col s12" style="margin-top: 50px">
				<input type="hidden" name="id" value="<?=$arr['id']?>">
				<a href="Javascript:history.back()" class="btn left red">Volver</a>
				<input type="submit" value="Guardar" class="btn right indigo">
			</div>


		</form>
	</div>
</div>


<?=print_footer();?>