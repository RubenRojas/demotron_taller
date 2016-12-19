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




print_head();
print_menu();

?>

<div class="container_form">
	<div class="row">
		<h3 class="center">Nueva Intervención</h3>
		<form action="forms/insert.php" method="post">
			<div class="row">
				<div class="col s1 input-field">
					<label for="equipo" class="active">Equipo</label>
					<select name="id_maquina" id="equipo">
						<?=show_option_campos("maquina", "", array("id", "codigo"), array(), array("order by"=>"codigo asc"), $mysqli)?>
					</select>
				</div>
				<div class="col s2 input-field">
					<label for="kilometraje">Kilometraje</label>
					<input type="text" name="kilometraje" id="kilometraje">
				</div>
				<div class="col s2 input-field">
					<label for="horometro">Horometro</label>
					<input type="text" name="horometro" id="horometro">
				</div>
				
				<div class="col s2 input-field">
					<label for="fecha" class="active">Fecha</label>
					<input type="date" name="fecha" id="fecha" value="<?=$HOY?>">
				</div>
				<div class="col s2 input-field">
					<label for="turno">Turno</label>
					<input type="text" name="turno" id="turno">
				</div>
				<div class="col s2 input-field">
					<label for="hora_inicio" class="active">Hora Inicio</label>
					<input type="time" name="hora_inicio" id="hora_inicio">
				</div>
				<div class="col s2 input-field">
					<label for="hora_termino" class="active">Hora Termino</label>
					<input type="time" name="hora_termino" id="hora_termino" onchange="suma_horas();">
				</div>
				<div class="col s2 input-field">
					<label for="horas">Horas Totales</label>
					<input type="text" name="horas_totales" id="horas_totales">
				</div>
				<div class="col s2 input-field">
					<label for="valor_horas">Valor Horas</label>
					<input type="text" name="valor_horas" id="valor_horas" onfocusout="set_value_out(this)" onfocus="set_value(this)" onchange="update_valor();" value="0">
				</div>
				<div class="col s2 input-field">
					<label for="serie" class="active">Tipo Intervención</label>
					<select name="tipo_intervencion" id="tipo" id="">
						<?=show_option("taller_intervencion_tipo", "" , $mysqli)?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col s4" style="margin-right: 0px;padding-bottom: 21px;margin-top: 0;border-right: none;">
					<div class="col s12">
						<p class="center"><b>Lubricantes</b></p>
					</div>

					<div class="col s6">
						<p class="center">Lubricante</p>
					</div>
					<div class="col s3">
						<p class="center">Cantidad</p>
					</div>
					<div class="col s3">
						<p class="center">Valor Un</p>
					</div>


					<?php
					$query = "select * from taller_intervencion_tipo_lubricante order by id asc";
					$result = $mysqli->query($query);
					$i = 1;
					while ($arr = $result->fetch_assoc()) {
						?>
						<div class="trabajos_realizado">
							<div class="row">
								<div class="col s6">
									<p class="lubricante_nombre"><?=$arr['nombre']?></p>	
								</div>
								<div class="col s3">
									<input type="text" name="lubricante_<?=$i?>_cantidad" id="lubricante_<?=$i?>_cantidad" onfocusout="set_value_out(this)" onfocus="set_value(this)" onchange="update_valor();" value="0">
								</div>
								<div class="col s3">
									<input type="text" name="lubricante_<?=$i?>_valor" id="lubricante_<?=$i?>_valor" onfocusout="set_value_out(this)" onfocus="set_value(this)" onchange="update_valor();" value="0">
								</div>
							</div>
						</div>
						<?php
						$i++;
					}
					?>

				</div>
				<div class="col s8" style="padding-bottom: 0;margin-top: 0;padding-left: 28px;">
					<div class="row">
						<div class="trabajos_realizado">
							<div class="row">
								<div class="col s12">
									<p class="center"><b>Trabajos</b></p>
								</div>
								<div class="col s2">
									<p class="center">Tipo</p>
								</div>
								<div class="col s8">
									<p class="center">Trabajo Realizado</p>
								</div>
								<div class="col s2">
									<p class="center">Valor</p>
								</div>
							</div>
							<?php
							for ($i=1; $i <= 10; $i++) { 
								?>
								<div class="row">
									<div class="col s3">
										<input type="text" name="trabajo_<?=$i?>_tipo" id="trabajo_<?=$i?>_tipo">
									</div>
									<div class="col s7">
										<input type="text" name="trabajo_<?=$i?>_detalle" id="trabajo_<?=$i?>_detalle">
									</div>
									<div class="col s2">
										<input type="text" name="trabajo_<?=$i?>_valor" id="trabajo_<?=$i?>_valor" onfocusout="set_value_out(this)" onfocus="set_value(this)" onchange="update_valor();" value="0">
									</div>
								</div>
								<?php
							}
							?>

						</div>
					</div>
				</div>
			</div>
			
			<div class="col s2 input-field">
				<label for="valor_total" class="active" id="valor_total_label">Valor Total Mant.</label>
				<input type="text" name="valor_total" id="valor_total">
			</div>			
			
			<div class="col s2 input-field">
				<label for="realizado_por" class="active">Realizado Por</label>
				<input type="text" name="realizado_por" id="realizado_por">
			</div>			


			<div class="col s12 input-field">
				<label for="observaciones" class="active">Observaciones</label>
				<input type="text" name="observaciones" id="observaciones">
			</div>
			<div class="col s12" style="margin-top: 50px">
				<a href="Javascript:history.back()" class="btn left red">Volver</a>
				<input type="submit" value="Guardar" class="btn right indigo">
			</div>


		</form>
	</div>
</div>

<script>
	function update_valor(){
		var valor_horas = parseInt($("#valor_horas").val());
		var valor_lubricante = 0;
		var valor_trabajo = 0;

		for(var i = 1; i<9 ; i++){
			var cantidad = parseInt($("#lubricante_"+i+"_cantidad").val());
			var valor = parseInt($("#lubricante_"+i+"_valor").val());
			valor_lubricante += (cantidad * valor);
			
		}
		for(var i = 1; i<=10 ; i++){
			var cantidad = parseInt($("#trabajo_"+i+"_valor").val());
			valor_trabajo += (cantidad);
		}

		var valor_total = valor_horas + valor_trabajo + valor_lubricante;

		$("#valor_total_label").addClass("active");
		$("#valor_total").val(valor_total);
	}

	function set_value(element){
		if((element).value == 0){
			(element).value = "";
		}
	}

	function set_value_out(element){
		if((element).value == ""){
			(element).value = 0;
		}
	}

	function suma_horas(){
		 var timeOfCall = $('#hora_inicio').val(),
        timeOfResponse = $('#hora_termino').val(),
        hours = timeOfResponse.split(':')[0] - timeOfCall.split(':')[0],
        minutes = timeOfResponse.split(':')[1] - timeOfCall.split(':')[1];

	    minutes = minutes.toString().length<2?'0'+minutes:minutes;
	    if(minutes<0){ 
	        hours--;
	        minutes = 60 + minutes;
	    }
	    hours = hours.toString().length<2?'0'+hours:hours;
	    $('#horas_totales').val(hours + ':' + minutes);
	}
</script>

<?=print_footer();?>
