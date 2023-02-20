<?php

function fsdhh_happy_hour_render($atts, $content, $block){


  ob_start();?>

  <div class="happy-hour">
    Happy hour post block here
  </div>

  <?php return ob_get_clean();

}