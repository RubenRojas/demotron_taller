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

if(!in_array("5", $pUser)){
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
		<h3 class="center">Detalle Intervención</h3>
			<div class="row">
				<div class="col s2 m1 input-field">
					<label class="active" for="equipo" class="active">Equipo</label>
					<span class="dato"><?=get_campo("maquina", "codigo", $arr['id_maquina'], $mysqli)?></span>
					
				</div>
				<div class="col s2 m1 input-field">
					<label class="active" for="kilometraje">Kilometraje</label>
					<span class="dato"><?=$arr['kilometraje']?></span>
				</div>
				<div class="col s2 m1 input-field">
					<label class="active" for="horometro">Horometro</label>
					<span class="dato"><?=$arr['horometro']?></span>
				</div>
				
				<div class="col s2 m2 input-field">
					<label class="active" for="fecha" class="active">Fecha</label>
					<span class="dato"><?=$arr['fecha']?></span>
				</div>
				<div class="col s3 m2 input-field">
					<label class="active" for="turno">Turno</label>
					<span class="dato"><?=$arr['turno']?></span>
				</div>
				<div class="col s2 m2 input-field">
					<label class="active" for="hora_inicio" class="active">Hr. In.</label>
					<span class="dato"><?=$arr['hora_inicio']?></span>
				</div>
				<div class="col s2 m2 input-field">
					<label class="active" for="hora_termino" class="active">Hr. Term.</label>
					<span class="dato"><?=$arr['hora_termino']?></span>
				</div>
				<div class="col s2 m2 input-field">
					<label class="active" for="horas">Hr Tot.</label>
					<span class="dato"><?=$arr['horas_totales']?></span>
				</div>
				<div class="col s2 m2 input-field">
					<label class="active" for="valor_horas">Valor Hr</label>
					<span class="dato">$<?=number_format($arr['valor_horas'])?>.-</span>
				</div>
				<div class="col s4 m4 input-field">
					<label class="active" for="serie" class="active">Tipo Intervención</label>
					<span class="dato"><?=get_campo("taller_intervencion_tipo", "nombre", $arr['tipo_intervencion'], $mysqli)?></span>
				</div>
			</div>
			<div class="row">
				<div class="col s12 m8" style="padding-bottom: 0;margin-top: 0;">
					<div class="row">
						<div class="trabajos_realizado">
							<div class="row">
								<div class="col s12 hide-on-print">
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
										
										<span class="dato"><?=$arr2['detalle']?></span>
									</div>
									<div class="col s2">
										
										<span class="dato"><?=$arr2['valor']?></span>
									</div>
								</div>
								<?php
							}
							
							?>

						</div>
					</div>
				</div>
				<div class="col s6 m4" style="margin-right: 0px;padding-bottom: 21px;margin-top: 0;border-right: none;">
					<div class="col s12 hide-on-print">
						<p class="center" style="margin-top: -12px; margin-bottom: -11px; "><b>Lubricantes</b></p>
					</div>

					<div class="col s6">
						<p class="center">Lubricante</p>
					</div>
					<div class="col s3">
						<p class="center">Cant</p>
					</div>
					<div class="col s3">
						<p class="center">V. Un</p>
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
									<span class="dato"><?=$arr2['nombre']?></span>
								</div>
								<div class="col s3">
									<span class="dato"><?=$arr2['cantidad']?></span>
								</div>
								<div class="col s3">
									
									<span class="dato"><?=number_format($arr2['valor_unitario'])?></span>
								</div>
							</div>
						</div>
						<?php
						$i++;
					}
					?>

				</div>
				
				<div class="col s6 m12 final_detalle_intervencion">
					<div class="col s6 m2 input-field">
						<label class="active" for="valor_total" class="active" id="valor_total_label">Valor Total Mant.</label>
						<span class="dato">$ <?=number_format($arr['valor_total'])?> -</span>
					</div>			
					
					<div class="col s3 input-field">
						<label for="serie" class="active">Mecanico 1</label>
						<span class="dato"><?=get_campo("taller_mecanicos", "nombre", $arr['mecanico_1'], $mysqli)?></span>
					</div>	
					<div class="col s3 input-field">
						<label for="serie" class="active">Mecanico 2</label>
						<span class="dato"><?=get_campo("taller_mecanicos", "nombre", $arr['mecanico_2'], $mysqli)?></span>
					</div>
					<div class="col s3 input-field">
						<label for="serie" class="active">Mecanico 3 </label>
						<span class="dato"><?=get_campo("taller_mecanicos", "nombre", $arr['mecanico_3'], $mysqli)?></span>
					</div>	

					<div class="col s12 input-field">
						<label class="active" for="observaciones" class="active">Observaciones</label>
						<span class="dato"><?=$arr['observaciones']?></span>
					</div>
				</div>
			</div>
			
			
			<div class="col s12" style="margin-top: 50px">
				<input type="hidden" name="id" value="<?=$id?>">
				<a href="Javascript:history.back()" class="btn left red">Volver</a>
				<a href="Javascript:window.print();" class="btn right indigo">Imprimir</a>
			</div>

	</div>
</div>



<?=print_footer();?>
