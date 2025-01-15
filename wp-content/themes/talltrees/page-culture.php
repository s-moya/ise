<?php
/**
Template Name: 生涯学習センター教養講座
*/

get_header();
// get_template_part( 'content-topicpath_title', get_post_format() );

$settingPageID = get_id_by_slug('setting');
$mark_days = get_field('mark_days', $settingPageID);

?>
<div class="right_column">

	<?php
	while ( have_posts() ) : the_post();

		$content = get_the_divided_content('');

	?>
	<header class="contentsHeader">
		<h1><?php the_title();?></h1>
	</header>

	<section class="">
	<div class="free_area clearfix">
	<?php
	echo $content['before'];
	?>
	</div>
	</section>

	<h2><?php echo get_field('kouza_title');?></h2>
	<section class="cultureArea">
		<ul class="event_list clearfix fixHeight culture_list">
			<?php
			$args = array(
				'post_type' => 'culture',
				'posts_per_page' => -1
			);
			$culturePosts = get_posts($args);
			foreach ($culturePosts as $culturePost) {
				$cultureID = $culturePost->ID;
				$title = get_the_title($cultureID);
				$brTitle = get_field('event_title',$cultureID);
				if($brTitle) $title = $title;
				$place = get_field('place', $cultureID);
				$time = get_field('time', $cultureID);
				$price = get_field('price', $cultureID);
				$contact = get_field('contact', $cultureID);
				$remark = get_field('remark', $cultureID);
				$copy = get_field('copy',$cultureID);
				$url = get_permalink($cultureID);
				$thumb = get_field('thumb',$cultureID)['url'];
				if(!$thumb){
				  $thumb = '/image-nowprinting.jpg';
				}

				//チケットの状態
				$cat_args = array('orderby' => 'order');
				$cat_tags = '';
				$ticket_tags = '';
				$ticket_terms = wp_get_post_terms($cultureID, 'culture_label', $cat_args);
				foreach($ticket_terms as $ticket_term){
				  $ticket_slug = $ticket_term->slug;
				  $ticket_name = $ticket_term->name;

				  // タグの色を取得する
				  $tag_id = 'culture_label_'.$ticket_term->term_id;
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

			?>
			<li class="clearfix">
				<div class="thumb"><a href="<?php echo $url;?>"><img src="<?php echo $thumb;?>" alt="">
				<?php
				// NEW・UPDATEをそれぞれ**日間だけ表示
				$hide_baloon = get_field('hide_baloon', $cultureID);  //baloonを表示するかどうか
				$modified = false; //更新したかどうかのフラグ
			  // $visibleDays = 5.0;
				$visibleDays = $mark_days; //○日間表示
			  $today = (int) date_i18n('U');
			  $entry = (int) get_the_time('U', $cultureID);
			  $update = (int) get_the_modified_time('U', $post->ID);	// 最終日の更新日
			  $elapsed = (float)($today - $entry) / 86400.0;
			  $elapsed_update = (float)($today - $update) / 86400.0;
				if(!$hide_baloon){
				  if( $visibleDays > $elapsed ){?>
				    <div class="bl bl-new">NEW</div>
				  <?php
				  }else if ( $visibleDays > $elapsed_update ){
				    $modified = true;
				  ?>
				    <div class="bl bl-update">UPDATE</div>
				  <?php
				  }
				} ?>
				</a>
				</div>
				<div class="detail">
					<div class="timesNum"><?php echo $time;?></div>
					<h3><a href="<?php echo $url;?>"><?php echo $title;?></a></h3>
					<p><?php echo $copy;?></p>
					<?php echo $ticket_tags;?>
				</div>
			</li>
			<?php
			}
			?>
		</ul><!-- /event_list -->
	</section>

	<section class="">
	<div class="free_area clearfix">
	<?php //the_content();?>
	<?php echo $content['after'];?>
	</div>
	</section>


	<?php endwhile;?>

</div><!-- /right_column -->

<div class="left_column">
	<?php get_sidebar('all');?>
</div>
<!-- /.left_column -->

<?php get_footer();?>
