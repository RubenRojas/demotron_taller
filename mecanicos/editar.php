<?php
if(is_dir("/var/www/html/taller")){
	$baseDir = "/var/www/html/taller/includes/";
}
else{
	$baseDir = "c:/wamp/www/taller/includes/";
}
include($baseDir."conexion.php");

if(isset($_SESSION['id'])){
	$objeto = getObjetoByNombre('INTERVENCION', $mysqli);
	$pUser = getPermisosObjeto($_SESSION['id'], $objeto['id'], $mysqli);
	/* 1:CREATE,  2:READ,  3:UPDATE,  4:DELETE */
}
else{
	header("Location: /taller/index.php");
}

if(!in_array("1", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/taller/maquinaria/index.php";
	header("location: /taller/error/index.php");
}

extract($_GET);
$query = "select * from taller_mecanicos where id='$id' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();




print_head();
print_menu();

?>

<div class="container_form">
	<div class="row">
		<h3 class="center">Editar Mecanico</h3>
		<form action="forms/update.php" method="post">
			<div class="row">
				<div class="col s12 input-field">
					<label for="kilometraje">Nombre</label>
					<input type="text" name="nombre" id="kilometraje" value="<?=$arr['nombre']?>">
				</div>
			<div class="col s12" style="margin-top: 50px">
				<input type="hidden" name="id" value="<?=$id?>">
				<a href="Javascript:history.back()" class="btn left red">Volver</a>
				<input type="submit" value="Guardar" class="btn right indigo">
			</div>


		</form>
	</div>
</div>


<?=print_footer();?>
