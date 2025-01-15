<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

<div class="right_column">

	<header class="contentsHeader">
		<h1>｢<?php echo get_search_query();?>」検索結果</h1>
	</header>

<?php if ( have_posts() ) : ?>
	<ul class="fixHeight index_list info_list result_list">
	<?php
	// Start the loop.
	while ( have_posts() ) : the_post(); ?>
	<?php
	/*
	 * Run the loop for the search to output the results.
	 * If you want to overload this in a child theme then include a file
	 * called content-search.php and that will be used instead.
	 */
	get_template_part( 'content', 'search' );

	// End the loop.
	endwhile;
	?>
	</ul>
	<?php

	if(function_exists('wp_pagenavi')) :
		echo '<div class="pagination">'."\n";
		wp_pagenavi();
		echo '</div>'."\n";

	endif;

	// If no content, include the "No posts found" template.
else :
	get_template_part( 'content', 'none' );

endif;
?>

</div><!-- /right_column -->

<div class="left_column">
	<?php get_sidebar('all');?>
</div>
<!-- /.left_column -->

<?php get_footer();?>
