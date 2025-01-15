<?php
/**
Template Name: 季刊紙
*/

$theme_path 	= get_stylesheet_directory_uri(); //テーマパス
$blog_path		= get_bloginfo("url"); //ブログURL
$post_type    = get_post_type_object(get_post_type())->name; //ポストタイプ

get_header();
// get_template_part( 'content-topicpath_title', get_post_format() );

?>
<div class="right_column">
	<header class="contentsHeader">
		<h1><!--<font>伊勢市観光文化会館</font>-->かんぶんニュース</h1>
	</header>
	<?php
	while ( have_posts() ) : the_post();
	?>
	<div class="free_area clearfix">
	<?php
	if($post->post_content){
		echo get_the_content();
	}
	?>
	</div>
	<article>

	<?php
	$args = array(
		'post_type' => 'journal',
		'posts_per_page' => 1
	);
	?>
	<section id="latest">
	<h2>最新号</h2>
	<?php
	$journalPosts = get_posts($args);
	foreach($journalPosts as $journalPost){
		$journalID = $journalPost->ID;
		$thumb = get_field('thumb', $journalID)['url'];
		$pdf = get_field('pdf', $journalID)['url'];
		$text = get_field('text', $journalID);
		$index_set = get_field('index_set', $journalID);

		//	発行年
		$issue_args = array('orderby' => 'order');
		$issue_terms = wp_get_post_terms($journalID, 'issue_year', $issue_args);
		foreach($issue_terms as $issue_term){
			$issue_slug = $issue_term->slug;
			$issue_name = $issue_term->name;
		}
		?>
		<div class="latest column_2 clearfix">
		<div class="detail">
			<h3><?php echo $issue_name;?>年 <?php echo get_the_title($journalID);?></h3>
			<?php
			if($text){
			?>
			<div class="text"><?php echo $text;?></div>
			<?php
			}
			if(!empty($index_set)){
				?>
				<ul class="mokuji">
				<?php
				foreach($index_set as $index){
					$index_title = $index['title'];
					$index_link = $index['link'];
					?>
					<li><a href="<?php echo $index_link;?>" class="arrow_simple" target="_blank"><?php echo $index_title;?></a></li>
					<?php
				}
				?>
				</ul>
				<?php
			}
			?>
			<a href="<?php echo $pdf;?>" class="btn-primary btn-external" target="_blank">最新号のPDFはこちら</a>
		</div>
		<div class="thumb"><img src="<?php echo $thumb;?>" alt=""></div>
		</div>
		<?php
	}
	?>
	</section>

	<section id="backnumber" class="backnumber">
	<h2>バックナンバー</h2>
	<?php
	$taxonomy = 'issue_year';
	$args = array(
		'orderby' => 'id',
		'order' => 'desc',
		'pad_counts' => true,
		'hide_empty' => true,
		
	);
	// リストを取得
	$terms = get_terms($taxonomy, $args);
	foreach($terms as $term){
		$term_slug	= $term->slug;
		$term_name 	= $term->name;
		?>

		<div class="clearfix block">
			<h3><?php echo $term_name.'年';?></h3>
			<ul class="clearfix" style="display: flex; justify-content: flex-start; align-items: flex-start; flex-wrap: wrap;">
			<?php
			$postArgs = array(
				'orderby' => 'modified',//'title',
				'order' => 'DESC',
				'post_type' => 'journal',
				'issue_year' => $term_slug,
				'posts_per_page' => -1
			);
			$bnPosts = get_posts($postArgs);
			foreach ($bnPosts as $bnPost) {
				$bnID = $bnPost->ID;
				$bnTitle = $bnPost->post_title;
				$bnthumb = get_field('thumb', $bnID)['url'];
				$bnPdf = get_field('pdf', $bnID)['url'];
				?>
				<li style="float: none;"><a href="<?php echo $bnPdf;?>" target="_blank">
					<img src="<?php echo $bnthumb;?>" alt=""></a>
					<h4><?php echo $bnTitle;?></h4>
				</li>
				<?php
			}
			?>
			</ul>
		</div>
		<?php
	}
	?>
	</section>
	<?php endwhile;?>

	</article>
</div><!-- /right_column -->

<div class="left_column">
	<?php get_sidebar('all');?>
</div>
<!-- /.left_column -->

<?php get_footer();?>
