<?php
/*
template : taxonomy genre
*/

get_header();
// get_template_part( 'content-topicpath_title', get_post_format() );

$hall_slug = '';	// 開催館slug
$post_genre_slug = '';	// ジャンルslug
$cat_all = '合同開催'; // allが選択された場合はのカテゴリ名

$theme_path = get_stylesheet_directory_uri(); //テーマパス
$blog_path  = get_bloginfo("url"); //ブログURL
if(get_post_type_object(get_post_type())){
  $post_obj   = get_post_type_object(get_post_type());
  $post_type  = $post_obj->name; //ポストタイプ
  $post_type_label = $post_obj->label; //ポストタイプ名
}else{
  $post_type  = 'event'; //ポストタイプ
}
$page_url   = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  // 現在のページのURL

$taxonomy = $wp_query->get_queried_object();
$taxonomy_name = esc_html($taxonomy->name);;
$post_genre_slug = $taxonomy->slug;
$taxonomy_term = $taxonomy->taxonomy;

global $wp_query;
$query = $wp_query->query;

?>

<div class="right_column">
  <header class="contentsHeader">
    <h1>
      <?php echo ($taxonomy_term == 'cat_series') ? 'シリーズ企画' : '';?>
    </h1>
  </header>
  <h2><?php echo $taxonomy_name;?></h2>
	<?php
	echo '<ul class="event_list_archive">'."\n";


	$paged 	= get_query_var('paged');
	$post_args = array_merge(
		$query,	array(
		'category_name' => $hall_slug
		)
	);
	$wp_query = new WP_Query($post_args);
	query_posts($wp_query->query);
	if ( have_posts() ) :


		// Start the Loop.
		while ( have_posts() ) : the_post();

			$list = $post;
			include('content-event_block.php');

		endwhile;

	else :
	?>
	<li class="no_posts">
		該当の公演・イベント情報はありません。<br>
		<a href="<?php echo $blog_path;?>/series/" class="arrow">公演・イベント情報一覧</a>
	</li>
	<?php
	endif;

	echo '</ul>'."\n";
	echo '<div class="pagination">'."\n";
	if(function_exists('wp_pagenavi')) {
		wp_pagenavi();
	}
	echo '</div>'."\n";

	?>
</div>

<div class="left_column">
<?php include('sidebar-posts.php');?>
</div>
<!-- /.left_column -->

<?php get_footer(); ?>
