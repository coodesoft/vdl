<?php 


function skirmisher_post_slider(){ 

	$args = array( 'category_name' => 'Slider' );
	$sliderPosts = get_posts( $args );
	//echo json_encode($sliderPosts[0]);
?>


	<div id="skirmisher-slider" class="carousel slide" data-ride="carousel">

	  <div class="carousel-inner">
		
		<?php  foreach( $sliderPosts as $key => $post ) : ?>
			<div class="carousel-item <?php echo ($key==0) ? 'active' : '' ?>">
				<?php $ruta_imagen = skirmisher_attachment_img($post->ID) ?>
				<div class="row">
					<div class="col-md-6">
						<div class="carousel-caption w-100">
							<h5><?php echo $post->post_title ?></h5>
							<p><?php echo $post->post_excerpt ?></p>
						</div>
					</div>
					<div class="col-md-6">
						<img class="w-100" src="<?php echo esc_url($ruta_imagen) ?>" alt="<?php echo $post->post_title ?>">
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	  </div>
	  
	  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	  </a>
	  
	  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	  </a>
	</div>
	
<?php } ?>
	