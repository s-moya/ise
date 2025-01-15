<?php
/**
 * The template part for displaying results in search pages
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php twentyfifteen_post_thumbnail(); ?>

	<?php
	$tab_target = get_field('tab_target',$post->ID);
	$post_link = get_field('url',$post->ID);
	if(!$post_link){
		$post_link = get_permalink($post->ID);
	}

	// お知らせ
	if ( 'post' == get_post_type() ) {
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

		<dl class="clearfix">
		<dt>
			<?php // echo get_the_date('Y/n/j');?>
			<span class="tag_container"><?php echo $cat_tags; ?></span>
		</dt>
		<dd><a href="<?php echo $post_link;?>" class="arrow" <?php echo ($tab_target) ? 'target="_blank"' : '';?>><?php the_title(); ?></a></dd>
		</dl>

	<?php } else if ( 'event' == get_post_type() ) { ?>

		<dl class="clearfix">
		<dt>
			<?php // echo get_the_date('Y/n/j');?>
			<span class="tag_container"><span class="tag">公演･イベント</span></span>
		</dt>
		<dd><a href="<?php echo $post_link;?>" class="arrow"><?php the_title(); ?></a></dd>
		</dl>

	<?php } else if ( 'series' == get_post_type() ) { ?>

		<dl class="clearfix">
		<dt>
			<?php // echo get_the_date('Y/n/j');?>
			<span class="tag_container"><span class="tag">シリーズ企画</span></span>
		</dt>
		<dd><a href="<?php echo $post_link;?>" class="arrow"><?php the_title(); ?></a></dd>
		</dl>

	<?php } else if ( 'culture' == get_post_type() ) { ?>

		<dl class="clearfix">
		<dt>
			<?php // echo get_the_date('Y/n/j');?>
			<span class="tag_container"><span class="tag">教養講座</span></span>
		</dt>
		<dd><a href="<?php echo $post_link;?>" class="arrow"><?php the_title(); ?></a></dd>
		</dl>

	<?php } else if ( 'artist' == get_post_type() ) { ?>

		<dl class="clearfix">
		<dt>
			<span class="tag_container"><span class="tag">アーティスト</span></span>
		</dt>
		<dd><a href="<?php echo $post_link;?>" class="arrow"><?php the_title(); ?></a></dd>
		</dl>

	<?php } else { ?>
		<dl class="clearfix">
		<dt>
			<?php
			$page_category_obj = get_the_terms($post->ID, 'page_category');
			if(!$page_category_obj){
			?>
			<span class="tag_container"><span class="tag"><?php echo get_most_parent_page()->post_title;?></span></span>
			<?php }?>
		</dt>
		<dd><a href="<?php echo $post_link;?>" class="arrow"><?php the_title(); ?></a></dd>
		</dl>

	<?php }?>

</li><!-- #post-## -->
