<?php
$theme_path = get_stylesheet_directory_uri(); //テーマパス
$blog_path  = get_bloginfo("url"); //ブログURL
$page_url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  // 現在のページのURL

$query = array(
  'post_type'=>'series',
  'post_status'=>'publish',
  'posts_per_page'=>-1,
  'tax_query' => array(
    array(
      'taxonomy' => 'expire_category',	//タクソノミーを指定（公開終了カテゴリは非表示）
      'field' => 'slug',	//ターム名をスラッグで指定する
      'terms' => 'expired_event',	//表示したいタームをスラッグで指定
      'operator'=>'NOT IN'
    )
  )
);
$s_events = get_posts($query);
if(!empty($s_events)){
?>
<div class="side_block seriesArea">
  <h2><!--シリーズ企画-->レポート</h2>
  <div class="seriesWrapper">
  <table>
    <?php
    $set_page_id = get_id_by_slug('setting');
    $visible_culture = get_field('visible_culture', $set_page_id);
    $icn_culture = '';
    $text_culture = '';
    if($visible_culture){
      $icn_culture = get_field('icn_culture', $set_page_id);
      $text_culture = get_field('text_culture', $set_page_id);
    ?>
    <tr class="fixHeight">
    <td><a href="/culture/"><img src="<?php echo $icn_culture['url'];?>" alt="<?php echo $text_culture;?>" width="50"></a></td>
    <td><a href="/culture/"><?php echo $text_culture;?></a></td>
    </tr>
    <?php
    }
    foreach( $s_events as $s_event ){
      $s_eventID = $s_event->ID;
      $s_eventLink = get_permalink($s_eventID);
      $s_eventPostTitle = $s_event->post_title;
      $s_eventTitle = get_field('event_title', $s_eventID);
      $s_seriesName = get_field('series_name', $s_eventID);
      $s_eventThumb = get_field('icn', $s_eventID)['url'];
      if(! $s_eventThumb) $s_eventThumb = get_field('thumb', $s_eventID)['sizes']['thumbnail'];
      if(! $s_eventThumb) $s_eventThumb = $theme_path . '/images/thumb-series.jpg';
    ?>
    <tr class="fixHeight <?php if($page_url == $s_eventLink) echo 'current';?>">
    <?php if($s_eventThumb){ ?><td><a href="<?php echo $s_eventLink;?>"><img src="<?php echo $s_eventThumb;?>" alt="<?php echo $s_seriesName;?>" width="50"></a></td><?php
    }?>
    <td><a href="<?php echo $s_eventLink;?>"><?php echo $s_seriesName;?></a></td>
    </tr>
    <?php
    }
    ?>
  </table>
  </div>
</div><!-- /.reservation -->
<?php }?>
<div class="side_block reservation">
  <ul class="clearfix">
    <?php
    $downloadPageID = get_id_by_slug('download');
    $vacantPageID = get_id_by_slug('vacant');
    $faqPageID = get_id_by_slug('faq');
    $aroundPageID = get_id_by_slug('around');
    $reservArgs = array(
      'post_type' => 'page',
      'post__in' => array($downloadPageID, $vacantPageID, $faqPageID, $aroundPageID),
    );
    query_posts($reservArgs);
    if ( have_posts() ) :
    while ( have_posts() ) : the_post();
      $pageID = $post->ID;
      $pageTitle = $post->post_title;
      $pageSlug = $post->post_name;
      $pageLink = get_permalink($pageID);
      ?>
      <li><a href="<?php echo $pageLink;?>" class="arrow"><?php echo $pageTitle;?></a></li>
      <?php
    endwhile;
    endif;
    wp_reset_query();
    ?>
  </ul>
</div><!-- /.reservation -->

<?php
get_template_part( 'content-sidebanner-bottom' );
?>