<?php

function skm_schedule_table(){ ?>
  <?php $events = Schedule::getAll(); ?>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">Programa</th>
        <th scope="col">Dom</th>
        <th scope="col">Lun</th>
        <th scope="col">Mar</th>
        <th scope="col">Mié</th>
        <th scope="col">Jue</th>
        <th scope="col">Vie</th>
        <th scope="col">Sáb</th>
        <th scope="col">Hora</th>
        <th scope="col">Radio</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($events) == 0) { ?>
        <tr>
          <td colspan="10" class="text-center">No hay programación cargada</td>
        </tr>
      <?php } ?>
      <?php foreach ($events as $key => $event): ?>
        <tr class="schedule-<?php echo $event['schedule_id'] ?>" data-id="<?php echo $event['schedule_id'] ?>">
          <form>
            <td><?php echo $event['post_title']?></td>
            <td class="d-none"><input type="text" name="eventSelect" value="<?php echo $event['ID']?>" placeholder="<?php echo $event['post_title']?>"></td>
            <td><input type="checkbox" disabled value="sunday" name="programDay[]" <?php echo ($event['sunday'] ? 'checked' : '')?>></td>
            <td><input type="checkbox" disabled value="monday" name="programDay[]" <?php echo ($event['monday'] ? 'checked' : '-') ?>></td>
            <td><input type="checkbox" disabled value="tuesday" name="programDay[]" <?php echo ($event['tuesday'] ? 'checked' : '-') ?>></td>
            <td><input type="checkbox" disabled value="wednesday" name="programDay[]" <?php echo ($event['wednesday'] ? 'checked' : '-') ?>></td>
            <td><input type="checkbox" disabled value="thursday" name="programDay[]" <?php echo ($event['thursday'] ? 'checked' : '-') ?>></td>
            <td><input type="checkbox" disabled value="friday" name="programDay[]" <?php echo ($event['friday'] ? 'checked' : '-') ?>></td>
            <td><input type="checkbox" disabled value="saturday" name="programDay[]" <?php echo ($event['saturday'] ? 'checked' : '-') ?>></td>
            <td class="data-text"><?php echo $event['begin_time']."-".$event['end_time']?></td>
            <td class="data-select d-none">
              <input type="time" name="horaInicio" value="<?php echo $event['begin_time']?>" disabled>
              <input type="time" name="horaFin" value="<?php echo $event['end_time']?>" disabled>
            </td>
            <td class="data-text"><?php echo $event['radio']?></td>
            <td class="data-select d-none">
              <?php $radios = Radios::getAll(); ?>
              <select id="radioSelect" name="radioSelect" required>
                <option id="emptyOption" value="0" disabled selected>Seleccione una radio</option>
                <?php foreach ($radios as $key => $obj): ?>
                  <option class="radio-<?php echo $obj['id']?>" value="<?php echo $obj['id']?>"><?php echo $obj['radio'] ?></option>
                <?php endforeach; ?>
              </select>
            </td>
            <td>
              <div class="skm-edit d-inline"><i class="fas fa-edit fa-lg"></i></div>
              <div class="skm-delete d-inline"><i class="fas fa-trash-alt fa-lg"></i></div>

              <div class="skm-confirm-edit d-none"><i class="fas fa-check-circle fa-lg"></i></div>
              <div class="skm-cancel-edit d-none"><i class="fas fa-times-circle fa-lg"></i></div>
            </td>
          </form>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<? }

