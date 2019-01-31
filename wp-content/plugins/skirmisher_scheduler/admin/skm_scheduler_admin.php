<?php

add_action('admin_menu', 'skm_schedule_admin_menu');
function skm_schedule_admin_menu(){
	add_menu_page('Skirmisher Scheduler', 'Skirmisher Scheduler', 'manage_options', 'global_skirmisher_scheduler', 'global_skirmisher_admin');
}

function global_skirmisher_admin(){
  $args = array( 'post_type' => 'events' );
  $the_query = new WP_Query( $args );

  $events = get_posts([
    'post_type' => 'events',
    'post_status' => 'publish',
    'numberposts' => -1
  ]);



  //echo json_encode($posts);


?>

<div class="skm_scheduler_header">
    <h2>Smkirmisher Scheduler Admin Área</h2>
</div>

<form id="eventsForm">
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="eventsSelect">Eventos: </label>
        <select class="form-control" id="eventsSelect">
          <option value="0" disabled selected>Seleccione un evento</option>
          <?php foreach ($events as $key => $event): ?>
            <option value="<?php echo $event->ID?>"><?php echo $event->post_title ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="monday" id="monday">
        <label class="form-check-label" for="monday">Lunes</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="tuesday" id="tuesday">
        <label class="form-check-label" for="tuesday">Martes</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="wednesday" id="wednesday">
        <label class="form-check-label" for="wednesday">Miércoles</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="thursday" id="thursday">
        <label class="form-check-label" for="thursday">Jueves</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="friday" id="friday">
        <label class="form-check-label" for="friday">Viernes</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="saturday" id="saturday">
        <label class="form-check-label" for="saturday">Sábado</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="sunday" id="sunday">
        <label class="form-check-label" for="sunday">Domingo</label>
      </div>



    </div>
    <div class="col-md-4"></div>
  </div>
</form>

<?php } ?>
