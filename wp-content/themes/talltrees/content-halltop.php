<?php

/*
  各館：TOP
*/

$theme_path = get_stylesheet_directory_uri(); //テーマパス
$blog_path  = get_bloginfo("url"); //ブログURL
$page_url   = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  // 現在のページのURL

// 日付関連
$date_target = get_query_var( 'date_target' );  //もとのフォーマット
$date_format = get_query_var( 'date_format' );  //取得フォーマット
$year_format = get_query_var( 'year_format' );  //年だけ取得
$month_format = get_query_var( 'month_format' ); //月だけ取得
$today = get_query_var( 'today' );  //今日の日付

// 各館TOPの情報
$hall_slug = get_query_var( 'hall_slug' );  //スラッグ
$this_page_id = get_query_var( 'this_page_id' ); //ID
$this_page_link = get_query_var( 'this_page_link' ); //パーマリンク
$hall_image_path = get_query_var( 'hall_image_path' );  //画像パス


// イベントリスト
// --------------
$posts_args = array(
  'tax_query' => array(
    array(
      'taxonomy' => 'category', //タクソノミーを指定
      'field' => 'slug', //ターム名をスラッグで指定する
      'terms' => array( $hall_slug,'all' ), //表示したいタームをスラッグで指定
      'operator'=>'IN'
    ),
    array(
      'taxonomy' => 'expire_category',	//タクソノミーを指定（公開終了カテゴリは非表示）
      'field' => 'slug',	//ターム名をスラッグで指定する
      'terms' => 'expired_event',	//表示したいタームをスラッグで指定
      'operator'=>'NOT IN'
    ),
    'relation' => 'AND'
  ),
  'meta_query' => array(
    array(
      'key' => 'in_list',
      'value' => 1,
      'compare' => '=',
    )
  ),
  'post_type'=>'event',
  'post_status'=>'publish',
  'posts_per_page'=>-1
);
$lists = get_posts($posts_args);
if(!empty($lists)){
?>
<section>
  <h2>公演・イベント情報</h2>
  <ul class="event_list clearfix fixHeight">
    <?php
    foreach($lists as $list){
      include('content-event_block.php');
    }
    ?>
  </ul><!-- /event_list -->
</section>
<?php
}?>

<section class="column_2 clearfix">
  <?php
  // お知らせリスト
  $post_args = array(
    'tax_query' => array(
      array(
        'taxonomy' => 'category',
        'field' => 'slug',
        'terms' => array( $hall_slug,'all' )
      )
    ),
    'post_type'=>'post',
    'post_status'=>'publish',
    'posts_per_page'=>-1
  );
  $news_posts = get_posts($post_args);
  if(!empty($news_posts)){
    // お知らせ
  ?>
    <div class="column_2_inner">
      <h2>お知らせ</h2>
      <div class="info_wall">
        <ul class="info_list">
        <?php
        foreach($news_posts as $news_post){

          $tab_target = get_field('tab_target',$news_post->ID);
          $post_link = get_field('url',$news_post->ID);
          if(!$post_link){
            $post_link = get_permalink($news_post->ID);
          }

          //カテゴリ
          $sort_slug = '';
          $cat_tags = '';
          $cat_all = '総合案内';
          $cat_args = array('orderby' => 'order');
          $cat_terms = wp_get_post_terms($news_post->ID, 'category', $cat_args);
          foreach($cat_terms as $cat_term){
            $cat_slug = $cat_term->slug;
            $cat_name = $cat_term->name;

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
        <li>
          <div class="meta_block">
            <span><?php echo get_the_date('Y/n/j',$news_post->ID);?></span><?php echo $cat_tags; ?>
          </div>
          <p><a href="<?php echo $post_link;?>" <?php
          echo ($tab_target) ? 'target="_blank"' : '';?> class="arrow">
            <?php echo get_the_title($news_post->ID); ?></a></p>
        </li>
        <?php

        }?>
      </ul>
    </div>
    <!-- /.info_list -->
  </div>
  <!-- /.column_2_inner -->
  <?php }?>

  <div class="column_2_inner">
    <?php
    // 久喜総合文化会館
    if(is_page('sogobunka')){
      // プラネタリウム
      get_template_part('block-hallplaneta');

    // 菖蒲・栗橋
    }else{
      // KUKIKUKI便り
      get_template_part('block-hallblog');
    }
    ?>
  </div><!-- /.column_2_inner -->
</section><!-- /.column_2 -->

<?php
// 久喜総合文化会館
if(is_page('sogobunka')){
?>
<section class="column_2 clearfix">
  <div class="column_2_inner">
    <?php
      // プラネタリウム
      get_template_part('block-hallblog');
    ?>
  </div>
  <div class="column_2_inner">
    <?php
      // facebook timeline
      get_template_part('block-hallfb');
    ?>
  </div>
<?php
// 菖蒲・栗橋
}else{
?>
<section>
<?php
  // facebook timeline
  get_template_part('block-hallfb');
}
?>
</section>

<section class="contents_menu">
  <h2>会館インフォメーション</h2>
  <div class="column_2 clearfix fixHeight">
  <div class="column_2_inner">
    <div class="thumb"><img src="<?php echo $hall_image_path;?>/guidance_info.png" alt="" width="348" height="148"></div>
    <h3>施設のご案内</h3>
    <ul><?php echo tt_get_child_pages('outline', $this_page_id, $hall_slug, 'arrow');?></ul>
  </div>
  <!-- /.column_2_inner -->
  <div class="column_2_inner">
    <div class="thumb"><img src="<?php echo $hall_image_path;?>/guidance_how_to.png" alt="" width="348" height="149"></div>
    <h3>ご利用ガイド</h3>
    <ul><?php echo tt_get_child_pages('subscribe', $this_page_id, $hall_slug, 'arrow');?></ul>
  </div>
  <!-- /.column_2_inner -->
  <div class="column_2_inner">
    <div class="thumb"><img src="<?php echo $hall_image_path;?>/guidance_price.png" alt="" width="348" height="149"></div>
    <h3>ご利用料金</h3>
    <ul><?php echo tt_get_child_pages('price', $this_page_id, $hall_slug, 'arrow');?></ul>
  </div>
  <!-- /.column_2_inner -->
  <div class="column_2_inner">
    <div class="thumb"><img src="<?php echo $hall_image_path;?>/guidance_access.png" alt="" width="348" height="149"></div>
    <h3>交通アクセス</h3>
    <ul>
      <li><a href="<?php echo $this_page_link;?>access/#map" class="arrow">周辺地図</a></li>
      <li><a href="<?php echo $this_page_link;?>access/#transit" class="arrow">交通案内</a></li>
      <li><a href="<?php echo $this_page_link;?>access/#transit" class="arrow">駐車場</a></li>
    </ul>
  </div>
  <!-- /.column_2_inner -->
  </div>
</section>
<!-- /.column_2 -->

<section>
  <h3><a href="<?php echo $this_page_link;?>vacant/" class="arrow">施設の空き状況</a></h3>
  <p>大・小ホール、会議室など、館内施設の月毎の空き状況をご覧いただけます。</p>
</section><!-- /.column_3_inner -->
<section>
  <h3><a href="<?php echo $this_page_link;?>qa/" class="arrow">よくある質問</a></h3>
  <p>皆様からよくお問合せいただくご質問をまとめました。</p>
</section><!-- /.column_3_inner -->
<section>
  <h3><a href="<?php echo $this_page_link;?>around/" class="arrow">周辺情報</a></h3>
  <p>会館周辺の花店や写真館、コンビニエンスストアなどを紹介しております。</p>
</section><!-- /.column_3_inner -->
