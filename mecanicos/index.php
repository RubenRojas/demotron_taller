<?php
if(is_dir("/var/www/html/taller")){
	$baseDir = "/var/www/html/taller/includes/";
}
else{
	$baseDir = "c:/wamp/www/taller/includes/";
}
include($baseDir."conexion.php");

if(isset($_SESSION['id'])){
	$objeto = getObjetoByNombre('OPCIONES', $mysqli);
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

$query = "select * from taller_mecanicos order by nombre ";


$result = $mysqli->query($query);

?>
<div class="container">
	<h3 class="center">Listado de Mecanicos </h3>
	<a href="nuevo.php" class="btn btn_sys right btn_nuevo">Nuevo Mecanico</a>
	
	<div class="row">


		<table id="listado" class="bordered striped" style="font-size: 0.82em;">
			<thead>
				<th>ID</th>
				<th>Nombre</th>
				<th>Editar</th>
				<th>Borrar</th>
			</thead>
			<tbody>
				<?php
				while($arr = $result->fetch_assoc()){
					?>
					<tr>
						<td class="center"><?=$arr['id']?></td>
						<td class="center"><?=$arr['nombre']?></td>
						<td class="center"><a href="editar.php?id=<?=$arr['id']?>">Editar</a></td>
						<td class="center"><a href="borrar.php?id=<?=$arr['id']?>">Borrar</a></td>
						
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