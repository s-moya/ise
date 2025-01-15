<?php

// パンくず・ページタイトル

$theme_path = get_stylesheet_directory_uri(); //テーマパス
$blog_path  = get_bloginfo("url"); //ブログURL
$post_obj   = get_post_type_object(get_post_type());
if(get_post_type_object(get_post_type())){
  $post_type  = $post_obj->name; //ポストタイプ
  $post_type_label = $post_obj->label; //ポストタイプ名
}else if(is_category()){
  $post_type  = 'post'; //ポストタイプ
}else if(is_archive('event')){
  $post_type  = 'event'; //ポストタイプ
  $post_type_label = '公演･イベント情報';
}else{
  $post_type_label = '公演・イベント情報が見つかりませんでした';
}
$page_url   = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  // 現在のページのURL

$post_genre_slug = '';  // ジャンルスラッグ
$breadcrumb_str = ''; // パンくず文字列

//施設パラメータ
$hall_slug = '';
if(isset($_GET['hall'])) {
  $hall_slug = $_GET['hall'];
  $hall_args = array(
    'slug'=>$hall_slug,
    'hide_empty'=>false
  );
  $param_hall_obj = get_terms('category',$hall_args)[0];
  $param_hall_name = $param_hall_obj->name;
  if($hall_slug == 'all'){
    $param_hall_name = '合同開催';
  }
  $param_hall_slug = $param_hall_obj->slug;
}

//会場パラメータ
$place_array = '';
$place = '';
$param_place_name = '';
$is_place_breadcrumb = false;
if(isset($_GET['place_select'])) {
  $param_place_slug = $_GET['place_select'];
  $place_args = array(
    'post_type'=>'event','post_status'=>'publish','posts_per_page'=>'1'
  );
  $places = get_posts($place_args);
  foreach($places as $place){
    $place_obj = get_field_object('place', $place->ID);
    if($place_obj){
      $place_array = $place_obj['choices'];
    }
  }
  foreach ($place_array as $key => $place) {
    if($key == $param_place_slug){
      $param_place_name = $place;
    }
  }
}

 //ジャンルパラメータ
$genre_slug = '';
if(isset($_GET['genre'])) {
  $genre_slug = $_GET['genre'];
  $genre_args = array(
    'slug'=>$genre_slug,
    'hide_empty'=>false
  );
  $param_genre_obj = get_terms('genre',$genre_args)[0];
  $param_genre_name = $param_genre_obj->name;
  $param_genre_slug = $param_genre_obj->slug;
}

//月パラメータ
$month_num = '';
if(isset($_GET['month_select'])) {
  $month_num = $_GET['month_select'];
}


// ジャンル一覧
// ------------------------
if(is_tax()){
  $taxonomy = $wp_query->get_queried_object();
  $taxonomy_name = esc_html($taxonomy->name);;
  $post_genre_slug = $taxonomy->slug;
  $breadcrumb_str = $taxonomy_name;

  if($hall_slug) {
  	if($hall_slug == 'all'){
  		$param_hall_name = '合同開催';
  	}
    $breadcrumb_str = $param_hall_name.'：'.$taxonomy_name;
  }

// 公演・イベントTOP
// ------------------------
}else if(is_singular('event')){
  // ジャンル
  $genre_name = '';
  $cat_args = array('orderby' => 'order');
  $genre_terms = wp_get_post_terms(get_the_ID(), 'genre', $cat_args);
  foreach($genre_terms as $genre_term){
  	if($genre_term === reset($genre_terms)){
  		$post_genre_slug = $genre_term->slug;
  		$post_genre_name = $genre_term->name;
  	}
  }
}

?>
<div class="topic_path contentWrapper">
<ul>
<li><a href="<?php echo $blog_path;?>">TOPページ</a>
</li><li><?php
/*
 *  ------------------------------------------
 *  パンくず出力
 *  ------------------------------------------
*/

// 404
// ------------------------
if(is_404()){
  echo 'ページが見つかりませんでした';

// 検索
// ------------------------
}else if(is_search()){
  echo '検索結果';

// イベントカレンダー
// ------------------------
}else if(is_page('event_calendar')){
  if($genre_slug || $month_num){
    echo '<a href="/event_calendar/">'.$post->post_title.'</a>'."\n";
    if($month_num){
      if($param_place_name){
        echo '</li><li>';
        echo '<a href="/event_calendar/?place_select='.$param_place_slug.'">'.$param_place_name.'</a>'."\n";
      }
      echo '</li><li>'.$month_num.'月の催し物'."\n";
    }else{
      if($param_place_name){
        echo '</li><li>'.$param_place_name."\n";
      }
    }
  }else{
    echo $post->post_title;
  }


// 固定ページ
// ------------------------
}else if(is_page()){

  if(is_parent_slug()){
    $most_par_post = get_most_parent_page();
    $page_slug = $most_par_post->post_name;
    $page_title = $most_par_post->post_title;
    // echo '<a href="/'.$page_slug.'/">'.$page_title.'</a></li><li>'."\n";
    echo $page_title.'</li><li>'."\n";
  }
  echo $post->post_title;

// イベント関連
// ------------------------
}else if( $post_type == 'event'){
  if(is_singular('event')){
    echo '<a href="/event/">'.$post_type_label.'</a>'."\n";
    // if($post_genre_slug){
    // echo '</li><li><a href="/event/genre/'.$post_genre_slug.'/">'.$post_genre_name.'</a>'."\n";
    // }
    echo '</li><li>'.str_replace('<br>','',$post->post_title);
  }else if(is_tax()){
    echo '<a href="/event/">'.$post_type_label.'</a>'."\n";
    echo '</li><li>'.$breadcrumb_str."\n";
  }else{
    echo $post_type_label;
  }

// シリーズ企画
// ------------------------
}else if( $post_type == 'series'){
  echo strip_tags(get_field('series_name', $post->ID));

// カルチャー
// ------------------------
}else if( $post_type == 'culture'){
  if(is_singular('culture')){
    echo '<a href="/culture/">'.$post_type_label.'</a>'."\n";
    echo '</li><li>'.str_replace('<br>','',$post->post_title);
  }else{
    echo $post_type_label;
  }

// お知らせ関連
// ------------------------
}else if(is_category() || is_singular('post')){
  echo '<a href="/info/">お知らせ</a>'."\n";
  // お知らせ詳細
  $cat_all_name = '総合案内';
  if(is_singular('post')){
    $cat_args = array('orderby' => 'order');
    $cat_tags = '';
    $cat_terms = wp_get_post_terms(get_the_ID(), 'category', $cat_args);
    foreach($cat_terms as $cat_term){
      $cat_slug = $cat_term->slug;
      $cat_name = $cat_term->name;
      if($cat_slug == 'all'){
        $cat_name = $cat_all_name;
      }
      if($cat_term === end($cat_terms)){
        $cat_tags .= '<a href="/info/'.$cat_slug.'/">'.$cat_name.'</a>';
      }else{
        $cat_tags .= '<a href="/info/'.$cat_slug.'/">'.$cat_name.'</a>／';
      }
    }
    echo '</li><li>'.$cat_tags."\n";
    echo '</li><li>'.strip_tags(get_the_title())."\n";

  // お知らせ一覧
  }else{
    $cat_info = get_category( $cat );
    $cat_name = $cat_info->name;
    $cat_slug = $cat_info->slug;
    if($cat_slug == 'all') $cat_name = $cat_all_name;
    echo '</li><li>'.$cat_name."\n";
  }

// その他
// ------------------------
}else{
  echo get_the_title();
}
?></li>
</ul>
</div><!-- /.topic_path -->
