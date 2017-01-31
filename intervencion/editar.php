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

if(!in_array("3", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/taller/maquinaria/index.php";
	header("location: /taller/error/index.php");
}

extract($_GET);
$query = "select * from taller_intervencion where id='$id' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();




print_head();
print_menu();

?>

<div class="container_form">
	<div class="row">
		<h3 class="center">Editar Intervención</h3>
		<form action="forms/update.php" method="post">
			<div class="row">
				<div class="col s1 input-field">
					<label for="equipo" class="active">Equipo</label>
					<select name="id_maquina" id="equipo">
						<?=show_option_campos("maquina", $arr['id_maquina'], array("id", "codigo"), array(), array("order by"=>"codigo asc"), $mysqli)?>
					</select>
				</div>
				<div class="col s2 input-field">
					<label for="kilometraje">Kilometraje</label>
					<input type="text" name="kilometraje" value="<?=$arr['kilometraje']?>" id="kilometraje">
				</div>
				<div class="col s2 input-field">
					<label for="horometro">Horometro</label>
					<input type="text" name="horometro" value="<?=$arr['horometro']?>" id="horometro">
				</div>
				
				<div class="col s2 input-field">
					<label for="fecha" class="active">Fecha</label>
					<input type="date" name="fecha" value="<?=$arr['fecha']?>" id="fecha" >
				</div>
				<div class="col s2 input-field">
					<label for="turno">Turno</label>
					<input type="text" name="turno" value="<?=$arr['turno']?>" id="turno">
				</div>
				<div class="col s2 input-field">
					<label for="tipo_mantencion">Tipo Mantencion</label>
					<input type="text" name="tipo_mantencion" value="<?=$arr['tipo_mantencion']?>" id="tipo_mantencion">
				</div>
				<div class="col s2 input-field">
					<label for="hora_inicio" class="active">Hora Inicio</label>
					<input type="time" name="hora_inicio" value="<?=$arr['hora_inicio']?>" id="hora_inicio">
				</div>
				<div class="col s2 input-field">
					<label for="hora_termino" class="active">Hora Termino</label>
					<input type="time" name="hora_termino" value="<?=$arr['hora_termino']?>" id="hora_termino" onchange="suma_horas();">
				</div>
				<div class="col s2 input-field">
					<label for="horas">Horas Totales</label>
					<input type="text" name="horas_totales" value="<?=$arr['horas_totales']?>" id="horas_totales">
				</div>
				<div class="col s2 input-field">
					<label for="valor_horas">Valor Horas</label>
					<input type="text" name="valor_horas" value="<?=$arr['valor_horas']?>" id="valor_horas" onfocusout="set_value_out(this)" onfocus="set_value(this)" onchange="update_valor();" value="0">
				</div>
				<div class="col s4 input-field">
					<label for="serie" class="active">Tipo Intervención</label>
					<select name="tipo_intervencion" id="tipo" id="">
						<?=show_option("taller_intervencion_tipo", $arr['tipo_intervencion'] , $mysqli)?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col s4" style="margin-right: 0px;padding-bottom: 21px;margin-top: 0;border-right: none;">
					<div class="col s12">
						<p class="center" style="margin-top: -12px; margin-bottom: -11px; "><b>Lubricantes</b></p>
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
					$query = "select taller_intervencion_lubricantes.cantidad, taller_intervencion_lubricantes.valor_unitario, taller_intervencion_tipo_lubricante.nombre from taller_intervencion_lubricantes inner join taller_intervencion_tipo_lubricante on taller_intervencion_tipo_lubricante.id = taller_intervencion_lubricantes.tipo where taller_intervencion_lubricantes.id_intervencion = '$id'";
					$result = $mysqli->query($query);
					$i = 1;
					while ($arr2 = $result->fetch_assoc()) {
						?>
						<div class="trabajos_realizado">
							<div class="row">
								<div class="col s6">
									<p class="lubricante_nombre"><?=$arr2['nombre']?></p>	
								</div>
								<div class="col s3">
									<input type="text" name="lubricante_<?=$i?>_cantidad" id="lubricante_<?=$i?>_cantidad" onfocusout="set_value_out(this)" onfocus="set_value(this)" onchange="update_valor();" value="<?=$arr2['cantidad']?>">
								</div>
								<div class="col s3">
									<input type="text" name="lubricante_<?=$i?>_valor" id="lubricante_<?=$i?>_valor" onfocusout="set_value_out(this)" onfocus="set_value(this)" onchange="update_valor();" value="<?=$arr2['valor_unitario']?>">
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
									<p class="center" style="margin-top: -12px; margin-bottom: -11px; "><b>Trabajos</b></p> 
								</div>
								
								<div class="col s10">
									<p class="center">Trabajo Realizado</p>
								</div>
								<div class="col s2">
									<p class="center">Valor</p>
								</div>
							</div>
							<?php
							$query = "select tipo_trabajo, detalle, valor from taller_intervencion_trabajo where id_intervencion='$id'";
							$result = $mysqli->query($query);
							$j = 0;
							while ($arr2 = $result->fetch_assoc()) {
								$j++;
								?>
								<div class="row">
									
									<div class="col s10">
										<input type="text" name="trabajo_<?=$j?>_detalle" id="trabajo_<?=$j?>_detalle" value="<?=$arr2['detalle']?>">
									</div>
									<div class="col s2">
										<input type="text" name="trabajo_<?=$j?>_valor" id="trabajo_<?=$j?>_valor" onfocusout="set_value_out(this)" onfocus="set_value(this)" onchange="update_valor();" value="<?=$arr2['valor']?>">
									</div>
								</div>
								<?php
							}
							for ($i=$j+1; $i <= 10; $i++) { 
								
								?>
								<div class="row">
									
									<div class="col s10">
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
			
			<div class="col s3 input-field">
				<label for="valor_total" class="active" id="valor_total_label">Valor Total Mant.</label>
				<input type="text" name="valor_total" value="<?=$arr['valor_total']?>" id="valor_total">
			</div>			
			
			<div class="col s3 input-field">
				<label for="serie" class="active">Mecanico 1</label>
				<select name="mecanico_1" id="tipo" id="">
					<?=show_option("taller_mecanicos", $arr['mecanico_1'] , $mysqli)?>
				</select>
			</div>	
			<div class="col s3 input-field">
				<label for="serie" class="active">Mecanico 2</label>
				<select name="mecanico_2" id="tipo" id="">
					<?=show_option("taller_mecanicos", $arr['mecanico_2'] , $mysqli)?>
				</select>
			</div>
			<div class="col s3 input-field">
				<label for="serie" class="active">Mecanico 3 </label>
				<select name="mecanico_3" id="tipo" id="">
					<?=show_option("taller_mecanicos", $arr['mecanico_3'] , $mysqli)?>
				</select>
			</div>		
			
			<div class="col s12 input-field">
				<label for="observaciones" class="active">Observaciones</label>
				<input type="text" name="observaciones" value="<?=$arr['observaciones']?>" id="observaciones">
			</div>

			<div class="col s12" style="MARGIN-TOP: 36px; ">

			
				<h5 class="center">
					Datos Proxima Mantencion
				</h5>

				<div class="col s4">
					<label for="">Proximo Kilometro (MANT)</label>
					<input type="text" name="prox_km" value="<?=$arr['prox_km']?>">
				</div>
				<div class="col s4">
					<label for="">Proximo Horometro (MANT)</label>
					<input type="text" name="prox_hr" value="<?=$arr['prox_hr']?>">
				</div>	
				<div class="col s4">
					<label for="">Tipo Prox. Mantencion</label>
					<input type="text" name="tipo_prox_mant"  value="<?=$arr['tipo_prox_mant']?>">
				</div>

			</div>

			
			<div class="col s12" style="margin-top: 50px">
				<input type="hidden" name="id" value="<?=$id?>">
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
