<?php
/*
template :イベント詳細
*/

$theme_path 	= get_stylesheet_directory_uri(); //テーマパス
$blog_path		= get_bloginfo("url"); //ブログURL
$post_type    = get_post_type_object(get_post_type())->name; //ポストタイプ
$page_url     = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  // 現在のページのURL
$cat_all 			= '合同開催'; // allが選択された場合はのカテゴリ名

get_header();
// get_template_part( 'content-topicpath_title', get_post_format() );


// Start the loop.
while ( have_posts() ) : the_post();

// カテゴリ（施設名を取得）
// ------------------------
$cat_args = array('orderby' => 'order');
$hall_name = '';
$cat_terms = wp_get_post_terms(get_the_ID(), 'category', $cat_args);
foreach($cat_terms as $cat_term){
	if($cat_term === reset($cat_terms)){
		$cat_slug = $cat_term->slug;
		$cat_name = $cat_term->name;
		if($cat_slug == 'all'){
			$cat_name = $cat_all;
		}
		$hall_slug = $cat_slug;
		$hall_name = $cat_name;
	}
}

// ジャンル
// ------------------------
$genre_name = '';
$genre_terms = wp_get_post_terms(get_the_ID(), 'genre', $cat_args);
foreach($genre_terms as $genre_term){
	if($genre_term === reset($genre_terms)){
		$post_genre_slug = $genre_term->slug;
		$post_genre_name = $genre_term->name;
	}
}

// チケット
// ------------------------
$ticket_tags = '';
$ticket_terms = wp_get_post_terms(get_the_ID(), 'ticket', $cat_args);
foreach($ticket_terms as $ticket_term){
	$ticket_slug = $ticket_term->slug;
	$ticket_name = $ticket_term->name;

	// タグの色を取得する
  $tag_id = 'ticket_'.$ticket_term->term_id;
  $tag_color = '';
  $tag_color_num = get_field('tag_color', $tag_id);
  if($tag_color_num){
    $tag_color = 'style="border-color:'.$tag_color_num.'; color:'.$tag_color_num.';"';
  }

  if($ticket_term === end($ticket_terms)){
    $ticket_tags .= '<span class="tag-ticket tag-'.$ticket_slug.'"'.$tag_color.'>'.$ticket_name.'</span>'."\n";
  }else{
    $ticket_tags .= '<span class="tag-ticket tag-'.$ticket_slug.'"'.$tag_color.'>'.$ticket_name.'</span>';
  }

}

// ラベル（主催・共催など）
// ------------------------
$labels_name = '';
$labels_tags = '';
$labels_terms = wp_get_post_terms(get_the_ID(), 'labels', $cat_args);
foreach($labels_terms as $labels_term){
	$labels_slug = $labels_term->slug;
	$labels_name = $labels_term->name;
	$labels_tags .= '<span class="tag tag-ticket tag-'.$labels_slug.'">'.$labels_name.'</span>';
}


// 日付
// ------------------------
// 日付フォーマット指定

// 日付を取得
$schedule_dates = array();
$limit = get_field('limit'); //開催日の種類
$schedule_array = get_field('schedule');

$schedule_year_array = array();
foreach($schedule_array as $schedule){
  $schedule_year = new DateTime($schedule['date']); // 開催日
  $schedule_year = $schedule_year->format('Y');

	$format_style = 'n月j日';
  if ( !in_array($schedule_year, $schedule_year_array) ) {
  	$schedule_year_array[] = $schedule_year;
  	$format_style = 'Y年n月j日';
  }
	$schedule_date = tt_format_date($schedule['date'], $format_style, '');

	$is_holiday = $schedule['is_holiday'];	// 祝日表示
	if( $is_holiday ) {
		$schedule_date = str_replace( ')', '･祝)', $schedule_date );	// 祝日表示
	}

  $schedule_dates[]	= $schedule_date;
}

// 開催日の種類によって出力を変更
switch($limit){
  case 'multi':
    $glue	= ' ･ ';
    break;
  case 'continue':
    $glue	= ' 〜 ';
    break;
  default :
    $glue	= ' ';
    break;
}
$schedule = implode( $glue, $schedule_dates );


