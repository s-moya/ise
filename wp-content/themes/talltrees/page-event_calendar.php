<?php
/**
Template Name: イベントカレンダー
*/

require_once "class/TtEvent.php";

get_header();
// get_template_part( 'content-topicpath_title', get_post_format() );

$hall_slug = '';	// 開催館slug
$selected_place = '';	//	会場
$post_genre_slug = '';	// ジャンルslug
$param_hall_name = '';	// 開催館パラメータ
$param_genre_name = '';	// ジャンルパラメータ
$cat_all = '合同開催'; // allが選択された場合はのカテゴリ名

$theme_path = get_stylesheet_directory_uri(); //テーマパス
$blog_path  = get_bloginfo("url"); //ブログURL
$post_obj   = get_post_type_object(get_post_type());
$post_type  = $post_obj->name; //ポストタイプ
$post_type_label = $post_obj->label; //ポストタイプ名
$page_url   = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  // 現在のページのURL

if(is_tax()){
	$taxonomy = $wp_query->get_queried_object();
	$taxonomy_name = esc_html($taxonomy->name);;
	$post_genre_slug = $taxonomy->slug;
}

// hallパラメータがついてるか確認
if(isset($_GET['hall'])) {
  $hall_slug = $_GET['hall'];
	$hall_args = array(
		'slug'=>$hall_slug,
		'hide_empty'=>false
	);
	$param_hall_obj = get_terms('category',$hall_args)[0];
	$param_hall_name = $param_hall_obj->name;
	if($hall_slug == 'all'){
		$param_hall_name = $cat_all;
	}
}

// genreパラメータがついてるか確認
if(isset($_GET['genre'])) {
  $param_genre_slug = $_GET['genre'];
	$param_genre_args = array(
		'slug'=>$param_genre_slug,
		'hide_empty'=>false
	);
	$param_genre_obj = get_terms('genre',$param_genre_args)[0];
	$param_genre_name = $param_genre_obj->name;
	$post_genre_slug = $param_genre_obj->slug;
}

// どの会場タブがチェックされているか
$check = '';

// 最左のタブのkeyを入れる
$first_tab = '';

// query_postsの中で「イベントがありません」をすでに表示しているか
$total_event_count = 0;
$no_event = false;

$year_array = array();	// 年（3年先まで取得）
for($ahead = 0; $ahead<=4; $ahead++){
	$year_array[] = date_i18n('Y') + $ahead;
}
$this_year 	= date_i18n('Y');	// 現在の年
$year 			= $year_array[0];
if(isset($_GET['year_select'])){
	$year = urlencode($_GET['year_select']);	//パラメータの月を優先
}
$this_month = date_i18n('n');	// 現在の月
$month 			= date_i18n('n');	// 月
if(isset($_GET['month_select'])){
	$month = urlencode($_GET['month_select']);	//パラメータの月を優先
}

global $wp_query;
$query = $wp_query->query;

