<?php
/**
Template Name: アーティスト
*/
get_header();
// get_template_part( 'content-topicpath_title', get_post_format() );

?>
<div class="right_column">

	<?php
	while ( have_posts() ) : the_post();
	?>
	<header class="contentsHeader">
		<h1><?php the_title();?></h1>
	</header>

	<div class="free_area">
	<?php
	$content = get_the_divided_content('');
	echo $content['before'];
	// the_content();
	$args = array(
		'post_type' => 'artist',
		'posts_per_page' => -1
	);
	$artistPosts = get_posts($args);
	if(!empty($artistPosts)){
	?>

	<section id="artistlist">
	<h2>登録アーティスト</h2>
	<div class="column_3 clearfix fixHeight">
	<?php
	foreach($artistPosts as $artistPost){
		$arID = $artistPost->ID;
		$title = get_the_title($arID);
		$url = get_permalink($arID);
		$prof = get_field('profile', $arID);
		$prof = mb_strimwidth($prof, 0, 123, "...", 'utf-8');
	?>

	<section class="column_3_inner">
	<h3><a href="<?php echo $url;?>" data-fancybox-type="iframe" class="fancybox fancybox.iframe modal"><?php echo $title;?></a></h3>
	<p><?php echo $prof;?></p>
	</section>
	<?php
	}
	?>
	</div>
	</section>
	<?php }?>

	<?php
	echo $content['after'];
	?>
	</div>
	<?php endwhile;?>

</div><!-- /right_column -->

<div class="left_column">
	<?php get_sidebar('all');?>
</div>
<!-- /.left_column -->

<?php get_footer();?>
