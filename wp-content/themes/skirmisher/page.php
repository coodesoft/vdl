<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header();
$classes = is_page('contacto') ? 'contact-page' : '';
?>

<div id="primary" class="content-area <?php echo $classes ?>">
	<main id="main" class="site-main" role="main">

		<?php

		if (is_page('inicio')){
			skirmisher_post_slider();

			$args = ['post_type' => 'post'];
			$query = new WP_Query( $args );
			?>
			<div class="row">
				<?php
				while ( $query->have_posts() ) : $query->the_post();
					get_template_part( 'template-parts/post', 'preview' );
				endwhile;
				?>
			</div>
		<?php } else{
			// Start the loop.
			while ( have_posts() ) : the_post();

				// Include the page content template.
				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

				// End of the loop.
			endwhile;
		}
		?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php
	if ( !is_page('contacto') )
		get_sidebar();
?>
<?php get_footer(); ?>
