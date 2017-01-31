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

if(!in_array("2", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/taller/index.php";
	header("location: /taller/error/index.php");
}

print_head();
print_menu();
extract($_GET);



?>
<div class="contenedor_mantencion container">
	<h3 class="center">Listado de Mantenciones</h3>
	<div class="row">


		<table id="listado" class="bordered striped" style="font-size: 0.82em; width: 1500px !important;">
			<thead>
			<tr>
				<th colspan="5" scope="equipo">DATOS EQUIPO</th>
				<th colspan="4" scope="ultima_mant">ULTIMA MANTENCION</th>
				<th colspan="3" scope="prox_mant">PROXIMA MANTENCION</th>
				<th colspan="2" scope="prox_mant">RESTANTES</th>
				<th colspan="2" scope="prox_mant">PASADOS</th>
				<th colspan="3"></th>
			</tr>
			<tr>
				<th scope="equipo">COD</th>
				<th scope="equipo">Marca</th>
				<th scope="equipo">Patente</th>
				<th scope="equipo">KM. AC.</th>
				<th scope="equipo">HR. AC.</th>
				<th scope="ultima_mant">Fecha</th>
				<th scope="ultima_mant">Tipo</th>
				<th scope="ultima_mant">KM</th>
				<th scope="ultima_mant">HR</th>
				<th scope="prox_mant">Tipo</th>
				<th scope="prox_mant">KM</th>
				<th scope="prox_mant">HR</th>
				<th scope="prox_mant">KM RES.</th>
				<th scope="prox_mant">HR RES.</th>
				<th scope="prox_mant">KM PAS.</th>
				<th scope="prox_mant">HR PAS.</th>
				<th>Ubicacion Faena</th>
				<th>Estado Equipo</th>
				<th>Operador</th>
			</tr>
				
				
			</thead>
			<tbody>
			<?php
			$query = "select 
			maquina.codigo, 
			maquina.marca, 
			maquina.placa,
			maquina.horometro as hr_actual,
			maquina.kilometraje as km_actual,
			taller_intervencion.fecha,
			taller_intervencion.tipo_mantencion,
			taller_intervencion.horometro as hr_mant,
			taller_intervencion.kilometraje as km_mant,
			taller_intervencion.prox_hr,
			taller_intervencion.prox_km,
			taller_intervencion.tipo_prox_mant,
			centro_costo.nombre as faena,
			taller_maquina_estado.nombre as estado_maquina,
			maquina.chofer
			from taller_intervencion
			inner join maquina on maquina.id = taller_intervencion.id_maquina
			inner join centro_costo on centro_costo.id = maquina.faena
			inner join taller_maquina_estado on taller_maquina_estado.id = maquina.estado
			where taller_intervencion.tipo_intervencion = '2'
			order by taller_intervencion.fecha";


			$result = $mysqli->query($query);
			while ($arr = $result->fetch_assoc()) {

				$km_por_recorrer = $arr['prox_km'] - $arr['km_mant'];
				$km_transcurrido = $arr['km_actual'] - $arr['km_mant'];
				$km_restante = $arr['prox_km'] - $arr['km_actual'];
				
				if($km_por_recorrer > 0){
					$km_porc_res = ($km_transcurrido / $km_por_recorrer) * 100;	
				}
				else{
					$km_porc_res = 0;
				}

				$hr_por_recorrer = $arr['prox_hr'] - $arr['hr_mant'];
				$hr_transcurrido = $arr['hr_actual'] - $arr['hr_mant'];
				$hr_restante = $arr['prox_hr'] - $arr['hr_actual'];
				if($hr_por_recorrer > 0){
					$hr_porc_res = ($hr_transcurrido / $hr_por_recorrer) * 100;	
				}
				else{
					$hr_porc_res = 0;
				}
				

				
				


				if($arr['prox_km'] != 0){
					if($km_porc_res >= 0 and $km_porc_res <= 50){
						$class_km = "km_success";
					}
					else if($km_porc_res >= 51 and $km_porc_res <= 80){
						$class_km = "km_warning";
					}
					else if($km_porc_res >= 81){
						$class_km = "km_danger";
					}
				}
				if($arr['prox_hr'] != 0){
					if($hr_porc_res >= 0 and $hr_porc_res <= 50){
						$class_hr = "hr_success";
					}
					else if($hr_porc_res >= 51 and $hr_porc_res <= 80){
						$class_hr = "hr_warning";
					}
					else if($hr_porc_res >= 81){
						$class_hr = "hr_danger";
					}
				}

				$km_pasado = ($arr['km_actual'] - $arr['prox_km']);
				if($km_pasado < 0 ){
					$km_pasado = 0;
				}
				$hr_pasado = ($arr['hr_actual'] - $arr['prox_hr']);
				if($hr_pasado < 0 ){
					$hr_pasado = 0;
				}



				$km_restante = ($arr['prox_km'] - $arr['km_actual']);
				if($km_restante < 0 ){
					$km_restante = 0;
				}
				$hr_restante = ( $arr['prox_hr'] - $arr['hr_actual']);
				if($hr_restante < 0 ){
					$hr_restante = 0;
				}



			?>
				<tr class="<?=$class_km?> <?=$class_hr?>" data-hr_porc="<?=$hr_porc_res?>" data-km_porc="<?=$km_porc_res?>">
					<td class="center"><?=$arr['codigo']?></td>
					<td><?=$arr['marca']?></td>
					<td class="center"><?=$arr['placa']?></td>
					<td class="numero"><?=number_format($arr['km_actual'])?></td>
					<td class="numero"><?=number_format($arr['hr_actual'])?></td> <!-- hr -->
					<td class="center"><?=cambiarFormatoFecha($arr['fecha'])?></td>
					<td><?=$arr['tipo_mantencion']?></td>
					<td class="numero"><?=number_format($arr['km_mant'])?></td>
					<td class="numero"><?=number_format($arr['hr_mant'])?></td> <!-- hr -->
					<td><?=$arr['tipo_prox_mant']?></td>
					<td class="numero"><?=number_format($arr['prox_km'])?></td>
					<td class="numero"><?=number_format($arr['prox_hr'])?></td>
					<td class="numero"><?=number_format($km_restante)?></td>
					<td class="numero"><?=number_format($hr_restante)?></td>
					<td class="numero"><?=number_format($km_pasado)?></td>
					<td class="numero"><?=number_format($hr_pasado)?></td>
					<td><?=$arr['faena']?></td>
					<td><?=$arr['estado_maquina']?></td>
					<td><?=$arr['chofer']?></td>
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>
	</div>


	
</div>

<?php
print_footer();
?>