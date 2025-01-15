<?php

// 各館固定ページ以外のサイドバー

$sidebar_title = '';
$no_posts = false;
$theme_path = get_stylesheet_directory_uri(); //テーマパス
$blog_path  = get_bloginfo("url"); //ブログURL
$page_url   = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  // 現在のページのURL

if(get_post_type_object(get_post_type())){
  $post_obj   = get_post_type_object(get_post_type());
  $post_type  = $post_obj->name; //ポストタイプ
  $post_type_label = $post_obj->label; //ポストタイプ名

}else if(is_archive('event')){
  $no_posts = true;
  if($post_type != 'post'){
    $post_type  = 'event'; //ポストタイプ
    $post_type_label = '公演･イベント情報'; //ポストタイプ名
  }

}else if(is_category()){
  $no_posts = true;
  $post_type  = 'post'; //ポストタイプ
}

$categ_slug = ''; // カテゴリとしての施設スラッグ
if($post_type == 'post'){
  $sidebar_title = 'お知らせ';

}else if(!is_page()){
  $sidebar_title = $post_type_label;

}else{
  $sidebar_title = $post->post_title;
}
?>
<aside>
<?php
// イベントカレンダー
if(is_page('event_calendar')){
  include('content-sidebar_calendar.php');

// 公演・イベント
}else if($post_type == 'event'){
  include('content-sidebar_event.php');

// カルチャー
}else if($post_type == 'culture'){
  include('content-sidebar_culture.php');

}else if($post_type == 'series'){
  ?>
  <nav class="nav_btn side_category_list event_year_list">
    <div class="to_parent"><a href="/event_calendar/" class="arrow">イベントカレンダー</a></div>
  </nav>
  <nav class="nav_btn side_category_list event_year_list">
    <div class="to_parent btn_event"><a href="/event/" class="arrow">公演・イベント情報</a></div>
  </nav>
<?php

// お知らせ
}else{
  include('content-sidebar_info.php');

}

// バナー
get_template_part( 'content', 'sidebanner' );
get_template_part( 'block-series_reserve', get_post_format() );

?>
</aside>
