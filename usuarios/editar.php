<div class="container">
	<form action="../<?=$usuarioID?>" method="post">
		<div class="row">
			<h3 class="center"><?=$titulo?></h3>
			<div class="col s6">
				<label for="">Nombre</label>
				<input type="text" name="nombre" value="<?=$user['nombre']?>">
			</div>
			<div class="col s3">
				<label for="">Correo</label>
				<input type="email" name="correo" value="<?=$user['correo']?>">
			</div>
			<div class="col s3">
				<label for="">Contraseña</label>
				<input type="text" name="pass" value="<?=$user['pass']?>">
			</div>
		
			<hr>
			<div class="col s12">
				<h5>Permisos De Usuario</h5>
			</div>
			<div id="selects">
				<?php
					foreach ($permisos_usuario as $objeto) {
						?>
					<div class="col s12" style="margin-bottom: 20px;">
						<h6><?=$objeto['nombre']?></h6>
							<?php
							foreach ($arr_perm as $permiso) {
								if(in_array($permiso['id'], $objeto['permisos'])){
								?>
							<div class="col s3">
								<input type="checkbox" name="permiso[]" value="<?=$objeto['id']?>_<?=$permiso['id']?>" id="<?=$objeto['nombre']?>_<?=$permiso['nombre']?>" checked="true"><label for="<?=$objeto['nombre']?>_<?=$permiso['nombre']?>"><?=$permiso['nombre']?></label>
							</div>
							<?php
								}
								else{
									?>
							<div class="col s3">
								<input type="checkbox" name="permiso[]" value="<?=$objeto['id']?>_<?=$permiso['id']?>" id="<?=$objeto['nombre']?>_<?=$permiso['nombre']?>"><label for="<?=$objeto['nombre']?>_<?=$permiso['nombre']?>"><?=$permiso['nombre']?></label>
							</div>
							<?php
								}
							}					
							?>
						</div>
						<?php
					}
				?>
				
				<div class="col s3">
					<a href="#" onclick="checkAll('CREATE')" class="btn_small">check</a>
					<a href="#" onclick="unCheckAll('CREATE')" class="btn_small">unCheck</a>
				</div>
				<div class="col s3">
					<a href="#" onclick="checkAll('DELETE')" class="btn_small">check</a>
					<a href="#" onclick="unCheckAll('DELETE')" class="btn_small">unCheck</a>
				</div>
				<div class="col s3">
					<a href="#" onclick="checkAll('READ')" class="btn_small">check</a>
					<a href="#" onclick="unCheckAll('READ')" class="btn_small">unCheck</a>
				</div>
				<div class="col s3">
					<a href="#" onclick="checkAll('UPDATE')" class="btn_small">check</a>
					<a href="#" onclick="unCheckAll('UPDATE')" class="btn_small">unCheck</a>
				</div>
			</div>
		
			<div class="col s12">
				<input type="hidden" name="_METHOD" value="PUT"/>
				<a href="Javascript:window.history.back();" class="btn red left">Cancelar</a>
				<input type="submit" value="Guardar" class="btn btn_sys right">
			</div>
		</div>
	</form>
	
	<script>
		function checkAll(tipo){
			$("#selects").find($("[id*='"+tipo+"']")).each(function(index,element){
				$(element).prop('checked', true);
			});
		}
		function unCheckAll(tipo){
			$("#selects").find($("[id*='"+tipo+"']")).each(function(index,element){
				$(element).prop('checked', false);
			});	
		}
	</script>
</div>