<?php


function format_excerpt($excerpt, $limit = 100){
  $extract = substr($excerpt, 0, $limit);
  $extract .= '...';
  return $extract;
}

function excerpt_length($lenght){
  return $length + 3;
}



function skirmisher_attachment_img($post_id){
	 $imagen = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'full');
     return ($imagen[0] != null) ? $imagen[0] : wp_upload_dir('2019/01')['url'] . '/logo-attachment.png';
}

?>
