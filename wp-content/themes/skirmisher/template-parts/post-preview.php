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
//echo json_encode($post);

$args = array(
  'post_parent'    => $post_id,
  'post_type'      => 'attachment',
  'post_status'    => 'any',
  'numberposts'    => '1',
  'post_mime_type' => 'audio/mpeg',
);
$children = get_children( $args );
foreach ($children as $key => $value) {
$attachment_audio_url =  $value->guid;
}
?>

<div class="grid-item col-md-6">
  <div class="card skirmisher-card">
    <article id="post-<?php echo $post_id ?>">

	<?php the_skirmisher_post_categories($post_id, false) ?>

    <a class="post-link" href="<?php echo esc_url(get_post_permalink($post_id))?>">
    <div class="attachment-image">
      <?php $ruta_imagen = skirmisher_attachment_img($post_id) ?>
      <img class="card-img-top" src="<?php echo esc_url($ruta_imagen) ?>" alt="Imagen de noticia">
    </div>
    </a>
    <div class="card-body <?php echo ($attachment_audio_url == null) ? 'no-audio-attached': 'audio-attached' ?>">
      <a class="post-link" href="<?php echo esc_url(get_post_permalink($post_id))?>">
        <h5 class="card-title"><?php echo $post['post_title'] ?></h5>
        <p class="card-text"><?php echo format_excerpt( $post['post_excerpt'], 200 )?></p>
      </a>

    <?php if( $attachment_audio_url != null ){ ?>
      <audio class="skirmisher-audio" controls>
        <source src="<?php echo esc_url($attachment_audio_url) ?>" type="audio/mpeg">
      </audio>
    <?php } ?>
    </div>

    </article>
  </div>
</div>
