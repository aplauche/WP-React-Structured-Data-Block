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
        <?php if(
          array_key_exists('start', $times) &&
          array_key_exists('end', $times) &&
          $times["start"] !== "" &&
          $times["end"] !== ""
          ) :
        ?>
          <div>
            <div><?php echo date('g:i a', strtotime($times["start"]))  ?></div> 
            <div>-</div> 
            <div><?php echo date('g:i a', strtotime($times["end"])) ?></div>
          </div>
        <?php else : ?>
          <p> - - </p>
        <?php endif; ?> 
      </div>
    <?php endforeach; ?>
  </div>

  <?php return ob_get_clean();

}