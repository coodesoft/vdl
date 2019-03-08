<?php
/**
 * @package Skirmisher
 */
/*
Plugin Name: Skirmisher Weather
Description: Plugin para la visualización del clima (temperatura actual) en las ciudades de Rauch y Tandil
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

wp_enqueue_style( 'skm_weather',  plugins_url('/css/skirmisher_weather.css', __FILE__));


define( 'WEATHER_API_URI' , "http://api.openweathermap.org/data/2.5/weather?" );
define( 'WEATHER_API_LANG', 'es' );
define( 'WEATHER_API_UNITS', 'metric' );
define( 'WEATHER_API_KEY', 'd3b384709cb93d02e399be36ddc6c714' );

function getAPIUrl($city){
  $url = WEATHER_API_URI.'q='.$city;
  $url .= '&units=' . WEATHER_API_UNITS;
  $url .= '&lang='  . WEATHER_API_LANG;
  $url .= '&APPID=' . WEATHER_API_KEY;
  return $url;
}

function getWeatherInfo($city){
  $url =  getAPIUrl($city);
  return wp_remote_get($url);

}

function skirmisher_weather_html(){
  $info = getWeatherInfo('Tandil,AR');
  $data = $info['body'];
  $data = json_decode($data, true);

	$temp = $data['main']['temp'];
	$weather = $data['weather'][0]['description'];
?>
	<div id="skm-weather" class="d-none d-lg-block">
		<div>
			<div class="skm_w_label">CLIMA</div>
			<div class="skm_w_content"><?php echo ucfirst($weather)?></div>
		</div>
		<div>
			<div class="skm_w_temp"><?php echo round($temp, 1) ?>°</div>
		</div>
	</div>
<?php }



add_shortcode('skm_weather', 'global_skirmisher_weather');
function global_skirmisher_weather($atts){
  return skirmisher_weather_html();
}
