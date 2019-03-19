<?php
/**
 * @package Skirmisher
 */
/*
Plugin Name: Skirmisher Radios Links
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

wp_enqueue_style( 'skm_radios',  plugins_url('/css/skm_radios.css', __FILE__) );

function skirmisher_radios_html(){?>
	<div id="skm-radio-wrapper">

		<div id="skm-radio-cristal" class="skm-radio">
				<div class="skm-radio-mic">
					<img src="<?php echo plugins_url('/img/mic.png', __FILE__) ?>" alt="mic image">
				</div>
				<div class="skm-radio-text">
					<div class="skm-radio-title skm-radio-info">
						<div>RADIO CRISTAL <span>EN VIVO</span></div>
					</div>
					<div class="skm-radio-desc skm-radio-info">
						<div>PANORAMA INFORMÁTIVO</div>
					</div>
				</div>
				<div class="skm-radio-btn">
					<div class="skm-radio-circle">
						<a target="_blank" href="#">
							<div class="skm-radio-link"></div>
						</a>
					</div>
				</div>
		</div>

		<div id="skm-radio-lacompania" class="skm-radio">
				<div class="skm-radio-mic">
					<img src="<?php echo plugins_url('/img/mic.png', __FILE__) ?>" alt="mic image">
				</div>
				<div class="skm-radio-text">
					<div class="skm-radio-title skm-radio-info">
						<div>RADIO LA COMPAÑÍA <span>EN VIVO</span></div>
					</div>
					<div class="skm-radio-desc skm-radio-info">
						<div>PANORAMA INFORMÁTIVO</div>
					</div>
				</div>
				<div class="skm-radio-btn">
					<div class="skm-radio-circle">
						<a target="_blank" href="#">
							<div class="skm-radio-link"></div>
						</a>
					</div>
				</div>
		</div>

	</div>
<?php }


add_shortcode('skm_radios', 'global_skirmisher_radios');
function global_skirmisher_radios($atts){
  return skirmisher_radios_html();
}