// 基本情報
// ------------------------
$title = get_field('event_title');	//タイトル
$thumb = get_field('thumb')['url'];	//サムネ
if(!$thumb){
	$thumb = '/image-nowprinting.jpg';
}
$pdf = get_field('pdf')['url'];	//pdf
$time = get_field('time');		//時間
$price = get_field('price');	//料金
$copy = get_field('copy');		//キャッチコピー
$main_text = get_field('main_text');	//コピー文章

$postExpire = do_shortcode('[postexpirator]'); //公開期限取得
// $postExpireDate = tt_format_date($postExpire, 'Y-m-d', 'Y-m-d H:i:s', false); //期限（日）
$postExpireDate = tt_format_date($postExpire, 'Y-m-d H:i:s', 'Y-m-d H:i:s', false); //期限（日）
$postNowDate = date_i18n('Y-m-d H:i:s'); //現在（日）

// $exipred = get_terms('expire_category',$post->ID);
// var_dump($exipred);
// var_dump('postExpireDate'. $postExpireDate);
// var_dump('postNowDate'. $postNowDate);

$closed = '';
if($postExpireDate && $postNowDate > $postExpireDate){
  $closed = '<span class="closed" title="'.$postExpireDate.'">このプログラムは終了しました</span>';
}

?>

<div class="right_column">
<header class="contentsHeader">
	<h1>公演・イベント情報
		<span class="more"><a href="/event/" class="arrow_simple"><?php echo $hall_name;?> 公演･イベント一覧へ</a></span>
	</h1>
</header><!-- /.contentsHeader -->


<!-- ▼▼▼ 基本情報 ▼▼▼ -->
<section class="section <?php echo $post_type;?>_section">
<h2 class="title_date">
	<strong><?php echo $schedule;?></strong>
	<span class="tag_container"><?php echo ($labels_tags) ? $labels_tags :'';?></span>
</h2>
<h3 class="spText">
	<?php echo $closed;?>
	<span><?php echo $copy;?></span>
	<?php echo $title;?>
</h3>
<div class="basic_area clearfix">
	<div class="detail">
		<h3>
			<?php echo $closed;?>
			<span><?php echo $copy;?></span>
			<?php echo $title;?>
		</h3>
		<?php
			echo ($main_text) ? '<div class="main_text free_area">'.$main_text.'</div>'."\n" : '';
			echo ($ticket_tags) ? '<p>'.$ticket_tags.'</p>'."\n" : '';
		?>
	</div>
	<div class="thumb">
		<img src="<?php echo $thumb;?>" alt="<?php the_title();?>">
		<?php
			echo ($pdf) ? '<p><a href="'.$pdf.'" target="_blank" class="arrow pdf_link">PDFダウンロード<span>PDF</span></a></p>'."\n" : '';
		?>
	</div>
</div>
<!-- /.basic_area -->
</section>
<!-- /.section -->


<!-- ▼▼▼ タブ  ▼▼▼ -->
<?php

// タブの表示・非表示
	$hide_outline = get_field('hide_outline');
	$outline_name = get_field('outline_name');	// タブ名称
	$hide_ticket = get_field('hide_ticket');
	$hide_profile = get_field('hide_profile');
	$hide_tab = false;

// 公演概要
	$hall_select_obj = get_field_object('hall'); // 開催館obj
	$addField_outline_array = get_field('addField_outline');	// 追加項目
	$addField_outline_array_02 = get_field('addField_outline_02');	// 追加項目（クレジット）
	$syusai = get_field('detail_syusai');	// 主催

// チケット情報
	$current_ticket = get_field('current_ticket');	// このタブを最初に表示
	$ticket_release = get_field('ticket_release');	// チケット発売日
	$ticket_price = get_field('ticket_price');	// 料金
	$ticket_detail = get_field('ticket_detail');	// チケット取り扱い
	$is_ticket_bnr = get_field('is_ticket_bnr');	// チケットバナー
	$addField_ticket_array = get_field('addField_ticket');	// 追加項目
	if($addField_ticket_array){
		$is_empty_addField_ticket = array_filter($addField_ticket_array, "array_filter");
	}else{
		$is_empty_addField_ticket = false;
	}
	if(!$ticket_release && !$ticket_price && !$ticket_detail && !$price && empty($is_empty_addField_ticket)){
		$hide_ticket = true;
	}
	if( $hide_ticket ) $current_ticket = false;

