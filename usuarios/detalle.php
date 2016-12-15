
<div class="container">
	<div class="row">
		<h3 class="center"><?=$titulo?></h3>
		<div class="col m4 s12">
			<label for="">Correo</label>
			<span class="dato"><?=$user['correo']?></span>
		</div>
		<div class="col m4 s12">
			<label for="">Contraseña</label>
			<span class="dato"><?=$user['pass']?></span>
		</div>
	</div>
	<hr>
	<h5 class="center" style="margin: 30px 0px;">Permisos</h5>
	<table class="permisos">
		<thead>
			<th>ELEMENTO</th>
			<?php
			foreach ($arr_perm as $permiso) {
				?>
				<th><?=$permiso['nombre']?></th>
				<?php
			}
			?>
		</thead>
		<tbody>
			<?php
			foreach ($perm as $objeto) {
				?>
				<tr>
				<td><?=$objeto['nombre']?></td>
					<?php
					foreach ($arr_perm as $permiso) {
						if(in_array($permiso['id'], $objeto['permisos'])){
						?>
						<td style="color: green; font-size:2em;"><i class="fa fa-check-circle-o"></i></td>
						<?php
						}
						else{
							?>
							<td style="color: grey; font-size:2em;"><i class="fa fa-times-circle-o"></i></td>
							<?php	
						}
					}					
					?>
				</tr>
				<?php
			}
		?>
		</tbody>
	</table>
	<div class="row">
		<div class="col s12" style="margin-top: 30px;">
			<a href="Javascript:window.history.back();" class="btn red left">Volver</a>
			<a href="<?=$user['id']?>/editar" class="btn btn_sys right">Editar</a>
		</div>
	</div>
</div>