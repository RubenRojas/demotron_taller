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

if(!in_array("4", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/taller/centro_costo/index.php";
	header("location: /taller/error/index.php");
}

print_head();
print_menu();
extract($_GET);

$titulo ="Borrar Centro Costo";

$query = "select * from centro_costo where id='$id' limit 1";
$result = $mysqli->query($query);
$user = $result->fetch_assoc();

?>

<div class="container_form">	
	<form action="forms/delete.php" method="post">
		<div class="row">
			<h3 class="center"><?=$titulo?></h3>
			<p class="center">¿Deseas borrar el registro <b><?=$user['nombre']?></b>?</p>		
			<div class="col s12">
				<input type="hidden" name="id" value="<?=$user['id']?>">
				<input type="hidden" name="nombre" value="<?=$user['nombre']?>">
				<a href="Javascript:window.history.back();" class="btn red left">Cancelar</a>
				<input type="submit" value="Borrar" class="btn btn_sys right">
			</div>
		</div>
	</form>
</div>