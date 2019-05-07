<?php

wp_register_script('bootstrap_js_skm', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', ['jquery'], false, true );
wp_register_script('popper_js_skm', get_stylesheet_directory_uri() . '/js/popper.min.js', ['bootstrap_js_skm'], false, true );
wp_register_script('fontawesome-all_skm', get_stylesheet_directory_uri() . '/js/fontawesome-all.js', ['jquery'], false, true );
wp_register_script('isotope_js_skm', get_stylesheet_directory_uri() . '/js/isotope.min.js', ['jquery'], false, true );
wp_register_script('skirmisher_js', get_stylesheet_directory_uri() . '/js/skirmisher_theme.js', ['isotope_js_skm'], false, true );

add_action('wp_enqueue_scripts', 'add_theme_scripts_deps' );
add_action('admin_enqueue_scripts', 'add_theme_scripts_deps' );
function add_theme_scripts_deps(){
    wp_enqueue_script( 'bootstrap_js_skm' );
    wp_enqueue_script( 'popper_js_skm' );
    wp_enqueue_script( 'fontawesome-all_skm' );
    wp_enqueue_script( 'isotope_js_skm' );
    wp_enqueue_script( 'skirmisher_js' );
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


add_action( 'widgets_init', 'skm_sidebar_init' );
function skm_sidebar_init(){
  register_sidebar( array(
    'name'          => 'Barra lateral SKM',
    'id'            => 'skm-header-sidebar',
    'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentysixteen' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );

  register_sidebar( array(
    'name'          => 'Barra lateral SKM',
    'id'            => 'skm-sidebar',
    'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentysixteen' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );
}

add_action( 'admin_menu', 'skm_no_admin_menu' );
function skm_no_admin_menu(){

  if( is_user_logged_in() ) {
     $user = wp_get_current_user();
     $roles = ( array ) $user->roles;
     if ($roles[0] == 'administrator')
      remove_menu_page( 'edit.php?post_type=page' );
      remove_menu_page( 'tools.php' );
      remove_menu_page( 'admin.php?page=sharing' );
  }
}


require_once("inc/util.php");
require_once("inc/components.php");

?>
