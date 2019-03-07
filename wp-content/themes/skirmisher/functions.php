<?php


wp_register_script('bootstrap_js_skm', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', ['jquery'], false, true );
wp_register_script('popper_js_skm', get_stylesheet_directory_uri() . '/js/popper.min.js', ['bootstrap_js_skm'], false, true );
wp_register_script('fontawesome-all_skm', get_stylesheet_directory_uri() . '/js/fontawesome-all.js', ['jquery'], false, true );

add_action('wp_enqueue_scripts', 'add_theme_scripts_deps' );
add_action('admin_enqueue_scripts', 'add_theme_scripts_deps' );
function add_theme_scripts_deps(){
    wp_enqueue_script( 'bootstrap_js_skm' );
    wp_enqueue_script( 'popper_js_skm' );
    wp_enqueue_script( 'fontawesome-all_skm' );
}



add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
   wp_enqueue_style( 'bootstrap_css_skm',  get_stylesheet_directory_uri().'/css/bootstrap.min.css' );
}

add_action('admin_enqueue_scripts', 'enquete_admin_style_deps' );
function enquete_admin_style_deps(){
  wp_enqueue_style( 'bootstrap_css_admin_skm',  get_stylesheet_directory_uri().'/css/bootstrap.min.css' );
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

add_action('wp_head', 'skirmisher_ajaxurl');
function skirmisher_ajaxurl() {
    echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}

require_once("inc/util.php");
require_once("inc/components.php");

?>