// 出演者プロフィール
	$is_profile = '';
	$current_profile = get_field('current_profile');	// このタブを最初に表示
	$addField_profile_array = get_field('addField_profile');
	$is_empty_addField_profile = false;
	if( $addField_profile_array ){
		$is_empty_addField_profile = array_filter($addField_profile_array, "array_filter");
	}
	if(empty($is_empty_addField_profile)){
		$hide_profile = true;
	}else{
		foreach($addField_profile_array as $addField_profile){
			$is_profile .= $addField_profile['name'].$addField_profile['photo']['url'].$addField_profile['text'];
		}
		if(!$is_profile){
			$hide_profile = true;
		}
	}
	if( $hide_profile ) $current_profile = false;

// 追加タブ
	$is_addTab = '';
	$current_tabs = false;
	$addField_tab_array = get_field('addField_tab');

	$is_empty_tabs = false;
	if( $addField_tab_array ){
		$is_empty_tabs = array_filter($addField_tab_array, "array_filter");
	}

	if(empty($is_empty_tabs)){
		$hide_tab = true;
	}else{
		foreach($addField_tab_array  as $addField_tab){
			$current_tabs .= $addField_tab['current_tab'];	// このタブを最初に表示
			$is_addTab .= $addField_tab['tab_title'].$addField_tab['tab_content'];
		}
		if(!$is_addTab){
			$hide_tab = true;
		}
	}
	if( $hide_tab ) $current_tabs = false;

// それぞれのタブの表示・非表示からカレント表示を判断する
	// 公演概要
	$is_current_outline = false;
	$is_current_except_outline = $current_ticket.$current_profile.$current_tabs;
	if(! $is_current_except_outline ) $is_current_outline = true;

	// チケット情報
	$is_current_ticket = false;
	$is_current_except_ticket = $current_profile.$current_tabs;
	if( $hide_outline && !$is_current_except_ticket || $current_ticket){
		$is_current_ticket = true;
	}

	// 出演者プロフィール
	$is_current_profile = false;
	$is_current_except_profile = $current_ticket.$current_tabs;
	if( $hide_outline && $hide_ticket && !$is_current_except_profile || $current_profile ){
		$is_current_profile = true;
	}

	// 追加タブ
	$is_current_addtabs = false;
	$is_current_except_addtabs = $current_ticket.$current_profile;
	if( $hide_outline && $hide_ticket && $hide_profile && !$is_current_except_addtabs ){
		$is_current_addtabs = true;
	}

?>

