<?php
/**
Template Name: アーティスト詳細モーダル
*/

get_header();
?>
<div id="artist" style="width:800px;">
<div id="green">
<div class="right_column no_float">
<?php

while ( have_posts() ) : the_post();
  echo '<h1 class="short">'.get_the_title().'</h1>'."\n";
  echo '<div class="profile">'."\n";
  the_content();
  echo '</div>'."\n";
// End the loop.
endwhile;

?>
</div>
</div>
</div><!-- / artist -->
<?php
get_footer();
