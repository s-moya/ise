<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header();
// get_template_part( 'content-topicpath_title', get_post_format() );

?>
<div class="right_column">

	<?php
	while ( have_posts() ) : the_post();
	?>
	<header class="contentsHeader">
		<h1>
			<?php
				$topLevelPage ='';
				$topLevelPage = get_most_parent_page($post->ID)->post_title;
				if($post->post_title != $topLevelPage) echo '<span class="categName">' . $topLevelPage . '</span>';
			?>
			<?php the_title();?>
		</h1>
	</header>

	<div class="free_area">
	<?php
	the_content();

	// 資料ダウンロード
	if(is_page('download')){
		get_template_part( 'content', 'download' );

	// 施設空き状況
	}else if(is_page('vacant')){
		get_template_part( 'content', 'vacant' );
	}
	?>
	</div>
	<?php endwhile;?>

</div><!-- /right_column -->

<div class="left_column">
	<?php get_sidebar('all');?>
</div>
<!-- /.left_column -->

<?php get_footer();?>
