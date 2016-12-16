<?php
if(is_dir("/var/www/html/taller")){
	$baseDir = "/var/www/html/taller/includes/";
}
else{
	$baseDir = "c:/wamp/www/taller/includes/";
}
include($baseDir."conexion.php");

print_head();

?>
<div class="container">
	<div class="row">

		<h2 class="center">
			<i class="fa fa-exclamation-circle" aria-hidden="true" style="display: block;font-size: 5em;color: #FF9800;"></i>
			Error
		</h2>
		<h5 class="center">
			<?=$_SESSION['error']['mensaje']?>
		</h5>
		<a href="/taller/maquinaria/index.php" class="btn teal" style="display: block; margin: auto; width: 250px; margin-top: 110px; ">Continuar</a>
	</div>
</div>
