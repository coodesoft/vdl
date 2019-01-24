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

<div class="col-md-6">
  <div class="card skirmisher-card">
    <article id="post-<?php echo $post_id ?>">
      <ul class="skirmisher-nav-links">
    <?php
      $categories = get_the_category($post_id);
      foreach ($categories as $key => $cat) {
        $category_link = get_category_link( $cat->term_id );
      ?>
      <li>
        <a href="<?php echo esc_url( $category_link ); ?>" title="Category Name"><?php echo $cat->name ?></a>
      </li>
      <?php } ?>
    </ul>
    <a class="post-link" href="<?php echo esc_url(get_post_permalink($post_id))?>">
    <div class="attachment-image">
      <?php
        $imagen = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'full');
        $ruta_imagen = ($imagen[0] != null) ? $imagen[0] : wp_upload_dir('2019/01')['url'] . '/logo-attachment.png';
      ?>
      <img class="card-img-top" src="<?php echo esc_url($ruta_imagen) ?>" alt="Imagen de noticia">
    </div>
    </a>
    <div class="card-body <?php echo ($attachment_audio_url == null) ? 'no-audio-attached': 'audio-attached' ?>">
      <a class="post-link" href="<?php echo esc_url(get_post_permalink($post_id))?>">
        <h5 class="card-title"><?php echo get_the_title($post_id) ?></h5>
        <p class="card-text"><?php echo format_excerpt( get_the_excerpt($post_id), 200 )?></p>
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
