<?php

$theme_path 	= get_stylesheet_directory_uri(); //テーマパス
$blog_path		= get_bloginfo("url"); //ブログURL
if(get_post_type_object(get_post_type())){
  $post_obj   = get_post_type_object(get_post_type());
  $post_type  = $post_obj->name; //ポストタイプ
  $post_type_label = $post_obj->label; //ポストタイプ名
}else if(is_archive('event')){
  $post_type  = 'event'; //ポストタイプ
}
$page_url     = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  // 現在のページのURL
$cat_all      = '総合案内'; // allが選択された場合はのカテゴリ名

$index_page_ID = get_page_by_path("home")->ID;

if(is_front_page()){ ?>
<div class="sideHallInfo">
<?php
// 開館情報・今月の休館日
get_template_part( 'block-hallinfo', get_post_format() );
?>
</div>

<?php
// イベント・インフォメーション
$j_args = array(
  'orderby' => 'modified',//'title',
  'order' => 'DESC',
  'post_type' => 'journal',
  'posts_per_page' => 1
);
$journalPosts = get_posts($j_args);
if(!empty($journalPosts)){
?>
  <div class="side_block journalArea clearfix">
    <?php
    foreach($journalPosts as $journalPost){
      $journalID = $journalPost->ID;
      $j_thumb = get_field('thumb', $journalID)['url'];
      $j_title = get_the_title($journalID);

      //	発行年
      $issue_args = array('orderby' => 'order');
      $issue_terms = wp_get_post_terms($journalID, 'issue_year', $issue_args);
      foreach($issue_terms as $issue_term){
        $issue_slug = $issue_term->slug;
        $issue_name = $issue_term->name;
      }
    }
    ?>

    <div class="thumb"><a href="/journal/"><img src="<?php echo $j_thumb;?>" alt="<?php echo $j_title;?>"></a></div>
    <div class="detail">
      <h2><span><?php echo $issue_name .'年'. $j_title;?></span><a href="/journal/"><!--<span class="journalHallName">○○○　</span>-->かんぶんニュース</a></h2>
      <ul>
        <li><a href="/journal/#latest" class="arrow">最新号</a></li>
        <li><a href="/journal/#backnumber" class="arrow">バックナンバー</a></li>
      </ul>
    </div>
  </div><!-- /.side_block -->
<?php
}

// カルチャークラブ
}else if(is_page('culture')){
  ?>
  <aside><?php
  include('content-sidebar_culture.php');
  ?>
  </aside><?php

// その他固定ページ
}else if(is_page()){
  $topLevelPage_id = get_most_parent_page($post->ID)->ID;
  $topLevelPage_slug = get_most_parent_page($post->ID)->post_name;
  $topLevelPage_title = get_most_parent_page($post->ID)->post_title;

  // 親ページがある場合
  if($topLevelPage_slug == 'about' || $topLevelPage_slug == 'guide'){
  ?>
  <nav class="nav_category side_category_list event_year_list">
  <h3 class="to_parent <?php echo 'btn_'.$topLevelPage_slug;?>">
  <a href="/<?php echo $topLevelPage_slug;?>/" class="arrow"><?php echo $topLevelPage_title;?></a>
  </h3>
    <ul class="latestEvents">
      <?php
      $pages_args = array(
				'post_type' => 'page',
				'posts_per_page' => -1,
        'post_parent' => $topLevelPage_id
			);
			$childPages = get_posts($pages_args);
			foreach($childPages as $childPage){
        $childPageLink = get_permalink($childPage->ID);
      ?>
      <li <?php if($page_url == $childPageLink) echo 'class="nav_category_current"';?>>
        <a href="<?php echo get_permalink($childPage->ID);?>" class="arrow"><?php echo $childPage->post_title;?></a>
      </li>
      <?php
			}
      ?>
    </ul>
  </nav>
  <?php

  // 親ページなし
  }else{
  ?>
  <nav class="nav_btn side_category_list event_year_list">
    <div class="to_parent"><a href="/event_calendar/" class="arrow">イベントカレンダー</a></div>
  </nav>
  <nav class="nav_btn side_category_list event_year_list">
    <div class="to_parent btn_event"><a href="/event/" class="arrow">公演・イベント情報</a></div>
  </nav>
  <?php
  }
}
?>

<?php
// バナー
get_template_part( 'content', 'sidebanner' );
get_template_part( 'block-series_reserve', get_post_format() );
?>
