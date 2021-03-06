<?php
/**
 * @package Skirmisher
 */
/*
Plugin Name: Skirmisher Scheduler
Description: Plugin para la generación de programación musical/radial/actividades/eventos.
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


define( 'SKIRMISHER_BASE_PATH' , plugin_dir_path( __FILE__ ) );


/*
 * ACTIVACIÓN - Se crea la tabla de programación de eventos y se añade el tipo de dato ---------------------------
 */

function skm_schedule_create_table(){

    global $wpdb;
    $table_name = $wpdb->prefix . 'skm_schedule';
    if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            schedule_id bigint(20) NOT NULL AUTO_INCREMENT,
            event_id int(10) NOT NULL,
            sunday TINYINT(1) NOT NULL,
            monday TINYINT(1) NOT NULL,
            tuesday TINYINT(1) NOT NULL,
            wednesday TINYINT(1) NOT NULL,
            thursday TINYINT(1) NOT NULL,
            friday TINYINT(1) NOT NULL,
            saturday TINYINT(1) NOT NULL,
            begin_time varchar(10) NOT NULL,
						end_time varchar(10) NOT NULL,
						radio_id int(10) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

		$table_name = $wpdb->prefix . 'skm_radios';
    if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id bigint(20) NOT NULL AUTO_INCREMENT,
						radio varchar(100) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }


}

register_activation_hook( __FILE__, 'skm_schedule_install' );
function skm_schedule_install(){
	skm_schedule_create_table();
}

add_action( 'init', 'skirmisher_event_type', 0 );
function skirmisher_event_type() {

  // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Eventos', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'Evento', 'Post Type Singular Name', 'twentythirteen' ),
        'menu_name'           => __( 'Eventos', 'twentythirteen' ),
        'parent_item_colon'   => __( 'Evento Padre', 'twentythirteen' ),
        'all_items'           => __( 'Todos los Eventos', 'twentythirteen' ),
        'view_item'           => __( 'Ver Evento', 'twentythirteen' ),
        'add_new_item'        => __( 'Agregar Nuevo Evento', 'twentythirteen' ),
        'add_new'             => __( 'Agregar Nuevo', 'twentythirteen' ),
        'edit_item'           => __( 'Editar Evento', 'twentythirteen' ),
        'update_item'         => __( 'Actualizar Evento', 'twentythirteen' ),
        'search_items'        => __( 'Buscar Evento', 'twentythirteen' ),
        'not_found'           => __( 'No Encontrado', 'twentythirteen' ),
        'not_found_in_trash'  => __( 'No Encontrado en la Papelera', 'twentythirteen' ),
    );

    // Set other options for Custom Post Type

    $args = array(
        'label'               => __( 'eventos', 'twentythirteen' ),
        'description'         => __( 'Noticias de Eventos', 'twentythirteen' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'custom-fields', ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );

    // Registering your Custom Post Type
    register_post_type( 'events', $args );

}


/*
 * ACTIVACIÓN - se incluyen las áreas ---------------------------
 */

require_once 'db/Schedule.php';
require_once 'db/Radios.php';
require_once 'admin/skm_scheduler_admin.php';
require_once 'public/skm_scheduler_public.php';