?>

	<div class="right_column">
	<header class="contentsHeader">
		<h1>イベントカレンダー</h1>
	</header><!-- /.contentsHeader -->
	<div class="eventLinkTabs">
		<ul class="clearfix">
			<li><a href="/event_calendar/" class="current"><span>イベントカレンダー</span></a></li>
			<li><a href="/event/"><span>公演･イベント情報</span></a></li>
		</ul>
	</div>
	<?php

	// イベントカレンダーTOPは会場タブを取得
	// 施設名が合同開催でなければ「会場」カスタムフィールドを取得 --------
	$tab_args = array(
		'category_name'=>$hall_slug,
		'post_type'=>'event',
		'post_status'=>'publish',
		'posts_per_page'=>'1'
	);
	$place_tabs = get_posts($tab_args);
	foreach($place_tabs as $place_tab){
		$tabs_value_obj = get_field_object('place', $place_tab->ID);
		if($tabs_value_obj){
			$tabs_value = $tabs_value_obj['choices'];
		}
	}

	// 会場タブ
	// -----------------------------------------
	if(!empty($tabs_value)){
		$count_tab = count($tabs_value);
		echo '<ul class="clearfix calendar_tab main_tabs tab_count_'.$count_tab.'">'."\n";
		// どのタブがチェックされているか
		if( isset($_GET['place_select']) ) $check = urlencode($_GET['place_select']);
		// タブリストを出力
		foreach ($tabs_value as $key => $value) {
			// 最初のタブのkeyを取得
			echo '<li>';
			echo '<a href="'.$page_url.'" data-place="'.$key.'" id="target-'.$key.'" class="place_select';
			if(reset($tabs_value) == $value){
				$first_tab = $key;
				if(!isset($_GET['place_select'])) {
					echo ' current';
				}
			}
			if($check && $check == $key){
				echo ' current';
				$selected_place = $value;
			}
			echo '">'.$value.'</a></li>'."\n";
		}
		echo '</ul>'."\n";
	}

	$next_month = $month+1;
	$prev_month = $month-1;
	$next_year = $year;
	$prev_year = $year;
	if( $month == 1 ){
		$prev_month = 12;
		$prev_year = $year - 1;
	}else if( $month == 12 ){
		$next_month = 1;
		$next_year = $year + 1;
	}
	$no_prev = false;
	if($prev_month < $this_month && $prev_year == $this_year){
		$no_prev = true;
	}
	// タブ
	?>
	<div class="calendarMetaArea">
	<div class="nav_contents clearfix">
		<span class="next">
		<a href="" class="month_select" data-year="<?php echo $next_year.'" data-month="'.$next_month;?>">翌月</a></span><?php
		if(!$no_prev){?>
		<span class="prev">
		<a href="" class="month_select" data-year="<?php echo $prev_year.'" data-month="'.$prev_month;?>">前月</a></span>
		<?php
		}
		?>
	</div>
	<h2 title="<?php echo $year.'年'.$month.'月';?>"><font class="spText"><?php echo $year.'年';?></font><?php echo $month;?>月の催し物</h2>
	</div>
	<table class="event_list_table">
	<?php

	// イベントリスト
	// -----------------------------------------
	$first_day_formated = tt_format_date($year.'/'.$month.'/'.'01', 'Ymd', 'Y/n/d', false);
	$expire_query_array = get_expire_array($first_day_formated);
	$paged 	= get_query_var('paged');
	$query = array(
		'post_type'=>'event',
		'post_status'=>'publish',
		'posts_per_page'=>-1,
		'paged'=>$paged,
		// 'orderby'=>'order'
		// 'order'=> 'DESC'
	);

	// 各館：最左のタブ（会場）で絞込
	// -------------------
	if($first_tab){
		$query = array_merge(
			$query,
			array(
				'meta_query' => array(
					$expire_query_array,
					'relation' => 'AND',
					array(
						'key' => 'place',
						'value' => $first_tab,
						'compare' => 'LIKE',
					)
				)
			)
		);
	}

	// 会場で絞りこみ
	// ------------
	if(isset($_GET['place_select'])){
		$meta_value = urlencode($_GET['place_select']);
		$meta_key = 'place';
		if (strlen($meta_value) > 1) {
			$query = array_merge(
				$query,
				array(
					'meta_query' => array(
						$expire_query_array,
						'relation' => 'AND',
						array(
							'key' => $meta_key,
							'value' => $meta_value,
							'compare' => 'LIKE',
						)
					)
				)
			);
		}
	}

	// いったん全ての投稿を取得
	// -----------------------------------------
	$ttEvents = array();
	$wp_query = new WP_Query($query);
	query_posts($wp_query->query);
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
		if( function_exists( 'postexpirator_shortcode' )){
			$expire = do_shortcode('[postexpirator]'); //公開期限日を取得
			$expire_month = tt_format_date($expire, 'Y-m', 'Y-m-d H:i:s', false); //フォーマットを修正
			$now_month = date_i18n('Y-m'); //現在の月を取得
			// 公開期限が設定されていて、現在の月より大きかったら表示しない
			if($expire_month){
				if(strtotime($now_month) <= strtotime($expire_month)){
				  $ttEvents[] = new TtEvent($post);
				}
			}else{
				$ttEvents[] = new TtEvent($post);
			}
		}
		endwhile;
	else:
		$no_event = true;	//イベントなしのフラグ
	endif;
	// -----------------------------------------

	// 日付でソート
	// -----------------------------------------
	$targetMonthDayNum = date('t', strtotime($year . "-" . $month . "-01"));
	$event_count_array = array(); // 重複しないように確認する配列

	for($day = 1; $day <= $targetMonthDayNum; $day++){
		$event_count = 0;
		$event_count_exceptContinue = 0;
		// ついたちの場合：continue:1 multi:2 single:3 の順にソート
		if($day == 1){
			usort($ttEvents, 'cmpEventFirstDay');
		// それ以外：multi:1 single:2 continue:3 の順にソート
		}else{
			usort($ttEvents, 'cmpEvent');
		}
		foreach($ttEvents as $ttEvent){
			$targetDateTime = new DateTime($year . "-" . $month . "-" . $day);
			$targetDate = $year . "-" . $month . "-" . $day;
			if($ttEvent->isExistInDate($targetDateTime)){
				$event_count++;
				$total_event_count = $total_event_count+$event_count;	//イベント数をカウント
				if($ttEvent->limit != 'continue'){
					$event_count_exceptContinue++;
				}
			}
		}

		// 1ヶ月分のイベントを、
		// 日付に該当するイベントだけに整理し配列に格納 → newTtEvents
		$newTtEvents = array();
		foreach($ttEvents as $key => $ttEvent){
			if($ttEvent->isExistInDate($targetDateTime)){
				// 配列にIDがない場合：
				if( array_search($ttEvent->getPostID(), $event_count_array) === false ){
					// 連続日程のみ、ポストIDを配列に入れる
					// 連続日程のイベントは１度だけ表示する
					if($ttEvent->limit == 'continue'){
						$event_count_array[] = $ttEvent->getPostID();
					}
					$newTtEvents[] = $ttEvent;
				}
			}
		}

		// 前後の日付から判断し、日付がかぶるものは中身（<div class="detail" />）のみ表示する
		// ただし limit == continue は除く
		$prevTtEvent = null;	//前のイベント
		$nextTtEvent = null;	//次のイベント
		foreach($newTtEvents as $key => $ttEvent){
			$targetDateTime = new DateTime($year . "-" . $month . "-" . $day);	//	カレンダーの日付
			$prevTtEvent = ($key > 0) ? $newTtEvents[$key - 1] : null;	//前のキーのイベント
			$nextTtEvent = (count($newTtEvents) - 1 > $key) ? $newTtEvents[$key + 1] : null;//次のキーのイベント
			// 前キーのイベントがある：
			if($prevTtEvent){
				// 前のイベントがsingle or multiイベントかつ同じ日の場合
				if(($ttEvent->limit == 'single' || $ttEvent->limit == 'multi') &&
				($prevTtEvent->limit == 'single' || $prevTtEvent->limit == 'multi') && $prevTtEvent->isExistInDate($targetDateTime)){
				// tr th td入れない
				// それ以外
				}else{
					// tr th td入れる
					echo $ttEvent->getOpenHtml($targetDate);
				}
			// 前キーのイベントが無い：
			}else{
				// tr th td入れる
				echo $ttEvent->getOpenHtml($targetDate);
			}

			// イベント詳細を取得
			echo $ttEvent->getHtml($targetDate, $event_count_exceptContinue);

			// 次キーのイベントがある：
			if($nextTtEvent){
				// 次がsingle or multiイベントかつ同じ日の場合
				if(
				($ttEvent->limit == 'single' || $ttEvent->limit == 'multi') &&
				($nextTtEvent->limit == 'single' || $nextTtEvent->limit == 'multi') && $nextTtEvent->isExistInDate($targetDateTime)){
				//  /td /tr 入れない
				// それ以外
				}else{
					//  /td /tr 入れる
					echo $ttEvent->getCloseHtml($targetDate);
				}
			// 次キーのイベントが無い：
			}
			else{
				echo $ttEvent->getCloseHtml($targetDate);
			}
		}

	}
	// -----------------------------------------

	// 投稿がないとき
	// -----------------------------------------
	if( $no_event || $total_event_count == 0){?>
		<tr>
		<td class="no_posts" colspan="2">
			<p><?php
			echo $year.'年'.$month.'月の';
			$search_event ='';
			$search_event_result = '';
			$search_event_result .= ($param_hall_name) ? $param_hall_name.' ' : '';
			$search_event_result .= ($selected_place) ? $selected_place.' ' : '';
			$search_event_result .= ($param_genre_name) ? $param_genre_name : '';

			if($param_hall_name || $selected_place || $param_genre_name){
				$search_event .= ' ｢'.$search_event_result.'｣ に該当する';
			}
			echo $search_event;

		?>公演・イベント情報はありません。
		</p>
		</td>
		</tr>
	<?php
	}
	// -----------------------------------------

	?>
	</table>
	<p class="notes">※主催者の希望により掲載しておりますので、掲載されない催し物もあります。主催者の都合により変更になることもあります。</p>

	<?php
	// if(function_exists('wp_pagenavi')) {
	// 	echo '<div class="pagination">';
	// 	wp_pagenavi();
	// 	echo '</div>';
	// }
	?>

	<?php wp_reset_query();	?>

	<div class="calendarNavBottom">

		<div class="calendarMetaArea">
			<div class="nav_contents clearfix">
				<span class="next">
				<a href="" class="month_select" data-year="<?php echo $next_year.'" data-month="'.$next_month;?>">翌月</a></span><?php
				if(!$no_prev){?>
				<span class="prev">
				<a href="" class="month_select" data-year="<?php echo $prev_year.'" data-month="'.$prev_month;?>">前月</a></span>
				<?php
				}
				?>
			</div>
			<h2 title="<?php echo $year.'年'.$month.'月';?>"><font class="spText"><?php echo $year.'年';?></font><?php echo $month;?>月の催し物</h2>
		</div>

		<div class="selectYearMonth clearfix">
		<?php
		// 年・月ごとのプルダウン
		// -----------------------------------------
		$current_year = $year;	// ページで表示している年
		$current_month = $month;	// ページで表示している月
	  $side_total_event_count = 0;
	  $side_no_event = false;

	  // 年・月
	  $side_month = '';	//月
	  $side_year_array = array();	//年（3年先まで取得）
	  $past_year_array = array();	//年（3年先〜4年前まで取得）
	  for($ahead = 0; $ahead<=2; $ahead++){
	    $past_year_array[] = date_i18n('Y') + $ahead;
	  }
	  // if(isset($_GET['month_select'])){
	  // 	$side_month = urlencode($_GET['month_select']);	//パラメータの月を優先
	  // }

	  $side_first_day_formated = date_i18n('Y').date_i18n('m').'01';
		// $side_expire_query_array = array(
		// 	'key' => 'schedule_%_date',
		// 	'value' => $side_first_day_formated,
		// 	'compare' => '>=',
		// );
	  $expire_query_array = get_expire_array($side_first_day_formated);
	  $query = array(
	    'post_type'=>'event',
	    'post_status'=>'publish',
	    'posts_per_page'=>-1,
	    'meta_query' => array(
	      // $side_expire_query_array,
	      $expire_query_array
	    )
	  );

	  // いったん全ての投稿を取得 -----------------------
		$side_ttEvents = array();
	  $side_schedules_array = array();
		$wp_query = new WP_Query($query);
		query_posts($wp_query->query);
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
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
			endwhile;
		else:
			$side_no_event = true;	//イベントなしのフラグ
		endif;
	  wp_reset_query();

		// 日付でソート ------------
	  $nav_array = array(); // 重複しないように確認する配列
	  $nowMonth = new DateTime( date_i18n('Y-n')); //今月
		?>
		<div class="pullDownSelect selectNavYear">
		<p class="pullDownCurrent"><a href=""><?php echo $year;?>年</a></p>
		<ul class="pullDownSchedule">
		<?php
		// 「年」-------
	  foreach($past_year_array as $past_year){ ?>
		<li class="navBtm_<?php echo $past_year;?>">
		<a href="/event_calendar/?year_select=<?php echo $past_year;?>"<?php echo ($past_year == $year) ? ' class="current"' : '' ;?>><?php echo $past_year;?>年</a>
		</li>
		<?php } ?>
		</ul>
		</div><!-- /.selectNavYear -->

		<div class="pullDownSelect selectNavMonth">
		<p class="pullDownCurrent"><a href=""><?php echo $month;?>月</a></p>
		<ul class="pullDownSchedule">
		<?php
		// 「月」-------
		foreach($past_year_array as $past_year){?>
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
	          if($past_year == $current_year && $target_month == $current_month){
	            echo '<li class="nav_category_current -year-'.$past_year.'"';
	          }else{
	            echo '<li class="-year-'.$past_year.'"';
	          }
	          if($current_year != $past_year){
	          	echo ' style="display:none;"';
	          }
	          echo '>';
	          echo '<a href="/event_calendar/';
	          echo '?year_select='.$past_year.'&month_select='.$target_month.'"';
						echo ($target_month == $month) ? ' class="current"' : '' ;
						echo '>';
	          echo $target_month.'月';
	          echo '</a></li>'."\n";
	    		}
	    	}
	    }
	  	// 投稿がないとき --------------
	    if(!$side_event_count){ ?>
	    	<style type="text/css">.navBtm_<?php echo $past_year;?>{display: none;}</style>
	    <?php } ?>
	  <?php } ?>
		</ul>
		</div><!-- /.selectNavMonth -->
		</div><!-- /.selectYearMonth -->

		<?php
		// 会場タブ
		// -----------------------------------------
		if(!empty($tabs_value)){
			$count_tab = count($tabs_value);
			echo '<ul class="clearfix calendar_tab main_tabs tab_count_'.$count_tab.'">'."\n";
			// どのタブがチェックされているか
			if( isset($_GET['place_select']) ) $check = urlencode($_GET['place_select']);
			// タブリストを出力
			foreach ($tabs_value as $key => $value) {
				// 最初のタブのkeyを取得
				echo '<li>';
				echo '<a href="'.$page_url.'" data-place="'.$key.'" id="target-'.$key.'" class="place_select';
				if(reset($tabs_value) == $value){
					$first_tab = $key;
					if(!isset($_GET['place_select'])) {
						echo ' current';
					}
				}
				if($check && $check == $key){
					echo ' current';
					$selected_place = $value;
				}
				echo '">'.$value.'</a></li>'."\n";
			}
			echo '</ul>'."\n";
		}
		?>

		<div class="eventLinkTabs">
			<ul class="clearfix">
				<li><a href="/event_calendar/" class="current"><span>イベントカレンダー</span></a></li>
				<li><a href="/event/"><span>公演･イベント情報</span></a></li>
			</ul>
		</div>

	</div>
	</div><!-- /.right_column -->

	<div class="left_column">
	<?php
		$current_year = $year;	// ページで表示している年
		$current_month = $month;	// ページで表示している月
		// include('sidebar-posts.php');	// サイドバー
		set_query_var('current_year', $current_year);
		set_query_var('current_month', $current_month);
		set_query_var('hall_slug', $hall_slug);
		set_query_var('side_ttEvents', $side_ttEvents);
		get_template_part('sidebar-event_calendar');
	?>
	</div>
	<!-- /.left_column -->

	<?php get_footer(); ?>
