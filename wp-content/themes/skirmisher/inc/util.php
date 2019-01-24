<?php


function format_excerpt($excerpt, $limit = 100){
  $extract = substr($excerpt, 0, $limit);
  $extract .= '...';
  return $extract;
}

function excerpt_length($lenght){
  return $length + 3;
}

function the_skirmisher_tags($category = null){
  $posttags = get_tags();

  if ($posttags) {


  ?>

    <ul class="skirmisher-nav-links">
      <?php foreach($posttags as $tag) { ?>
         <li>
           <a href="<?php echo $category ? get_tag_link($tag->term_id). '?category='.$category : get_tag_link($tag->term_id) ?>" title="<?php echo $tag->name ?>"><?php echo $tag->name ?></a>
         </li>
       <?php } ?>
   </ul>
   <?php }
}

?>
