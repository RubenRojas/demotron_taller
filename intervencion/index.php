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

$query = "select 
taller_intervencion.id,
maquina.codigo as equipo,
maquina.placa,
taller_intervencion.fecha,
taller_intervencion_tipo.nombre as tipo_mant,
taller_intervencion.valor_total
from taller_intervencion
inner join maquina on maquina.id = taller_intervencion.id_maquina
inner join taller_intervencion_tipo on taller_intervencion_tipo.id = taller_intervencion.tipo_intervencion
order by fecha desc";


$result = $mysqli->query($query);

?>
<div class="container">
	<h3 class="center">Listado de Intervenciones </h3>
	<a href="nuevo.php" class="btn btn_sys right btn_nuevo">Nueva Intervencion</a>
	<a href="Javascript:window.print();" class="btn right indigo" style="margin-right: 10px;">Imprimir</a>
	<div class="row">


		<table id="listado" class="bordered striped" style="font-size: 0.82em;">
			<thead>
				<th>Equipo</th>
				<th>Patente</th>
				<th>Fecha</th>
				<th>Tipo Mant.</th>
				
				<th>Valor</th>
				<th>Detalle</th>
				<th>Editar</th>
			</thead>
			<tbody>
				<?php
				while($arr = $result->fetch_assoc()){
					?>
					<tr>
						<td class="center"><?=$arr['equipo']?></td>
						<td class="center"><?=$arr['placa']?></td>
						<td class="center"><?=$arr['fecha']?></td>
						<td><?=$arr['tipo_mant']?></td>
						<td>$<?=number_format($arr['valor_total'])?></td>
						<td class="center"><a href="detalle.php?id=<?=$arr['id']?>">Detalle</a></td>
						<td class="center"><a href="editar.php?id=<?=$arr['id']?>">Editar</a></td>
						
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>


	
</div>

<?php
print_footer();
?>