function skm_scheduler_tab(){
  $args = array( 'post_type' => 'events' );
  $the_query = new WP_Query( $args );

  $events = get_posts([
	    'post_type' => 'events',
	    'post_status' => 'publish',
	    'numberposts' => -1
	]);
  $radios = Radios::getAll();
  ?>

	<div id="skmSchedulerAdminArea" class="skm-container container-fluid">

  		<div class="row">
  			<div class="response alert d-none" role="alert"></div>
  		</div>

      <form id="eventsForm">
        <div class="row">
			    <div class="col-md-4">

            <div class="form-group col-12">
			        <label for="eventsSelect" class="col-form-label" >Eventos: </label>
			        <select class="form-control" id="eventsSelect" name="eventSelect" required>
			          <option  id="emptyOption" data-index="0" value="0" disabled selected>Seleccione un evento</option>
			          <?php foreach ($events as $key => $event): ?>
			            <option data-index="<?php echo $key + 1 ?>" value="<?php echo $event->ID?>" class="schedule-<?php echo $event->ID?>"><?php echo $event->post_title ?></option>
			          <?php endforeach; ?>
			        </select>
			      </div>

            <div class="form-group col-12">
              <label for="radioSelect" class="col-form-label">Radio</label>
                <select class="form-control" id="radioSelect" name="radioSelect" required>
                  <option id="emptyOption" value="0" disabled selected>Seleccione una radio</option>
                  <?php foreach ($radios as $key => $obj): ?>
                    <option class="radio-<?php echo $obj['id']?>" value="<?php echo $obj['id']?>"><?php echo $obj['radio'] ?></option>
                  <?php endforeach; ?>
                </select>
            </div>

			    </div>

          <div class="col-md-4">
  						<label for="eventsSelect">Seleccione los días de emisión:</label>
  						<div id="selectDays" class="form-check">
                <input type="checkbox" id="selectAll">Todos<br>
  						  <input type="checkbox" name="programDay[]" id="sunday" value="sunday">Domingo<br>
  							<input type="checkbox" name="programDay[]" id="monday" value="monday">Lunes<br>
  							<input type="checkbox" name="programDay[]" id="tuesday" value="tuesday">Martes<br>
  							<input type="checkbox" name="programDay[]" id="wednesday" value="wednesday">Miércoles<br>
  							<input type="checkbox" name="programDay[]" id="thursday" value="thursday">Jueves<br>
  							<input type="checkbox" name="programDay[]" id="friday" value="friday">Viernes<br>
  							<input type="checkbox" name="programDay[]" id="saturday" value="saturday">Sábado<br>
  						</div>
					</div>

          <div class="col-md-4">
						<div class="form-group row">

              <div class="col-12">
						  	<label for="horaInicio" class="col-12 col-form-label">Hora de Inicio</label>
						  	<div class="col-12">
						    	<input class="form-control" type="time" value="13:00" id="horaInicio" name="horaInicio">
						  	</div>
							</div>

							<div class="col-12">
								<label for="horaFin" class="col-12 col-form-label">Hora de Fin</label>
							  <div class="col-12">
							    <input class="form-control" type="time" value="14:00" id="horaFin" name="horaFin">
							  </div>
							</div>

            </div>
			    </div>
			  </div>

				<div class="row">
					<div id="buttonArea" class="col-12">
						<button id="addEventSchedule" type="button" class="btn btn-dark">Cargar</button>
					</div>
        </div>
    </form>

			<div class="row">
        <?php skm_schedule_table() ?>
			</div>
</div>
<?php }



add_action( 'wp_ajax_skm_add_event', 'skirmisher_add_event' );
function skirmisher_add_event(){
	$params = array();
	parse_str($_POST['events'], $params);
	$toSave['event_id'] = $params['eventSelect'];
  $toSave['radio_id'] = $params['radioSelect'];
	$toSave['begin_time'] = $params['horaInicio'];
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
		echo json_encode(['result' => false, 'msg' => 'Ops, hay algo mal que no anda bien. Se produjo un error al guardar la programación' ]);
	wp_die();
}

add_action( 'wp_ajax_skm_delete_event', 'skirmisher_delete_event' );
function skirmisher_delete_event(){
	$params = array();
	parse_str($_POST, $params);

	$result = Schedule::delete($_POST['to_delete']);
	if (!$result)
		echo json_encode(['result' => $result, 'msg' => 'Se produjo un error inesperado el eliminar el evento. Consulte con el administrador!']);
	else
		echo json_encode(['result' => $result, 't_delete' => $_POST['to_delete']] );
	wp_die();
}

add_action( 'wp_ajax_skm_edit_event', 'skirmisher_edit_event' );
function skirmisher_edit_event(){

  if ($_SERVER['REQUEST_METHOD'] === 'POST'){

  } else{
    $id = $_GET['toEditId'];
    $schedule = Schedule::getById($id);

    if (count($schedule)>0)
      echo json_encode( ['result' => true, 'obj' => $schedule[0]] );
    else
      echo json_encode( ['result' => false, 'msg' => 'Ops, hay algo mal que no anda bien. No se pudo cargar la programación solicitada para su edición.'] );
    wp_die();
  }
}

add_action( 'wp_ajax_skm_confirm_edit_event', 'skirmisher_confirm_edit_event' );
function skirmisher_confirm_edit_event(){
  $params = array();
  parse_str($_POST['data'], $params);
  echo json_encode($params);
  wp_die();
}
