<?php

function fsdhh_happy_hour_render($atts, $content, $block){

  // Get the post ID from block context - this is provided by useContext within block.json
  $postID = $block->context['postId'];

  // Get taxonomy terms
  $postTerms = get_the_terms( $postID, 'neighborhood' );
  // Force into an array
  $postTerms = is_array($postTerms) ? $postTerms : [];

  // Get our custom meta of happy hour time slots
  $happy_hour_times = get_post_meta( $postID, 'happy_hour_times', true );
  // Again coerce into an array
  $happy_hour_times = is_array($happy_hour_times) ? $happy_hour_times : [];


  ob_start();?>

  <div class="happy-hour">
    <?php foreach($happy_hour_times as $day => $times): ?>
      <div>
        <p><strong><?php echo $day ?></strong></p>
        <p><span><?php echo $times["start"] ?></span> - <span><?php echo $times["end"] ?></span></p>
      </div>
    <?php endforeach; ?>
  </div>

  <?php return ob_get_clean();

}