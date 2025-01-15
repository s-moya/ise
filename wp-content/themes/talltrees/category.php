<?php
/*
template : category
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
if(get_post_type_object(get_post_type())){
  $post_obj   = get_post_type_object(get_post_type());
  $post_type  = $post_obj->name; //ポストタイプ
  $post_type_label = $post_obj->label; //ポストタイプ名
}else if(is_category()){
  $post_type  = 'post'; //ポストタイプ
}else if(is_archive('event')){
  $post_type  = 'event'; //ポストタイプ
  $post_type_label = '公演・イベント情報'; //ポストタイプ名
}
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
		'slug'=>$hall_slug
	);
	$param_hall_obj = get_terms('category',$hall_args)[0];
	$param_hall_name = $param_hall_obj->name;
	if($hall_slug == 'all'){
		$param_hall_name = $cat_all;
	}

	// 施設ごとに色分け
	switch($hall_slug){
		case 'tochigi':
			$page_color = 'blue';
			break;
		case 'ohira':
			$page_color = 'blue_green';
			break;
		case 'fujioka':
			$page_color = 'pink';
			break;
		case 'tsuga':
			$page_color = 'purple';
			break;
	}
}

global $wp_query;
$query = $wp_query->query;

?>

<div class="right_column">

  <header class="contentsHeader">
    <h1>お知らせ</h1>
  </header>

	<?php
	// カテゴリタブ
	include('content-news_category_tab.php');
	?>

	<ul class="fixHeight index_list info_list">
	<?php
	// お知らせリスト
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();

    $tab_target = get_field('tab_target',$post->ID);
    $post_link = get_field('url',$post->ID);
    if(!$post_link){
      $post_link = get_permalink($post->ID);
    }

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
			<dd><a href="<?php echo $post_link;?>" class="arrow" <?php echo ($tab_target) ? 'target="_blank"' : '';?>><?php the_title(); ?></a></dd>
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
