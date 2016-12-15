<div class="container">	
	<form action="../usuarios" method="post">
		<div class="row">
			<h3 class="center"><?=$titulo?></h3>
			<p class="center">¿Deseas borrar al usuario <b><?=$user['nombre']?></b>?</p>		
			<div class="col s12">
				<input type="hidden" name="_METHOD" value="DELETE"/>
				<input type="hidden" name="id" value="<?=$user['id']?>">
				<a href="Javascript:window.history.back();" class="btn red left">Cancelar</a>
				<input type="submit" value="Borrar" class="btn btn_sys right">
			</div>
		</div>
	</form>
</div>