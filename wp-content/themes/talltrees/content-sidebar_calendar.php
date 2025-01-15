<?php

// template：イベントカレンダーのサイドバー


$current_year = get_query_var('current_year');
$current_month = get_query_var('current_month');
$sidebar_title = get_query_var('sidebar_title' );
$hall_slug = get_query_var('hall_slug');
$categ_slug = get_query_var('categ_slug');

// URLについたパラメータ
$param_year = filter_input( INPUT_GET, 'year_select' );
if(!$param_year){
  $param_year = date_i18n('Y');
}
?>
<nav class="nav_category side_category_list event_year_list">
<h3 class="to_parent">
  <!-- <a href="/event_calendar/" class="arrow"><?php echo $sidebar_title;?></a> -->
  <a href="/event_calendar/" class="arrow">イベントカレンダー</a>
</h3>
<?php

  $side_total_event_count = 0;
  $side_no_event = false;

  // 年・月
  $side_month = '';	//月

  // $side_year_array = array();	// 年（3年先まで取得）
  // $past_year_array = array();	// 年（3年先〜4年前まで取得）

  $past_year_array = array(); // 年（2年先まで取得）
  for($ahead = 0; $ahead<=2; $ahead++){
    $past_year_array[] = date_i18n('Y') + $ahead;
  }

  // for($past = 0; $past<=2; $past++){
  //   $past_year_array[] = date_i18n('Y') - $past;
  // }
  // var_dump($past_year_array);

  if(isset($_GET['month_select'])){
  	$side_month = urlencode($_GET['month_select']);	//パラメータの月を優先
  }

  $query = array(
		'post_type'=>'event',
		'post_status'=>'publish',
		'posts_per_page'=>-1,
	);

  // いったん全ての投稿を取得
	// -----------------------
	$side_ttEvents = array();
  $side_schedules_array = array();
	$wp_query = new WP_Query($query);
	query_posts($wp_query->query);
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
    // $side_ttEvents[] = new TtEvent($post);

    if( function_exists( 'postexpirator_shortcode' )){

      $expire = do_shortcode('[postexpirator]'); //公開期限日を取得
      $expire_month = tt_format_date($expire, 'Y-m', 'Y-m-d H:i:s', false); //フォーマットを修正
      $now_month = date_i18n('Y-m'); //現在の月を取得

      // 公開期限が設定されていて、現在の月より大きかったら表示しない
      if($expire_month){
        if(strtotime($now_month) <= strtotime($expire_month)){
          $side_ttEvents[] = new TtEvent($post);
          $schedules = get_field('schedule');
        }
      }else{
        $side_ttEvents[] = new TtEvent($post);
        $schedules = get_field('schedule');
      }

    }

    // $side_ttEvents[] = new TtEvent($post);
    // $schedules = get_field('schedule');
    // var_dump($schedules);
    if(!empty($schedules)){
    foreach($schedules as $key => $schedule_date){
      if(reset($schedules) == $schedule_date){
        // echo strtotime($schedule_date['date']).'<br>';
        $side_schedules_array[] =  tt_format_date($schedule_date['date'], 'Ym', 'Ymd', false).'<br>';
      }
    }
    }
		endwhile;
	else:
		$side_no_event = true;	//イベントなしのフラグ
	endif;
  wp_reset_query();

	// 日付でソート
	// ------------
  $nav_array = array(); // 重複しないように確認する配列
  $nowMonth = new DateTime( date_i18n('Y-n')); //今月
  foreach($past_year_array as $past_year){  // 5年前まで取得
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
    			$side_total_event_count = $side_total_event_count + $side_event_count;	//イベント数をカウント
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
  <div class="to_parent btn_event"><a href="/event/" class="arrow">公演・イベント情報</a></div>
</nav>
