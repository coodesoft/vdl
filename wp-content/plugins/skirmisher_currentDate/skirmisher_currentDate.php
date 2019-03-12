<?php
/**
 * @package Skirmisher
 */
/*
Plugin Name: Skirmisher Current Date
Description: Plugin para la visualización del dia actual
Version: 4.1
Author: Coodesoft Team
Author URI: https://www.coodesoft.com.ar
License: GPLv2 or later
Text Domain: skirmisher
*/


// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

wp_enqueue_style( 'skm_date',  plugins_url('/css/skirmisher_date.css', __FILE__));

function skirmisher_currentDate_html(){ ?>
	<div id="skm_date" class="d-none d-lg-inline-block">
		<?php
			setlocale(LC_ALL,"es_ES");
			$day = strftime("%A");
			$date = strftime("%d de %B");
			$year = strftime("del %Y");
			//echo strftime("%A %d de %B del %Y");
			?>
			<span><?php echo $date ?></span> <?php echo $year?>
	</div>
<?php }

add_shortcode('skm_date', 'global_skirmisher_currentDate');
function global_skirmisher_currentDate($atts){
  return skirmisher_currentDate_html();
}
