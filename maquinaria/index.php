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

print_head();
print_menu();
extract($_GET);

$query = "select maquina.id,
tipo_maquina.nombre as equipo,
maquina.marca,
maquina.placa,
maquina.codigo,
centro_costo.nombre as faena,
taller_maquina_estado.nombre as estado,
maquina.anio 

from maquina 
inner join tipo_maquina on maquina.equipo = tipo_maquina.id
inner join centro_costo on maquina.faena = centro_costo.id
inner join taller_maquina_estado on maquina.estado = taller_maquina_estado.id
where 1=1
";
if($estado!=""){
	$query.="and maquina.estado='$estado'";
}
if($faena!=""){
	$query.="and maquina.faena='$faena'";
}

if($tipo_maquina!=""){
	$query.="and maquina.equipo='$tipo_maquina'";
}

$query.=" order by maquina.codigo asc, tipo_maquina.nombre asc ";
$result = $mysqli->query($query);

?>
<div class="container">
	<h3 class="center">Listado de Maquinarias</h3>
	<a href="nuevo.php" class="btn btn_sys right btn_nuevo">Nueva Maquina</a>
	<a href="Javascript:window.print();" class="btn right indigo" style="margin-right: 10px;">Imprimir</a>
	<div class="row">


		<div class="filtros" style="background: #eaeaea; display: inline-block; width: 100%; padding: 20px; margin-bottom: 15px; border-radius: 3px; ">
			<h5 class="center">Filtros</h5>
			<form action="" method="get">
				<div class="col s3 input-field">
					<select name="estado" id="estado">
						<?=show_option("taller_maquina_estado", $estado, $mysqli)?>
					</select>
					<label for="estado">Estado</label>
				</div>
				<div class="col s3 input-field">
					<select name="faena" id="faena">
						<?=show_option("centro_costo", $faena, $mysqli)?>
					</select>
					<label for="faena">Faena</label>
				</div>
				<div class="col s3 input-field">
					<select name="tipo_maquina" id="Equipo">
						<?=show_option("tipo_maquina", $tipo_maquina, $mysqli)?>
					</select>
					<label for="Equipo">Equipo</label>
				</div>
				<div class="col s12">
					<input type="submit" value="Filtrar" class="btn indigo right">
				</div>
				
			</form>
		</div>
		<div class="detalle_filtro">
			<div class="col s6 m4">
				<label for="">Faena</label>
				<span class="dato"><?=get_campo("centro_costo", "nombre", $faena, $mysqli)?></span>
			</div>
			<div class="col s6 m4">
				<label for="">Estado</label>
				<span class="dato"><?=get_campo("taller_maquina_estado", "nombre", $estado, $mysqli)?></span>
			</div>
		</div>
	</div>

	<table id="listado" class="bordered striped" style="font-size: 0.82em;">
		<thead>
			<th>Codigo</th>
			<th>Equipo</th>
			<th>Marca</th>
			<th>Placa</th>
			<th>Año</th>
			<th>Estado</th>
			<th>Faena</th>
			<th width="5%" class="hide-on-print">Detalle</th>
			<th width="5%" class="hide-on-print">Editar</th>
		</thead>
		<tbody>
	<?php
	$arr = array();
	while ($arr = $result->fetch_assoc()) {
		?>
			<tr>
				<td><?=$arr['codigo']?></td>
				<td><?=$arr['equipo']?></td>
				<td><?=$arr['marca']?></td>
				<td class="center"><?=$arr['placa']?></td>
				<td class="center"><?=$arr['anio']?></td>
				<td class="center"><?=$arr['estado']?></td>
				<td class="center"><?=$arr['faena']?></td>
				<td class="hide-on-print center"><a href="detalle.php?id=<?=$arr['id']?>">Detalle</a></td>
				<td class="hide-on-print center"><a href="editar.php?id=<?=$arr['id']?>">Editar</a></td>
			</tr>
		<?php
	}
	?>
		</tbody>
	</table>
	
</div>

<?php
print_footer();
?>