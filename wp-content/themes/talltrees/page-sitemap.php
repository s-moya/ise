<?php
/**
Template Name: サイトマップ
*/

$theme_path 	= get_stylesheet_directory_uri(); //テーマパス
$blog_path		= get_bloginfo("url"); //ブログURL
$post_type    = get_post_type_object(get_post_type())->name; //ポストタイプ

get_header();

?>
<div class="right_column">
	<article>
	<header class="contentsHeader">
		<h1><?php the_title();?></h1>
	</header>

	<section>
	<h2>公演・イベント</h2>
	<ul class="link_list_horizontal">
	<li><a href="<?php echo $blog_path;?>/event/" class="arrow_simple">公演・イベント情報 一覧</a></li>
	<li><a href="<?php echo $blog_path;?>/event_calendar/" class="arrow_simple">イベントカレンダー</a></li>
	</ul>
	</section>

	<?php
	$query = array(
		'post_type'=>'series',
		'post_status'=>'publish',
		'posts_per_page'=>-1,
		'tax_query' => array(
			array(
				'taxonomy' => 'expire_category',	//タクソノミーを指定（公開終了カテゴリは非表示）
				'field' => 'slug',	//ターム名をスラッグで指定する
				'terms' => 'expired_event',	//表示したいタームをスラッグで指定
				'operator'=>'NOT IN'
			)
		)
	);
	$s_events = get_posts($query);
	$set_page_id = get_id_by_slug('setting');
	$visible_culture = get_field('visible_culture', $set_page_id);
	$icn_culture = '';
	$text_culture = '';
	if(!empty($s_events) || $visible_culture){
	?>
	<section>
	<h2>シリーズ企画</h2>
	<ul class="link_list_horizontal">
		<?php
    if($visible_culture){
      $icn_culture = get_field('icn_culture', $set_page_id);
      $text_culture = get_field('text_culture', $set_page_id);
    ?>
    <li><a href="/culture/" class="arrow_simple"><?php echo $text_culture;?></a></li>
    <?php
    }
		foreach( $s_events as $s_event ){
			$s_eventID = $s_event->ID;
			$s_eventLink = get_permalink($s_eventID);
			$s_eventPostTitle = $s_event->post_title;
			$s_eventTitle = get_field('event_title', $s_eventID);
			$s_seriesName = strip_tags(get_field('series_name', $s_eventID));
			$s_eventThumb = get_field('thumb', $s_eventID)['sizes']['thumbnail'];
			if(! $s_eventThumb) $s_eventThumb = $theme_path . '/images/thumb-series.jpg';
		?>
		<li><a href="<?php echo $s_eventLink;?>" class="arrow_simple"><?php echo $s_seriesName;?></a></li>
		<?php
		}
	?>
	</ul>
	</section>
	<?php } ?>

	<section>
	<h2>お知らせ</h2>
	<ul class="link_list_horizontal">
		<!--<li><a href="<?php echo $blog_path;?>/info/" class="arrow_simple">すべて</a></li>-->
		<?php
		$cat_args = array(
			'parent' => 0,
			'hide_empty' => false
		);
		$cat_lists = get_categories($cat_args);
		foreach($cat_lists as $cat_list){
			?>
			<li><a href="<?php echo $blog_path;?>/info/<?php echo $cat_list->slug;?>/" class="arrow_simple"><?php echo $cat_list->name;?></a></li>
		<?php }?>

	</ul>
	</section>

	<section>
	<h2>チケット購入</h2>
	<ul class="link_list_horizontal">
		<li><a href="<?php echo $blog_path;?>/ticket/" class="arrow_simple">チケット購入</a></li>
	</ul>
	</section>

	<section>
	<h2>施設案内</h2>
	<ul class="link_list_horizontal">
		<?php
		$aboutPage_id = get_id_by_slug('about');
		$pages_args = array(
			'post_type' => 'page',
			'posts_per_page' => -1,
			'post_parent' => $aboutPage_id
		);
		$childPages = get_posts($pages_args);
		foreach($childPages as $childPage){
			$childPageLink = get_permalink($childPage->ID);
		?>
		<li><a href="<?php echo get_permalink($childPage->ID);?>" class="arrow_simple"><?php echo $childPage->post_title;?></a></li>
		<?php }?>
	</ul>
	</section>

	<section>
	<h2>利用案内</h2>
	<ul class="link_list_horizontal">
		<?php
		$guidePage_id = get_id_by_slug('guide');
		$pages_args = array(
			'post_type' => 'page',
			'posts_per_page' => -1,
			'post_parent' => $guidePage_id
		);
		$childPages = get_posts($pages_args);
		foreach($childPages as $childPage){
			$childPageLink = get_permalink($childPage->ID);
		?>
		<li><a href="<?php echo get_permalink($childPage->ID);?>" class="arrow_simple"><?php echo $childPage->post_title;?></a></li>
		<?php }?>
	</ul>
	</section>

	<section>
	<h2>交通アクセス</h2>
	<ul class="link_list_horizontal">
		<li><a href="<?php echo $blog_path;?>/access/" class="arrow_simple">交通アクセス</a></li>
	</ul>
	</section>

	<section>
	<h2>その他</h2>
	<ul class="link_list_horizontal">
		<?php
		$guidePage_id = get_id_by_slug('guide');
		$pages_args = array(
			'post_type' => 'page',
			'posts_per_page' => -1,
			'tax_query' => array(
        array(
          'taxonomy' => 'page_category',	//タクソノミーを指定（公開終了カテゴリは非表示）
          'field' => 'slug',	//ターム名をスラッグで指定する
          'terms' => 'page_other',	//表示したいタームをスラッグで指定
          'operator'=>'IN'
        )
      )
		);
		$childPages = get_posts($pages_args);
		foreach($childPages as $childPage){
			$childPageLink = get_permalink($childPage->ID);
		?>
		<li><a href="<?php echo get_permalink($childPage->ID);?>" class="arrow_simple"><?php echo $childPage->post_title;?></a></li>
		<?php }?>
		</ul>
	</section>

	</article>
</div><!-- /right_column -->

<div class="left_column">
	<?php get_sidebar('all');?>
</div>
<!-- /.left_column -->

<?php get_footer();?>
