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

wp_enqueue_style( 'skm_date',  plugins_url('/css/skirmisher_radios.css', __FILE__));
