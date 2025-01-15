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

$theme_path = get_stylesheet_directory_uri(); //テーマパス
$blog_path  = get_bloginfo("url"); //ブログURL
$post_obj   = get_post_type_object(get_post_type());

get_header();
// get_template_part( 'content-topicpath_title', get_post_format() );

?>

	<div class="right_column">

		<header class="contentsHeader">
			<h1>ページが見つかりませんでした</h1>
		</header>
		<p>
			お探しのページは移動したか削除された可能性があります。<br>
			検索をお試しください。
		</p>
		<div class="clearfix mb-15"><?php get_template_part( 'content', 'search_form' ); ?></div>
		<p>
			<a href="<?php echo $blog_path;?>" class="arrow">トップページへ</a>
		</p>

	</div><!-- /right_column -->

	<div class="left_column">
		<?php get_sidebar('all');?>
	</div>
	<!-- /.secondary -->

<?php get_footer(); ?>
