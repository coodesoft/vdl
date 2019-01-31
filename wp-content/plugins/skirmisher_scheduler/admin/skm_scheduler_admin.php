<?php

add_action('admin_menu', 'skm_schedule_admin_menu');
function skm_schedule_admin_menu(){
	add_menu_page('Skirmisher Scheduler', 'Skirmisher Scheduler', 'manage_options', 'global_skirmisher_scheduler', 'global_skirmisher_admin');
}

wp_register_script('skm_scheduler', plugins_url('/js/skm_scheduler.js', __FILE__), ['jquery_js'], false, true );
add_action('admin_enqueue_scripts', 'add_scripts_admin' );
function add_scripts_admin(){
    wp_enqueue_script( 'skm_scheduler');
}


require_once 'db/Schedule.php';

function global_skirmisher_admin(){
  $args = array( 'post_type' => 'events' );
  $the_query = new WP_Query( $args );

  $events = get_posts([
	    'post_type' => 'events',
	    'post_status' => 'publish',
	    'numberposts' => -1
	]);
  ?>

	<div id="smkSchedulerAdminArea" class="container-fluid">
			<div class="skm_scheduler_header">
			    <h4>Smkirmisher Scheduler Admin Área</h4>
			</div>

			<form id="eventsForm">
			  <div class="row">
			    <div class="col-md-4">
			      <div class="form-group">
			        <label for="eventsSelect">Eventos: </label>
			        <select class="form-control" id="eventsSelect" name="eventSelect">
			          <option value="0" disabled selected>Seleccione un evento</option>
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
						    	<input class="form-control" type="time" value="13:00:00" id="horaInicio" name="horaInicio">
						  	</div>
							</div>
							<div class="col-md-6 col-12">
								<label for="horaFin" class="col-12 col-form-label">Hora de Fin</label>
							  <div class="col-12">
							    <input class="form-control" type="time" value="14:00:00" id="horaFin" name="horaFin">
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
				<?php $events = Schedule::getAll(); ?>
				<?php if (count($events)) { ?>
					<table class="table table-striped">
					  <thead>
					    <tr>
					      <th scope="col">id</th>
					      <th scope="col">Programa</th>
					      <th scope="col">Domingo</th>
					      <th scope="col">Lunes</th>
								<th scope="col">Martes</th>
								<th scope="col">Miércoles</th>
								<th scope="col">Jueves</th>
								<th scope="col">Viernes</th>
								<th scope="col">Sábado</th>
								<th scope="col">Horario</th>
					    </tr>
					  </thead>
					  <tbody>
							<?php foreach ($events as $key => $event): ?>
								<?php $eventDesc = get_posts([
									    	'post_type' => 'events',
									    	'post_status' => 'publish',
												'ID' => $event->event_id,
									    	'numberposts' => -1

								]); ?>
								<tr>
						      <th scope="row"><?php echo $event['id'] ?></th>
						      <td><?php echo $eventDesc[0]->post_title?></td>
									<td><?php echo $event['sunday'] ?></td>
									<td><?php echo $event['monday']?></td>
									<td><?php echo $event['tuesday']?></td>
									<td><?php echo $event['wednesday']?></td>
									<td><?php echo $event['thursday']?></td>
									<td><?php echo $event['friday']?></td>
									<td><?php echo $event['saturday']?></td>
									<td><?php echo $event['timetable']?></td>
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
	$toSave['timetable'] = $params['horaInicio'].' - '.$params['horaFin'];

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

	$result = Schedule::add($toSave);

	echo json_encode(['status' => $result, 'data' => $toSave]);
	wp_die();
}
