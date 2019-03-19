<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

		</div><!-- .site-content -->

		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php  $url = get_site_url().'/wp-content/uploads/2019/03/logo-byn.png';?>

			<div class="footer-content">
					<div class="logo-footer d-none d-lg-inline-block">
						<img src="<?php echo $url?>" alt="ByN Logo">
					</div>

					<?php if ( has_nav_menu( 'primary' ) ) : ?>
						<nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Primary Menu', 'twentysixteen' ); ?>">
							<?php
								wp_nav_menu( array(
									'theme_location' => 'primary',
									'menu_class'     => 'primary-menu',
								 ) );
							?>
						</nav><!-- .main-navigation -->
					<?php endif; ?>

					<div class="social-footer d-none d-lg-inline-block">
						<a href="#">
							<i class="fab fa-facebook-square fa-2x"></i>
						</a>
					</div>
					<div class="footer-adds">
						<div class="footer-adds-msg">publicite en voces del langueyu</div>
					</div>

			</div>
		</footer><!-- .site-footer -->
	</div><!-- .site-inner -->
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
