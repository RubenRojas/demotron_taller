<div class="container">
	<h3 class="center"><?=$titulo?></h3>
	<a href="usuarios/nuevo" class="btn btn_sys right btn_nuevo">Nuevo Usuario</a>
	<table id="listado" style="font-size: 0.82em;">
		<thead>
			<th>Nombre</th>
			<th>Correo</th>
			<th>Pass</th>
			<th>Detalle</th>
			<th>Editar</th>
			<th>Borrar</th>
		</thead>
		<tbody>
	<?php
	$arr = array();
	while ($arr = $result->fetch_assoc()) {
		?>
			<tr>
				<td><?=$arr['nombre']?></td>
				<td><?=$arr['correo']?></td>
				<td><?=$arr['pass']?></td>
				<td><a href="usuarios/<?=$arr['id']?>">Detalle</a></td>
				<td><a href="usuarios/<?=$arr['id']?>/editar">Editar</a></td>
				<td><a href="usuarios/<?=$arr['id']?>/borrar">Borrar</a></td>
			</tr>
		<?php
	}
	?>
		</tbody>
	</table>
	
</div>