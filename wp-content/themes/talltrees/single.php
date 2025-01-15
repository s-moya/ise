<?php
/*
template : category
*/

get_header();

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

global $wp_query;
$query = $wp_query->query;

//詳細ページのカテゴリを取得
$single__cat_slug = '';
if(is_single()){
	$category = get_the_category();
	$single_cat_slug = $category[0]->category_nicename;
}
?>

<div class="right_column">

	<header class="contentsHeader">
		<h1>お知らせ</h1>
	</header>

	<?php
	// カテゴリタブ
	include('content-news_category_tab.php');
	?>
	<h1 class="newsTitle">
		<span><?php echo get_the_date('Y年n月j日');?></span>
		<?php the_title();?>
	</h1>
	<?php

	// お知らせ詳細
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();

		// 本文
		?>
		<section class="section clearfix">
			<div class="post_detail free_area">
			<?php echo get_field('info_contents');?>
			</div>
		</section>
		<?php

		// お問い合わせ
		$contact_detail = '';
		$contact_target = get_field('contact_target');
		switch ($contact_target) {
			case 'sogobunka':
				$contact_detail = get_field('contact_sogobunka');
				break;
			case 'amigo':
				$contact_detail = get_field('contact_amigo');
				break;
			case 'iris':
				$contact_detail = get_field('contact_iris');
				break;
			case 'tsuga':
				$contact_detail = get_field('contact_tsuga');
				break;
			default:
				$contact_detail = get_field('contact_other');
				break;
		}
		if($contact_detail){
			$remark = get_field('remark');
		?>
		<section class="relation clearfix">
			<h4>お問い合わせ</h4>
			<div class="relation_detail free_area">
				<?php
					echo $contact_detail;
					if($remark){
						echo '<h5>備考</h5>';
						echo $remark;
					}
				?>
			</div>
		</section>
		<!-- /.relation -->
		<?php
		}
		endwhile;
	else :
	endif;
	?>
</div>
<!-- /.right_column -->

<div class="left_column">
<?php include('sidebar-posts.php');?>
</div>
<!-- /.left_column -->

<?php get_footer(); ?>
