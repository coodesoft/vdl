<?php


wp_register_script('jquery_js_skm', get_template_directory_uri() . '/js/jquery-3.2.1.min.js', [], false, true );
wp_register_script('bootstrap_js_skm', get_template_directory_uri() . '/js/bootstrap.min.js', ['jquery_js_skm'], false, true );
wp_register_script('popper_js_skm', get_template_directory_uri() . '/js/popper.min.js', [], false, true );
wp_register_script('fontawesome-all_skm', get_template_directory_uri() . '/js/fontawesome-all.js', [], false, true );

add_action('wp_enqueue_scripts', 'add_theme_scripts_deps' );
function add_theme_scripts_deps(){
    wp_enqueue_script( 'jquery_js');
    wp_enqueue_script( 'popper_js' );
    wp_enqueue_script( 'bootstrap_js');
    wp_enqueue_script( 'fontawesome-all' );
}



add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

add_action( 'init', 'register_my_menu' );
function register_my_menu() {
  register_nav_menu( 'skirmisher-nav', __( 'Navegación', 'Skirmisher' ) );
}


add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}

require_once("inc/util.php");
require_once("inc/components.php");

?>
