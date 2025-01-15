<?php
/*
template : taxonomy genre
*/

get_header();
// get_template_part( 'content-topicpath_title', get_post_format() );

$hall_slug = '';	// 開催館slug
$post_genre_slug = '';	// ジャンルslug
$param_hall_name = '';	// 開催館名
$cat_all = '合同開催'; // allが選択された場合はのカテゴリ名

$theme_path = get_stylesheet_directory_uri(); //テーマパス
$blog_path  = get_bloginfo("url"); //ブログURL
if(get_post_type_object(get_post_type())){
  $post_obj   = get_post_type_object(get_post_type());
  $post_type  = $post_obj->name; //ポストタイプ
  $post_type_label = $post_obj->label; //ポストタイプ名
}else if(is_archive('event')){
  $post_type  = 'event'; //ポストタイプ
}
$page_url   = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  // 現在のページのURL

if(is_tax()){
	$taxonomy = $wp_query->get_queried_object();
	$taxonomy_name = esc_html($taxonomy->name);;
	$post_genre_slug = $taxonomy->slug;
}

if(isset($_GET['hall'])) {
  $hall_slug = $_GET['hall'];
	$hall_args = array(
		'slug'=>$hall_slug,
    'hide_empty'=>false
	);
	$param_hall_obj = get_terms('category',$hall_args)[0];
	$param_hall_name = $param_hall_obj->name;
	if($hall_slug == 'all'){
		$param_hall_name = $cat_all;
	}

	// 施設ごとに色分け
	switch($hall_slug){
    case 'sogobunka':
      $page_color = 'sogobunka';
      break;
    case 'amigo':
      $page_color = 'amigo';
      break;
    case 'iris':
      $page_color = 'iris';
      break;
	}
}

global $wp_query;
$query = $wp_query->query;
?>

	<div class="right_column">
    <header class="contentsHeader">
			<h1>公演･イベント情報</h1>
		</header>
    <div class="eventLinkTabs">
  		<ul class="clearfix">
  			<li><a href="/event_calendar/"><span>イベントカレンダー</span></a></li>
  			<li><a href="/event/" class="current"><span>公演･イベント情報</span></a></li>
  		</ul>
  	</div>
		<?php
    $post_args = array_merge(
      $query,	array(
        'posts_per_page' => -1,
        'meta_query' => array(
          array(
            'key' => 'in_list',
            'value' => 1,
            'compare' => '=',
          )
        ),
        'tax_query' => array(
          array(
            'taxonomy' => 'expire_category',	//タクソノミーを指定（公開終了カテゴリは非表示）
            'field' => 'slug',	//ターム名をスラッグで指定する
            'terms' => 'expired_event',	//表示したいタームをスラッグで指定
            'operator'=>'NOT IN'
          )
        )
      )
    );
		?>
    <ul class="event_list_archive">
    <?php
    $wp_query = new WP_Query($post_args);
    query_posts($wp_query->query);
		if ( have_posts() ) :
			// Start the Loop.
			while ( have_posts() ) : the_post();
				$list = $post;
        $schedules_array = get_field('schedule');
        foreach($schedules_array as $schedules){
        }
        // var_dump(get_field('in_list'));
				include('content-event_block.php');
			endwhile;
		else :
		?>
		<li class="no_posts">該当の公演・イベント情報はありません</li>
		<?php
		endif;
		?>
    </ul>
    <?php
		if( function_exists('wp_pagenavi') ) {
      // echo '<div class="pagination">'."\n";
			// wp_pagenavi();
      // echo '</div>'."\n";
		}

		?>
    <div class="calendarNavBottom">
      <ul class="smallEventList">
      <?php
      $eventListquery = array(
        'post_type'=>'event',
        'post_status'=>'publish',
        'posts_per_page'=>-1,
        'meta_query' => array(
          array(
            'key' => 'in_list',
            'value' => 1,
            'compare' => '=',
          )
        ),
        'tax_query' => array(
          array(
            'taxonomy' => 'expire_category',	//タクソノミーを指定（公開終了カテゴリは非表示）
            'field' => 'slug',	//ターム名をスラッグで指定する
            'terms' => 'expired_event',	//表示したいタームをスラッグで指定
            'operator'=>'NOT IN'
          )
        )
      );
      $eventLists = get_posts($eventListquery);
      foreach( $eventLists as $eventList ){
        $eventID = $eventList->ID;
        $eventLink = get_permalink($eventID);
      ?>
      <li><a href="<?php echo $eventLink;?>" class="arrow"><?php echo $eventList->post_title;?></a></li>
      <?php
      }
      ?>
      </ul>
      <div class="eventLinkTabs">
    		<ul class="clearfix">
    			<li><a href="/event_calendar/"><span>イベントカレンダー</span></a></li>
    			<li><a href="/event/" class="current"><span>公演･イベント情報</span></a></li>
    		</ul>
    	</div>
    </div><!-- /.calendarNavBottom -->
	</div>
  <div class="left_column">
  <?php include('sidebar-posts.php');?>
  </div>
  <!-- /.left_column -->

	<?php get_footer(); ?>
