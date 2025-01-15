<?php

// template ： 公演・イベントのサイドバー

$theme_path 	= get_stylesheet_directory_uri(); //テーマパス
$blog_path		= get_bloginfo("url"); //ブログURL
$page_url     = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  // 現在のページのURL

?>

<nav class="nav_category side_category_list event_year_list">
<h3 class="to_parent btn_culture">
  <a href="/culture/" class="arrow">教養講座</a>
</h3>

<ul class="latestEvents">
<?php

$args = array(
  'post_type' => 'culture',
  'posts_per_page' => -1
);
$culturePosts = get_posts($args);
foreach ($culturePosts as $culturePost) {
  $cultureID = $culturePost->ID;
  $title = get_the_title($cultureID);
  $brTitle = get_field('event_title',$cultureID);
  if($brTitle) $title = $title;
  $url = get_permalink($cultureID);
  echo '<li';
  if($page_url == get_permalink($cultureID)){
    echo ' class="nav_category_current"';
  }
  echo '>';
  ?>
  <a href="<?php echo $url;?>" class="arrow"><?php echo $title;?></a></li>
  <?php
}
?>
</ul>
</nav>
