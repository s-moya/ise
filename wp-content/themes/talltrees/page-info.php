<?php
/**
Template Name:  お知らせ一覧
*/
get_header();
// get_template_part( 'content-topicpath_title', get_post_format() );

$hall_slug = '';	// 開催館slug
$post_genre_slug = '';	// ジャンルslug
$param_hall_name = '';	// 開催館名
$page_color ='';	//ページの色分け
$cat_all = '総合案内'; // allが選択された場合はのカテゴリ名

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

global $wp_query;
$query = $wp_query->query;

?>
	<div class="right_column">

		<header class="contentsHeader">
			<h1><?php the_title();?></h1>
		</header>

		<?php
		// カテゴリタブ
		include('content-news_category_tab.php');
		?>

		<ul class="fixHeight index_list info_list">
		<?php
		// お知らせリスト
		$paged 	= get_query_var('paged');
		$post_args = array(
			// 'category_name' => $hall_slug,
			'post_type'=>'post',
			'post_status'=>'publish',
			'paged'=>$paged
		);
		query_posts($post_args);
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();

			$newsLink = get_field('url');
			$tab_target = get_field('tab_target');

			//カテゴリ
			$sort_slug = '';
			$cat_tags = '';
			$cat_args = array('orderby' => 'order');
			$cat_terms = wp_get_post_terms(get_the_ID(), 'category', $cat_args);
			foreach($cat_terms as $cat_term){
			  $cat_slug = $cat_term->slug;
			  $cat_name = $cat_term->name;

				$sort_slug .= ' hall_'.$cat_slug;

			  if($cat_slug == 'all'){
			    $cat_name = $cat_all;
			  }
			  // $cat_tags .= '<span class="tag tag-'.$cat_slug.'">'.$cat_name.'</span>';
			  if($cat_term === end($cat_terms)){
			    $cat_tags .= '<span class="tag tag-'.$cat_slug.'">'.$cat_name.'</span>'."\n";
			  }else{
			    $cat_tags .= '<span class="tag tag-'.$cat_slug.'">'.$cat_name.'</span>';
			  }
			}

			?>
			<li class="<?php echo $sort_slug;?>">
				<dl class="clearfix">
				<dt>
					<?php echo get_the_date('Y/n/j');?>
					<span class="tag_container"><?php echo $cat_tags; ?></span>
				</dt>
				<dd><a href="<?php echo ($newsLink) ? $newsLink : get_permalink();?>" class="arrow" <?php echo ($tab_target) ? 'target="_blank"' : '';?>><?php the_title(); ?></a></dd>
				</dl>
			</li>
			<?php
			endwhile;
		else :?>
		<li class="no_posts">お知らせはありません</li>
		<?php
		endif;
		?>
		</ul>

		<?php
		if(function_exists('wp_pagenavi')) {
			echo '<div class="pagination">'."\n";
			wp_pagenavi();
			echo '</div>'."\n";
		}
		wp_reset_query();

		?>
	</div>
	<!-- /.right_column -->

	<div class="left_column">
	<?php include('sidebar-posts.php');?>
	</div>
	<!-- /.left_column -->

	<?php get_footer(); ?>
