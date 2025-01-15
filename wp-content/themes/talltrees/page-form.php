<?php
/**
Template Name: フォーム
*/

get_header();

// while ( have_posts() ) : the_post();
// the_content();
// // End the loop.
// endwhile;
?>
<div class="contentWrapper">
<div class="container clearfix page_form single_page">
<div class="primary">
<div class="right_column no_float">
	<?php
	while ( have_posts() ) : the_post();
	?>
	<header class="contentsHeader">
		<h2>
			<?php
				$topLevelPage ='';
				$topLevelPage = get_most_parent_page($post->ID)->post_title;
				if($post->post_title != $topLevelPage) echo '<span class="categName">' . $topLevelPage . '</span>';
			?>
			<?php the_title();?>
		</h2>
	</header>

	<div class="free_area">
	<?php
	the_content();
	?>
	</div>
	<?php endwhile;?>

</div><!-- /right_column -->
</div>
</div>
</div>

<?php
get_footer();
