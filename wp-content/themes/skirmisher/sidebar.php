<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<aside id="secondary" class="skm-sidebar sidebar widget-area" role="complementary">
	<?php echo do_shortcode('[skm_radios]');?>
	<?php echo do_shortcode('[recent_facebook_posts]');?>
</aside><!-- .sidebar .widget-area -->
