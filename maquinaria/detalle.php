<?php
if(is_dir("/var/www/html/taller")){
	$baseDir = "/var/www/html/taller/includes/";
}
else{
	$baseDir = "c:/wamp/www/taller/includes/";
}
include($baseDir."conexion.php");

if(isset($_SESSION['id'])){
	$objeto = getObjetoByNombre('MAQUINARIA', $mysqli);
	$pUser = getPermisosObjeto($_SESSION['id'], $objeto['id'], $mysqli);
	/* 1:CREATE,  2:READ,  3:UPDATE,  4:DELETE */
}
else{
	header("Location: /taller/index.php");
}

if(!in_array("2", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/taller/index.php";
	header("location: /taller/error/index.php");
}

extract($_GET); //id

$query = "select * from maquina where id='$id' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();

print_head();
print_menu();

?>

<div class="container">
	<div class="row">
		<h3 class="center">Detalle Maquina</h3>
		
		<div class="row">
			<div class="col s5 input-field">
				<label class="active">Equipo</label>
				<span class="dato"><?=get_campo("tipo_maquina", "nombre", $arr['equipo'], $mysqli)?></span>
				
			</div>
			
			<div class="col s3 m3 input-field">
				<label class="active">Marca</label>
				<span class="dato"><?=$arr['marca']?></span>
			</div>
			<div class="col s2 input-field">
				<label class="active">Placa</label>
				<span class="dato"><?=$arr['placa']?></span>
			</div>
			<div class="col s2 m2 input-field">
				<label class="active">Codigo</label>
				<span class="dato"><?=$arr['codigo']?></span>
			</div>
			<div class="col s3 m3 input-field">
				<label class="active">Modelo</label>
				<span class="dato"><?=$arr['modelo']?></span>
			</div>
			<div class="col s2 m3 input-field">
				<label class="active">Año</label>
				<span class="dato"><?=$arr['anio']?></span>
			</div>
			<div class="col s4 m3 input-field">
				<label class="active">N° Chasis</label>
				<span class="dato"><?=$arr['chasis']?></span>
			</div>
			<div class="col s3 m3 input-field">
				<label class="active">N° Serie</label>
				<span class="dato"><?=$arr['serie']?></span>
			</div>
			<div class="col s4 m3 input-field">
				<label class="active">Modelo Motor</label>
				<span class="dato"><?=$arr['modelo_motor']?></span>
			</div>
			<div class="col s3 m3 input-field">
				<label class="active">Kilometraje</label>
				<span class="dato"><?=$arr['kilometraje']?></span>
			</div>
			<div class="col s2 m3 input-field">
				<label class="active">Horometro</label>
				<span class="dato"><?=$arr['horometro']?></span>
			</div>
			<div class="col s3 m3 input-field">
				<label class="active">Estado</label>
				<span class="dato"><?=get_campo("taller_maquina_estado", "nombre", $arr['estado'], $mysqli)?></span>
				
			</div>
			<div class="col s4 m3 input-field">
				<label class="active">Faena</label>
				<span class="dato"><?=get_campo("centro_costo", "nombre", $arr['faena'], $mysqli)?></span>
				
			</div>
			<div class="col s4 m3 input-field">
				<label class="active">Chofer</label>
				<span class="dato"><?=$arr['chofer']?></span>
			</div>

			<div class="col s12 input-field">
				<label class="active">observaciones</label>
				<span class="dato"><?=$arr['observaciones']?></span>
				
			</div>
		</div>
		<div class="col s12">
			<a href="editar.php?id=<?=$id?>" class="btn right teal">Editar</a>
			<a href="/taller/intervencion/nuevo.php?id_maquina=18" class="btn orange right" style="margin-right: 5px;">Agregar Intervencion</a>
		</div>
		
		<div class="row historial">
			<h5 class="center">Historial de Mantenciones</h5>

			<?php
			$query = "select * from taller_intervencion where id_maquina='$id'";
			$result = $mysqli->query($query);
			
			if($result->num_rows > 0){
				$num = $result->num_rows;
				while ($intervencion = $result->fetch_assoc()) {
					$id_intervencion = $intervencion['id'];
					?>
					<div class="mantencion">
						<h5 class="center" style="margin-bottom: 20px;margin-top: 4px;font-size: 1.2em;">Mantención <?=$num?></h5>
						<div class="row data_historial">
							<div class="col s2 m1 input-field">
								<label class="active" for="kilometraje">Kilometraje</label>
								<span class="dato"><?=$intervencion['kilometraje']?></span>
							</div>
							<div class="col s2 m1 input-field">
								<label class="active" for="horometro">Horometro</label>
								<span class="dato"><?=$intervencion['horometro']?></span>
							</div>
							
							<div class="col s2 m2 input-field">
								<label class="active" for="fecha" class="active">Fecha</label>
								<span class="dato"><?=$intervencion['fecha']?></span>
							</div>
							<div class="col s3 m2 input-field">
								<label class="active" for="turno">Turno</label>
								<span class="dato"><?=$intervencion['turno']?></span>
							</div>
							<div class="col s2 m2 input-field">
								<label class="active" for="hora_inicio" class="active">Hr. In.</label>
								<span class="dato"><?=$intervencion['hora_inicio']?></span>
							</div>
							<div class="col s2 m2 input-field">
								<label class="active" for="hora_termino" class="active">Hr. Term.</label>
								<span class="dato"><?=$intervencion['hora_termino']?></span>
							</div>
							<div class="col s2 m2 input-field">
								<label class="active" for="horas">Hr Tot.</label>
								<span class="dato"><?=$intervencion['horas_totales']?></span>
							</div>
							<div class="col s2 m2 input-field">
								<label class="active" for="valor_horas">Valor Hr</label>
								<span class="dato">$<?=number_format($intervencion['valor_horas'])?>.-</span>
							</div>
							<div class="col s4 m2 input-field">
								<label class="active" for="serie" class="active">Tipo Intervención</label>
								<span class="dato"><?=get_campo("taller_intervencion_tipo", "nombre", $intervencion['tipo_intervencion'], $mysqli)?></span>
							</div>
						</div>


						<div class="row">
							<div class="col s7 detalle_trabajos">
								<table>
									<thead>
										<th>Tipo</th>
										<th>Trabajo</th>
										<th>Valor</th>
									</thead>
									<tbody>
										<?php
											$query = "select tipo_trabajo, detalle, valor from taller_intervencion_trabajo where id_intervencion='$id_intervencion'";
											$result2 = $mysqli->query($query);
											$j = 0;
											while ($arr2 = $result2->fetch_assoc()) {
												$j++;
												?>
												<tr>
													<td><?=$arr2['tipo_trabajo']?></td>
													<td><?=$arr2['detalle']?></td>
													<td>$<?=number_format($arr2['valor'])?>.-</td>
												</tr>
												<?php
											}
										?>
									</tbody>
								</table>
							</div>
							<div class="col s5 detalle_trabajos">
								<table>
									<thead>
										<th>Lubricante</th>
										<th>Cant</th>
										<th>Val. Un.</th>
									</thead>
									<tbody>
										<?php
										$query = "select taller_intervencion_lubricantes.cantidad, taller_intervencion_lubricantes.valor_unitario, taller_intervencion_tipo_lubricante.nombre from taller_intervencion_lubricantes inner join taller_intervencion_tipo_lubricante on taller_intervencion_tipo_lubricante.id = taller_intervencion_lubricantes.tipo where taller_intervencion_lubricantes.id_intervencion = '$id_intervencion'";
										$result2 = $mysqli->query($query);
										$i = 1;
										while ($arr2 = $result2->fetch_assoc()) {
											?>
											<tr>
												<td><?=$arr2['nombre']?></td>
												<td><?=$arr2['cantidad']?></td>
												<td>$<?=number_format($arr2['valor_unitario'])?>.-</td>
											</tr>
											
											<?php
											$i++;
										}
										?>
									</tbody>
								</table>
							</div>
							
						</div>

						<div class="row">
							<div class="col s12 final_detalle_intervencion">
								<div class="col s6 m2 input-field">
									<label class="active" for="valor_total" class="active" id="valor_total_label">Valor Total Mant.</label>
									<span class="dato">$ <?=number_format($intervencion['valor_total'])?> -</span>
								</div>			
								
								<div class="col s3 input-field">
									<label for="serie" class="active">Mecanico 1</label>
									<span class="dato"><?=get_campo("taller_mecanicos", "nombre", $intervencion['mecanico_1'], $mysqli)?></span>
								</div>	
								<div class="col s3 input-field">
									<label for="serie" class="active">Mecanico 2</label>
									<span class="dato"><?=get_campo("taller_mecanicos", "nombre", $intervencion['mecanico_2'], $mysqli)?></span>
								</div>
								<div class="col s3 input-field">
									<label for="serie" class="active">Mecanico 3 </label>
									<span class="dato"><?=get_campo("taller_mecanicos", "nombre", $intervencion['mecanico_3'], $mysqli)?></span>
								</div>			


								<div class="col s12 input-field">
									<label class="active" for="observaciones" class="active">Observaciones</label>
									<span class="dato"><?=$intervencion['observaciones']?></span>
								</div>
							</div>
						</div>


						
							
							
						</div>
					</div>
					<?php
					$num -- ;
				}
			}
			else{
				?>
				<h6 class="center" style="margin-top: 20px;">No existen mantenciones registradas para esta máquina.</h6>
				<?php
			}	
		?>
		<div class="row">
			<div class="col s12" style="margin-top: 50px">
				<a href="Javascript:history.back()" class="btn left red">Volver</a>
				<a href="Javascript:window.print();" class="btn right indigo">Imprimir</a>
			</div>
		</div>
	</div>
</div>





<?=print_footer();?>