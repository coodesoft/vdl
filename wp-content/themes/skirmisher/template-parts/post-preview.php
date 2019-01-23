<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Skirmisher
 * @since Skirmisher 1.0
 */


$post_id = get_the_ID();

$post = get_post(get_the_ID(), 'ARRAY_A');

?>

<article id="post-<?php echo $post_id ?>">

  <?php echo get_the_title() ?>
  <?php the_category(); ?>
  <?php echo get_the_excerpt($post_id)?>


</article>
