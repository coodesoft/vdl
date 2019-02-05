<?php
wp_register_script('skm_scheduler_public', plugins_url('/js/skm_scheduler.js', __FILE__), ['jquery_js'], false, true );
add_action('wp_enqueue_scripts', 'add_scripts_public' );
function add_scripts_public(){
    wp_enqueue_script( 'skm_scheduler_public' );
}

wp_enqueue_style( 'skm_scheduler_public',  plugins_url('/css/skm_scheduler.css', __FILE__));


function skirmisher_public_html(){
    $schedule = Schedule::getByDay('sun');
?>
  <div id="skirmisherScheduler">
    <ul>
      <li class="schedule-selection schedule-active" data-day="sun">Domingo</li>
      <li class="schedule-selection" data-day="mon">Lunes</li>
      <li class="schedule-selection" data-day="tue">Martes</li>
      <li class="schedule-selection" data-day="wed">Miércoles</li>
      <li class="schedule-selection" data-day="thu">Jueves</li>
      <li class="schedule-selection" data-day="fri">Viernes</li>
      <li class="schedule-selection" data-day="sat">Sábado</li>
    </ul>

    <div id="shedulerContainer" class="row">
      <?php foreach ($schedule as $key => $data): ?>
        <div class="schedule-container col-12">
          <div class="schedule-header">
            <div class="schedule-head"><?php echo $data['timetable']?></div>
            <div class="schedule-head"><?php echo strtoupper($data['post_title'])?></div>
          </div>
          <div class="schedule-body">
            <?php echo $data['post_content'] ?>
          </div>
        </div>
      <?php endforeach;?>
    </div>
  </div>

<?php }

add_action( 'wp_ajax_skm_load_schedule', 'skm_load_schedule' );
function skm_load_schedule(){
  $day = $_POST['schedule_id'];

  if (strlen($day) != 3)
    exit;

  $schedule = Schedule::getByDay($day);

  if (count($schedule) == 0){
    echo 'No hay eventos programados para la fecha';
    wp_die();
  }


  foreach ($schedule as $key => $data): ?>
    <div class="schedule-container col-12">
      <div class="schedule-header">
        <div class="schedule-head"><?php echo $data['timetable']?></div>
        <div class="schedule-head"><?php echo strtoupper($data['post_title'])?></div>
      </div>
      <div class="schedule-body">
        <?php echo $data['post_content'] ?>
      </div>
    </div>
  <?php endforeach;
  wp_die();
}


add_shortcode('skm_schedule', 'global_skirmisher_public');
function global_skirmisher_public($atts){
  return skirmisher_public_html();
}
