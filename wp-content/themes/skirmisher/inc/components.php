<?php


function the_skirmisher_post_categories($post_id = null, $rootCat = true){ ?>
	<ul class="skirmisher-nav-links">
    <?php
      $categories = get_the_category($post_id);
      foreach ($categories as $key => $cat) {
		if ($rootCat || $cat->parent != 0) {
			$category_link = get_category_link( $cat->term_id );
      ?>
		  <li>
			<a href="<?php echo esc_url( $category_link ); ?>" title="Category Name"><?php echo $cat->name ?></a>
		  </li>
		<?php }
	  } ?>
    </ul>
<?php
}

function the_skirmisher_subcategories($parent_catId, $currentCat){ ?>
	<ul class="skirmisher-nav-links">
		 <?php
			 $childcats = get_categories('child_of=' . $parent_catId . '&hide_empty=0');
			 foreach ($childcats as $childcat) { ?>
			 	<li class="subcategory-item <?php echo ($childcat->cat_ID==$currentCat->cat_ID) ? 'current-subcategory-item' : ''?>">
					<a href="<?php echo get_category_link($childcat->cat_ID)?>" title="<?php echo $childcat->category_description ?>">
			    	<?php echo $childcat->cat_name ?>
					</a>
				</li>
		 <?php } ?>
	</ul>


<?php
}

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
						<img class="w-100" src="<?php echo esc_url($ruta_imagen) ?>" alt="<?php echo $post->post_title ?>">
					</div>
					<div class="col-md-6">
						<div class="skirmisher-slider-content w-100">
							<?php the_skirmisher_post_categories($post_id, false) ?>
							<a class="post-link"href="<?php echo esc_url(get_post_permalink($post_id))?>">
							<h3><?php echo $post->post_title ?></h3>
							<p><?php echo $post->post_excerpt ?></p>
							</a>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	  </div>
	  <ol class="carousel-indicators">
		<li data-target="#skirmisher-slider" data-slide-to="0" class="active"></li>
		<li data-target="#skirmisher-slider" data-slide-to="1"></li>
		<li data-target="#skirmisher-slider" data-slide-to="2"></li>
	  </ol>
	</div>

<?php } ?>
