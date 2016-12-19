<?php
function print_head(){
	?>
<!DOCTYPE html>
<html>
<head>
	<!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="utf-8">


	<title>Taller Demotron</title>
	<link rel="stylesheet" type="text/css" href="/taller/assets/css/materialize.css">
	<link rel="stylesheet" type="text/css" href="/taller/assets/css/animate.css">
	<link rel="stylesheet" type="text/css" href="/taller/assets/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="/taller/assets/css/notifications.css">
	<link rel="stylesheet" type="text/css" href="/taller/assets/css/sweetalert.css">
	<link rel="stylesheet" type="text/css" href="/taller/assets/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/taller/assets/css/app.css">
	<link rel="stylesheet" type="text/css" href="/taller/assets/css/print.css">

	<script type="text/javascript" src="/taller/assets/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="/taller/assets/js/materialize.min.js"></script>
    <script type="text/javascript" src="/taller/assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/taller/assets/js/notif.js"></script>
    <script type="text/javascript" src="/taller/assets/js/wow.min.js"></script>
    

    <link rel="icon" href="/taller/assets/img/favicon.png" sizes="32x32">
</head>
<body>
	<?php
}

function print_footer(){
?>
<div class="container">
	<div class="row">
		<br> <br> <br> <br> <br>
	</div>
</div>
<script>
	$(document).ready(function(){
		$(".dropdown-button").dropdown();
		$('select').material_select();
		$('#listado').DataTable({
					"iDisplayLength": 5000,
					"order": []
				});
	});
</script>
</body>
</html>
<?php
}

function print_menu(){
	?>
	<ul id="dropdown1" class="dropdown-content">
		<li><a href="/taller/usuarios/index.php">Usuarios</a></li>
		
		<li class="divider"></li>
		<li><a href="#!">Otro</a></li>
	</ul>	

	<nav>
		<div class="nav-wrapper indigo">
		<!--<a href="#" class="brand-logo right">Logo</a>-->
		<ul id="nav-mobile" class="left hide-on-med-and-down" style="width: 100%;">
			<li><a href="/taller/maquinaria/index.php">Gestion Maquinaria</a></li>
			<li><a href="/taller/intervencion/index.php">Intervenciones</a></li>
			<li><a href="/taller/informes/index.php">Informes</a></li>
			
			<li><a class="dropdown-button" href="#!" data-activates="dropdown1">Opciones <i class="fa fa-arrow-down" aria-hidden="true"></i></a></li>
			<li style="float: right; "><a href="/taller/login/logout.php">Cerrar Sesion</a></li>
		</ul>
		</div>
	</nav>
	<?php
}