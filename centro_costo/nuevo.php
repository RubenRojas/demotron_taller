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

if(!in_array("1", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/taller/centro_costo/index.php";
	header("location: /taller/error/index.php");
}




print_head();
print_menu();

?>

<div class="container_form">
	<div class="row">
		<h3 class="center">Nuevo Centro Costo</h3>
		<form action="forms/insert.php" method="post">
			<div class="row">
				<div class="col s12 input-field">
					<label for="kilometraje">Nombre</label>
					<input type="text" name="nombre" id="kilometraje">
				</div>
				
			<div class="col s12" style="margin-top: 50px">
				<a href="Javascript:history.back()" class="btn left red">Volver</a>
				<input type="submit" value="Guardar" class="btn right indigo">
			</div>


		</form>
	</div>
</div>



<?=print_footer();?>
