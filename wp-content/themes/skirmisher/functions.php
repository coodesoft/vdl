<?php


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
