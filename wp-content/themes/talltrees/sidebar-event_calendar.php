<?php

// 各館固定ページ以外のサイドバー

$sidebar_title = '';
$no_posts = false;
$theme_path = get_stylesheet_directory_uri(); //テーマパス
$blog_path  = get_bloginfo("url"); //ブログURL
$page_url   = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  // 現在のページのURL

$current_year = get_query_var('current_year');
$current_month = get_query_var('current_month');
$sidebar_title = get_query_var('sidebar_title' );
$side_ttEvents = get_query_var('side_ttEvents');
$hall_slug = get_query_var('hall_slug');
$categ_slug = ''; // カテゴリとしての施設スラッグ
?>
<aside>
<?php

// URLについたパラメータ
$param_year = filter_input( INPUT_GET, 'year_select' );
if(!$param_year){
  $param_year = date_i18n('Y');
}
?>
<nav class="nav_category side_category_list event_year_list">
<h3 class="to_parent">
  <a href="/event_calendar/" class="arrow">イベントカレンダー</a>
</h3>
<?php

  $side_total_event_count = 0;

  // $side_year_array = array();  // 年（3年先まで取得）
  // $past_year_array = array();  // 年（3年先〜4年前まで取得）

  $past_year_array = array(); // 年（2年先まで取得）
  for($ahead = 0; $ahead<=2; $ahead++){
    $past_year_array[] = date_i18n('Y') + $ahead;
  }

  // 日付でソート
  // ------------
  $nav_array = array(); // 重複しないように確認する配列
  $nowMonth = new DateTime( date_i18n('Y-n')); //今月
  foreach($past_year_array as $past_year){  // 2年前まで取得
  ?>
  <dl class="event_list_<?php echo $past_year;?> <?php
  echo ($param_year == $past_year) ? 'nav_category_show' : '';
  ?>">
    <dt class="arrow"><?php echo $past_year;?>年</dt>
    <dd>
    <ul>
    <?php
    $side_event_count = 0;
    for($target_month = 1; $target_month <= 12; $target_month++){
      foreach($side_ttEvents as $key => $side_ttEvent){
        $side_targetDateTime = new DateTime( $past_year . "-" . $target_month );
        if($side_ttEvent->isExistInDate_side($side_targetDateTime, $nowMonth)){
          // 配列に入ってたらスルーする
          if( array_search($past_year.'-'.$target_month, $nav_array) === false ){
            $nav_array[] = $past_year.'-'.$target_month;
          }else{
            continue;
          }
          $side_event_count++;
          $side_total_event_count = $side_total_event_count + $side_event_count;  //イベント数をカウント
          if($past_year == $current_year && $target_month == $current_month && $categ_slug == $hall_slug){
            echo '<li class="nav_category_current">';
          }else{
            echo '<li>';
          }
          echo '<a href="/event_calendar/';
          echo '?year_select='.$past_year.'&month_select='.$target_month.'" class="arrow_simple">';
          echo $target_month.'月';
          echo '</a></li>'."\n";
        }
      }
    }
    // 投稿がないとき
    // --------------
    if(!$side_event_count){
    ?>
      <style type="text/css">.event_list_<?php echo $past_year;?>{display: none;}</style>
    <?php
    }
    ?>
    </ul>
    </dd>
  </dl>
  <?php
  }
?>
</nav>

<nav class="nav_btn side_category_list event_year_list">
  <div class="to_parent btn_event"><a href="/event/" class="arrow">公演･イベント情報</a></div>
</nav>
<?php

// バナー
get_template_part( 'content', 'sidebanner' );
get_template_part( 'block-series_reserve', get_post_format() );

?>
</aside>
