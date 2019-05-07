<?php
wp_register_script('skm_scheduler_public', plugins_url('/js/skm_scheduler.js', __FILE__), ['jquery'], false, true );
add_action('wp_enqueue_scripts', 'add_scripts_public' );
function add_scripts_public(){
    wp_enqueue_script( 'skm_scheduler_public' );
}

wp_enqueue_style( 'skm_scheduler_public',  plugins_url('/css/skm_scheduler.css', __FILE__));


function skirmisher_public_html(){
    $radios = Radios::getAll();
    $schedule = Schedule::getByRadioAndDay($radios[0]['id'], 'sun');
  ?>
  <div id="skirmisherScheduler" data-radio="undefined" data-day="undefined">

    <div id="skmRadios">
      <ul>
      <?php foreach ($radios as $key => $radio) {
        $classes = $key == 0 ? 'schedule-active' : '';
      ?>
        <li class="radio-item <?php echo $classes ?>" data-id="<?php echo $radio['id'] ?>"><?php echo $radio['radio']?></li>
      <?php } ?>
      </ul>
    </div>

    <ul class="d-none d-md-inline-block text-center">
      <li class="schedule-selection schedule-active" data-day="sun">Domingo</li>
      <li class="schedule-selection" data-day="mon">Lunes</li>
      <li class="schedule-selection" data-day="tue">Martes</li>
      <li class="schedule-selection" data-day="wed">Miércoles</li>
      <li class="schedule-selection" data-day="thu">Jueves</li>
      <li class="schedule-selection" data-day="fri">Viernes</li>
      <li class="schedule-selection" data-day="sat">Sábado</li>
    </ul>

    <ul class="d-md-none d-inline-block text-center">
      <li class="schedule-selection schedule-active" data-day="sun">D</li>
      <li class="schedule-selection" data-day="mon">L</li>
      <li class="schedule-selection" data-day="tue">M</li>
      <li class="schedule-selection" data-day="wed">M</li>
      <li class="schedule-selection" data-day="thu">J</li>
      <li class="schedule-selection" data-day="fri">V</li>
      <li class="schedule-selection" data-day="sat">S</li>
    </ul>

    <div id="shedulerContainer" class="row">
      <?php foreach ($schedule as $key => $data): ?>
        <div class="schedule-container col-12">
          <div class="schedule-header d-inline-block">
            <div class="schedule-head d-inline-block"><?php echo $data['begin_time'].' - '.$data['end_time']?></div>
            <div class="schedule-head d-inline-block"><?php echo strtoupper($data['post_title'])?></div>
          </div>
          <div class="schedule-body">
            <?php echo $data['post_content'] ?>
          </div>
        </div>
      <?php endforeach;?>
    </div>
  </div>

<?php }


function skm_render_content($schedule){
    foreach ($schedule as $key => $data): ?>
      <div class="schedule-container col-12">
        <div class="schedule-header d-inline-block">
          <div class="schedule-head d-inline-block"><?php echo $data['begin_time'].' - '.$data['end_time']?></div>
          <div class="schedule-head d-inline-block"><?php echo strtoupper($data['post_title'])?></div>
        </div>
        <div class="schedule-body">
          <?php echo $data['post_content'] ?>
        </div>
      </div>
    <?php endforeach;
}

add_action( 'wp_ajax_skm_load_schedule', 'skm_load_schedule' );
add_action( 'wp_ajax_nopriv_skm_load_schedule', 'skm_load_schedule' );
function skm_load_schedule(){
  $day = $_POST['schedule_id'];
  $radio_id = $_POST['radio_id'];

  if ($day == 'undefined' || $day == null)
    $day = 'sun';

  if ($radio_id == 'undefined'){
    $radios = Radios::getAll();
    $radio_id = $radios[0]['id'];
  }


  if (strlen($day) != 3 || !intval($radio_id))
    exit;

  $schedule = Schedule::getByRadioAndDay($radio_id, $day);

  if (count($schedule) == 0){
    echo '<div class="col-12">No hay eventos programados para la fecha</div>';
    wp_die();
  }
  skm_render_content($schedule);
  wp_die();
}

add_shortcode('skm_schedule', 'global_skirmisher_public');
function global_skirmisher_public($atts){
  return skirmisher_public_html();
}
