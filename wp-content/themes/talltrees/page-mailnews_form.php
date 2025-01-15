<?php
/**
Template Name: メルマガ登録フォーム モーダル
*/

get_header();
?>
<div id="mailnews_form" style="width:800px;">
<div id="green">
<div class="right_column no_float">
<?php

while ( have_posts() ) : the_post();
  ?>
  <h2><?php echo get_the_title();?></h2>
  <?php
  echo '<div class="profile">'."\n";
  the_content();
  echo '</div>'."\n";
// End the loop.
endwhile;

?>
</div>
</div>
</div><!-- /#mailnews_form -->
<?php
get_footer();
