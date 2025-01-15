<?php
// カテゴリタブ
$no_posts = false;
$is_posts_args = array('post_type'=>'post','post_status'=>'publish');
$is_posts_array = get_posts($is_posts_args);
if(empty($is_posts_array)){
  $no_posts = true;
}
$categArgs = array(
  'pad_counts'	=>	true,
  'orderby'		=>	'order',
  'get'			=>	'all',
  'hierarchical'	=>	true,
  'hide_empty'	=>	true
);
$categTerms = get_terms( 'category', $categArgs );

//詳細ページのカテゴリを取得
$single_cat_slug = '';
if(is_single()){
  $category = get_the_category();
	$single_cat_slug = $category[0]->category_nicename;
}

?>
<ul class="clearfix main_tabs tab_count_<?php echo count($categTerms)+1;?> newsTabs">
<!--<li>
  <a href="/info/"<?php echo (is_page('info')) ? ' class="current"' : '';?>><span>すべて</span></a>
</li>--><?php

// if(!$no_posts){
  foreach ($categTerms as $categTerm) {
    $tab_slug = $categTerm->slug;
    $tab_name = $categTerm->name;
    if($tab_slug == 'all'){
      $tab_name = '総合案内';
    }
    // if($tab_slug != 'all'){
    ?>
    <li>
      <a href="/info/<?php echo $tab_slug;?>/"<?php
        echo (is_category($tab_slug) || $tab_slug == $single_cat_slug) ? ' class="current"' : '';
      ?>>
      <span><?php echo $tab_name;?></span>
      </a>
    </li>
    <?php
    // }
  }
// }

?>
</ul>
