<?php

// template ： お知らせのサイドバー

require_once "class/TtEvent.php";

?>

<nav class="nav_category side_category_list">
<h3 class="to_parent"><a href="/info/topics/" class="arrow">お知らせ</a></h3>
<?php
$categArgs = array(
  'pad_counts'	=>	true,
  'orderby'		=>	'order',
  'hierarchical'	=>	true,
  'hide_empty'	=>	true
);
$categTerms = get_terms( 'category', $categArgs );
foreach($categTerms as $categ){
  $categ_slug		= $categ->slug;
  $categ_name 	= $categ->name;
  $categ_parent = $categ->parent;
  $catg_count 	= $categ->count;
  if($categ_slug == 'all'){
    if($post_type != 'event' && !is_page('event_calendar')){
      $categ_name = '総合案内';
    }else{
      $categ_name = '合同開催';
    }
  }


  // お知らせ関連
  // --------------------------------------------------------------------------------
  if($post_type == 'post' || is_page('info')){
    $single_cat_slug = '';
    //詳細ページ
    if(is_category()){
      $thispage_cat = get_category( $cat );
      $single_cat_slug = $thispage_cat->slug;
    //カテゴリ一覧
    }else if(is_single()){
      $category = get_the_category();
      $single_cat_slug = $category[0]->category_nicename;
    }
    if($categ_slug == $single_cat_slug){
      echo '<dl class="nav_category_show nav_'.$categ_slug.'">'."\n";
    }else{
      echo '<dl class="nav_'.$categ_slug.'">'."\n";
    }

    ?>
    <dt class="arrow"><?php echo $categ_name;?></dt>
    <dd>
    <ul>
    <?php
      $post_args = array(
        'category_name' => $categ_slug,
        'post_type' => 'post',
        'posts_per_page' => -1
      );
      $side_post_obj = get_posts($post_args);
      foreach($side_post_obj as $side_post){
        $side_post_id = $side_post->ID; // ID
        $permalink = get_permalink( $side_post_id );  // パーマリンク
        $url = get_field( 'url', $side_post_id ); // 別URL
        if( $url ) $permalink = $url;
        echo '<li';
        if( $page_url == $permalink ){
          echo ' class="nav_category_current"';
        }
        echo '>';
        echo '<a href="'.$permalink.'" class="arrow_simple">'."\n";
        echo get_the_date('Y年n月j日',$side_post->ID).'</a></li>'."\n";
      }
      if(empty($side_post_obj)){
        echo '<li>お知らせはありません。</li>'."\n";
      }
    }
    ?>
    </ul>
    </dd>
  </dl>
  <?php
}?>

</nav>
