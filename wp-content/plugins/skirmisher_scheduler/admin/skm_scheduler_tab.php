<?php

function skm_scheduler_tab(){
  $args = array( 'post_type' => 'events' );
  $the_query = new WP_Query( $args );

  $events = get_posts([
	    'post_type' => 'events',
	    'post_status' => 'publish',
	    'numberposts' => -1
	]);
  ?>

	<div id="skmSchedulerAdminArea" class="container-fluid">
			<div class="skm_scheduler_header">
			    <h4>Smkirmisher Scheduler Admin Área</h4>
			</div>

			<form id="eventsForm">
			  <div class="row">
			    <div class="col-md-4">
			      <div class="form-group">
			        <label for="eventsSelect">Eventos: </label>
			        <select class="form-control" id="eventsSelect" name="eventSelect" required>
			          <option id="emptyOption" value="0" disabled selected>Seleccione un evento</option>
			          <?php foreach ($events as $key => $event): ?>
			            <option value="<?php echo $event->ID?>"><?php echo $event->post_title ?></option>
			          <?php endforeach; ?>
			        </select>
			      </div>
			    </div>
					<div class="col-md-4">
						<label for="eventsSelect">Seleccione los días de emisión:</label>
						<div class="form-check">
						  <input type="checkbox" name="programDay[]" value="sunday">Domingo<br>
							<input type="checkbox" name="programDay[]" value="monday">Lunes<br>
							<input type="checkbox" name="programDay[]" value="tuesday">Martes<br>
							<input type="checkbox" name="programDay[]" value="wednesday">Miércoles<br>
							<input type="checkbox" name="programDay[]" value="thursday">Jueves<br>
							<input type="checkbox" name="programDay[]" value="friday">Viernes<br>
							<input type="checkbox" name="programDay[]" value="saturday">Sábado<br>
						</div>
					</div>
			    <div class="col-md-4">
						<div class="form-group row">
							<div class="col-md-6 col-12">
						  	<label for="horaInicio" class="col-12 col-form-label">Hora de Inicio</label>
						  	<div class="col-12">
						    	<input class="form-control" type="time" value="13:00" id="horaInicio" name="horaInicio">
						  	</div>
							</div>
							<div class="col-md-6 col-12">
								<label for="horaFin" class="col-12 col-form-label">Hora de Fin</label>
							  <div class="col-12">
							    <input class="form-control" type="time" value="14:00" id="horaFin" name="horaFin">
							  </div>
							</div>
						</div>
			    </div>
			  </div>
				<div class="row">
					<div class="col-12">
						<button id="addEventSchedule" type="button" class="btn btn-dark">Agregar Evento</button>
					</div>
				</div>
			</form>

			<div class="row">
				<div class="response alert d-none" role="alert"></div>
			</div>
			<div class="row">
				<?php $events = Schedule::getAll(); ?>
				<?php if (count($events)) { ?>
					<table class="table table-striped">
					  <thead>
					    <tr>
					      <th scope="col">Programa</th>
					      <th scope="col">Domingo</th>
					      <th scope="col">Lunes</th>
								<th scope="col">Martes</th>
								<th scope="col">Miércoles</th>
								<th scope="col">Jueves</th>
								<th scope="col">Viernes</th>
								<th scope="col">Sábado</th>
								<th scope="col">Horario</th>
								<th scope="col">Acciones</th>
					    </tr>
					  </thead>
					  <tbody>
							<?php foreach ($events as $key => $event): ?>
								<?php $eventDesc = Schedule::getEventById($event['event_id']); ?>
								<tr data-id="<?php echo $event['id'] ?>">
									<td><?php echo $eventDesc['post_title']?></td>
									<td><?php echo ($event['sunday'] ? 'Sí' : '-')?></td>
									<td><?php echo ($event['monday'] ? 'Sí' : '-') ?></td>
									<td><?php echo ($event['tuesday'] ? 'Sí' : '-') ?></td>
									<td><?php echo ($event['wednesday'] ? 'Sí' : '-') ?></td>
									<td><?php echo ($event['thursday'] ? 'Sí' : '-') ?></td>
									<td><?php echo ($event['friday'] ? 'Sí' : '-') ?></td>
									<td><?php echo ($event['saturday'] ? 'Sí' : '-') ?></td>
									<td><?php echo $event['timetable']?></td>
									<td><i class="fas fa-trash-alt skirmisher-delete"></i></td>
								</tr>
							<?php endforeach; ?>
					  </tbody>
					</table>
				<?php }else { ?>
					<div class="col-12">No hay eventos registrados</div>
				<?php } ?>
			</div>
	</div>
<?php }



add_action( 'wp_ajax_skm_add_event', 'skirmisher_add_event' );
function skirmisher_add_event(){
	$params = array();
	parse_str($_POST['events'], $params);
	$toSave['event_id'] = $params['eventSelect'];
	$toSave['bedin_time'] = $params['horaInicio'];
  $toSave['end_time'] = $params['horaFin'];
	$toSave['sunday'] = 0;
	$toSave['monday'] = 0;
	$toSave['tuesday'] = 0;
	$toSave['wednesday'] = 0;
	$toSave['thursday'] = 0;
	$toSave['friday'] = 0;
	$toSave['saturday'] = 0;

	foreach ($params['programDay'] as $key => $value) {
		$toSave[$value] = 1;
	}

	$schedule_id = Schedule::add($toSave);

	if ($schedule_id){
 	  $schedule = Schedule::getById($schedule_id);
		$toSave['id'] = $schedule_id;
		$toSave['title'] = $schedule[0]['post_title'];
		echo json_encode(['result' => true, 'schedule' => $toSave]);
	} else
		echo json_encode(['result' => false, 'msj' => 'Ops, hay algo mal que no anda bien. Se produjo un error al guardar la programación' ]);
	wp_die();
}

add_action( 'wp_ajax_skm_delete_event', 'skirmisher_delete_event' );
function skirmisher_delete_event(){
	$params = array();
	parse_str($_POST, $params);

	$result = Schedule::delete($_POST['to_delete']);
	if (!$result)
		echo json_encode(['result' => $result, 'msj' => 'Se produjo un error inesperado el eliminar el evento. Consulte con el administrador!']);
	else
		echo json_encode(['result' => $result, 't_delete' => $_POST['to_delete']] );
	wp_die();
}
