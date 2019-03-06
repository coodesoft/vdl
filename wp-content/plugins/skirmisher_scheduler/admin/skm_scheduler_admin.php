<?php

/*
 * Definicion de HOOKS
 */
add_action('admin_menu', 'skm_schedule_admin_menu');
function skm_schedule_admin_menu(){
	add_menu_page('Skirmisher Scheduler', 'Skirmisher Scheduler', 'manage_options', 'global_skirmisher_scheduler', 'global_skirmisher_admin');
}

wp_register_script('skm_scheduler_admin', plugins_url('/js/skm_scheduler.js', __FILE__), ['jquery'], false, true );
add_action('admin_enqueue_scripts', 'add_scripts_admin' );
function add_scripts_admin(){
    wp_enqueue_script( 'skm_scheduler_admin' );
}

add_action('admin_enqueue_scripts', 'add_stylesheet_admin' );
function add_stylesheet_admin($hook){
	if($hook != 'toplevel_page_global_skirmisher_scheduler')
  	return;
	wp_enqueue_style( 'skm_scheduler',  plugins_url('/css/skm_scheduler.css', __FILE__) );
}

/*
 * Inclusión de las áreas administrativas
 */

require_once 'skm_scheduler_tab.php';
require_once 'skm_radios_tab.php';


function global_skirmisher_admin(){

	$screen =  get_current_screen();
	$pluginPageUID = $screen->parent_file;
?>

	<div id="skirmisherAdminArea">
		<h3 class="panel-title">Programación radial de Voces del Langueyú</h3>

		<h2 class="nav-tab-wrapper">
			<a href="<?= admin_url('admin.php?page='.$pluginPageUID.'&tab=radios')?>" class="nav-tab">Radios</a>
			<a href="<?= admin_url('admin.php?page='.$pluginPageUID.'&tab=scheduler')?>" class="nav-tab">Programación </a>
		</h2>
	</div>

	<div class="panel-body">
		<?php $activeTab = $_GET['tab']; ?>

		<?php if (!isset($activeTab)){ ?>
			<div><?php	skm_radios_tab(); ?></div>
		<?php } ?>

		<?php if ($activeTab == 'radios'){ ?>
			<div><?php	skm_radios_tab(); ?></div>
		<?php } ?>

		<?php if ($activeTab == 'scheduler'){ ?>
			<div><?php	skm_scheduler_tab(); ?></div>
		<?php } ?>

	</div>

<?php
}