<div class="hall_tab_content">
	<ul class="hall_tab_area clearfix">
	<?php
	if(!$hide_outline){
		if($is_current_outline){
		?><li class="hall_tab_area_current"><?php
		}else{
		?><li><?php
		}?>
		<span><?php echo $outline_name ? $outline_name : '公演概要';?></span></li>
		<?php
	}
	if(!$hide_ticket){
		if($is_current_ticket){
		?><li class="hall_tab_area_current"><?php
		}else{
		?><li><?php
		}
		?><span>チケット情報</span></li><?php
	}
	if(!$hide_profile){
		if($is_current_profile){
		?><li class="hall_tab_area_current"><?php
		}else{
		?><li><?php
		}
		?><span>出演者プロフィール</span></li><?php
	}
	if(!$hide_tab){
		$any_current = false;
		foreach ($addField_tab_array as $addField_tab) {
			$tab_title = $addField_tab['tab_title'];
			$current_tab = $addField_tab['current_tab'];
			if( $is_current_addtabs && !$any_current && !$current_tabs ){
				if ($addField_tab === reset($addField_tab_array)){
					$any_current = true;
					echo '<li class="hall_tab_area_current">';
				}
			}else{
				if( $current_tab ){
					$any_current = true;
					echo '<li class="hall_tab_area_current">';
				}else{
					echo '<li>';
				}
			}
			?>
			<span><?php echo $tab_title;?></span></li>
			<?php
		}
	}
	?>
	</ul>
	<ul class="hall_tab_detail">
	<?php
	// 公演概要
	// ------------------------
	if(!$hide_outline){
		$place = '';

		// 会場を取得
		$places_obj = get_field_object('place');	// 会場obj

		$places_select_value = $places_obj['value'];	// 会場selected
		$place_num = count($places_select_value);	// 会場selected数

		if(!empty($places_select_value)){
			foreach($places_select_value as $places_select){
				if($places_select == 'other'){
		          $places_name = get_field_object('place_other')['value'];
		        }else{
		          $places_name = $places_obj['choices'][$places_select]; // 会場名
		        }
				// $places_name = $places_obj['choices'][$places_select]; // 会場名

				if($places_select === end($places_select_value)){
					$place .= $places_name.'<br>';
				}else{
					$place .= $places_name.'、';
				}
			}
		}

		?>
		<li class="<?php echo ($is_current_outline) ? 'hall_tab_detail_current' : '';?>">
		<div class="tabIndex"><a href=""><?php echo $outline_name ? $outline_name : '公演概要';?></a></div>

		<div class="tabDetail">
		<h4><?php echo $outline_name ? $outline_name : '公演概要';?></h4>
		<table class="table_2">
		<col width="25%"><col width="75%">
		<tbody>
		<tr><th>公演日</th><td><?php echo $schedule;?></td></tr>
		<?php
		if($time){?>
			<tr><th>時間</th><td class="free_area"><?php echo $time;?></td></tr>
		<?php
		}if($price){?>
			<tr><th>料金</th><td class="free_area"><?php echo $price;?></td></tr>
		<?php
		}if($place){?>
			<tr><th>会場</th><td class="free_area"><?php echo $place;?></td></tr>
		<?php
		}if($addField_outline_array){
			foreach ($addField_outline_array as $addField_outline) {?>
				<tr>
				<th><?php echo $addField_outline['title'];?></th>
				<td class="free_area"><?php echo $addField_outline['content'];?></td>
				</tr>
			<?php
			}
		}?>
		</tbody></table><!-- /.table_1 -->
		<?php

		// 主催・共催等は別のテーブルにわける
		if($syusai || $addField_outline_array_02){
		?>
		<table class="table_2">
		<col width="25%"><col width="75%">
		<tbody>
		<?php
		if($syusai){?>
			<tr><th>主催</th><td class="free_area"><?php echo $syusai;?></td></tr>
		<?php
		}if($addField_outline_array_02){
			foreach ($addField_outline_array_02 as $addField_outline_02) {?>
				<tr>
				<th><?php echo $addField_outline_02['title'];?></th>
				<td class="free_area"><?php echo $addField_outline_02['content'];?></td>
				</tr>
			<?php
			}
		}?>
		</tbody></table><!-- /.table_1 -->
		<?php
		}
		?>
		</div>
		</li>
	<?php
	}

	// チケット情報
	// ------------------------
	if(!$hide_ticket){
	?>
		<li <?php echo ($is_current_ticket) ? ' class="hall_tab_detail_current"' :'';?>>
		<div class="tabIndex"><a href="">チケット情報</a></div>
		<div class="tabDetail">
		<h4>チケット情報</h4>
		<table class="table_2">
		<col width="25%"><col width="75%">
		<tbody>
		<?php
		if($ticket_release){?>
			<tr><th>チケット発売日</th><td class="free_area"><?php echo $ticket_release;?></td></tr>
		<?php
		}if($price){?>
			<tr><th>料金</th><td class="free_area"><?php echo $price;?></td></tr>
		<?php
		}if($ticket_detail || $is_ticket_bnr){?>
			<tr>
				<th>チケット取り扱い</th>
				<td class="free_area">
				<?php if( $is_ticket_bnr ){ ?>
					<?php $alt = 'インターネットからのチケットご予約 オンラインチケットのご購入はこちら';?>
					<div class="ticket_bnr">
						<a href="<?php echo get_field('ticket_bnr_url');?>" target="_blank" class="alpha">
							<img src="<?php echo $theme_path;?>/images/common/btn_onlineticket_pc.jpg" alt="<?php echo $alt;?>" class="for-pc">
							<img src="<?php echo $theme_path;?>/images/common/btn_onlineticket_sp.jpg" alt="<?php echo $alt;?>" class="for-sp">
						</a>
					</div>
				<?php }?>
				<?php echo ($ticket_detail) ? $ticket_detail : '';?>
				</td>
			</tr>
		<?php
		}if($addField_ticket_array){
			foreach ($addField_ticket_array as $addField_ticket) {?>
				<tr>
				<th><?php echo $addField_ticket['title'];?></th>
				<td class="free_area"><?php echo $addField_ticket['content'];?></td>
				</tr>
			<?php
			}
		}?>
		</tbody></table><!-- /.table_1 -->
		</div>
		</li>
	<?php
	}

	// 出演者プロフィール
	// ------------------------
	if(!$hide_profile){
	?>
	<li class="profile_tab <?php echo ($is_current_profile) ? 'hall_tab_detail_current' :'';?>">
		<div class="tabIndex"><a href="">出演者プロフィール</a></div>
		<div class="tabDetail">
		<h4>出演者プロフィール</h4>
		<?php
		foreach ($addField_profile_array as $addField_profile) {
			$photo = $addField_profile['photo']['url'];
			$photo_caption = $addField_profile['photo']['caption'];
		?>
			<section class="section">
			<h5><?php echo $addField_profile['name'];?></h5>
			<div class="free_area <?php echo ($photo) ? 'hasPhoto clearfix' : '';?>">
				<?php
				if($photo){?>
				<span class="profileImage <?php if ($photo_caption) echo 'withCaption';?>">
					<img src="<?php echo $photo;?>" alt="<?php echo $addField_profile['name'];?>"><?php
					if ($photo_caption) echo $photo_caption;
					?>
				</span>
				<?php
				}
				echo $addField_profile['text'];?>
			</div>
			</section>
		<?php
		}?>
		</div>
	</li>
	<?php
	}

	// 追加タブ
	// ------------------------
	if(!$hide_tab){

		$any_current = false;
		foreach ($addField_tab_array as $addField_tab) {
			$tab_title = $addField_tab['tab_title'];
			$tab_content = $addField_tab['tab_content'];
			$current_tab = $addField_tab['current_tab'];	// このタブを最初に表示
			if( $is_current_addtabs && !$any_current && !$current_tabs ){
				if ($addField_tab === reset($addField_tab_array)){
					$any_current = true;
					echo '<li class="hall_tab_detail_current">';
				}
			}else{
				if( $current_tab ){
					$any_current = true;
					echo '<li class="hall_tab_detail_current">';
				}else{
					echo '<li>';
				}
			}
		?>
		<div class="tabIndex"><a href=""><?php echo $tab_title;?></a></div>
		<div class="tabDetail">
		<h4><?php echo $tab_title;?></h4>
		<div class="free_area"><?php echo $tab_content;?></div>
		</div>
		</li>
	<?php
		}
	}
	?>
	</ul>
</div>


<!-- ▼▼▼ お問い合わせ ▼▼▼ -->
<?php
$contact_detail = '';
$contact_detail = get_field('contact');
// お問い合わせ
if($contact_detail){
	$remark = get_field('remark');
?>
<section class="relation clearfix eventRelation">
	<h4>お問い合わせ</h4>
	<div class="relation_detail free_area">
		<?php echo $contact_detail;?>
	</div>
</section>
<!-- /.relation -->
<?php
}

// 備考
$remark = get_field('remark');
if($remark){
?>
<!-- ▼▼▼ 備考 ▼▼▼ -->
<section class="relation clearfix">
	<h4>備考</h4>
	<div class="relation_detail free_area">
		<?php
			echo $remark;
		?>
	</div>
</section>
<!-- /.relation -->
<?php
}?>
<p class="backlink"><a href="/event/" class="arrow arrow_large"> 公演･イベント一覧へ</a></p>
</div>
<!-- /right_column -->

<?php
// End the loop.
endwhile;
?>

<div class="left_column">
<?php include('sidebar-posts.php');?>
</div>
<!-- /.left_column -->
<?php get_footer(); ?>
