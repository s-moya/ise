<?php

// template ： 公演・イベントのサイドバー

require_once "class/TtEvent.php";

?>

<nav class="nav_btn side_category_list event_year_list">
  <div class="to_parent"><a href="/event_calendar/" class="arrow">イベントカレンダー</a></div>
</nav>

<nav class="nav_category side_category_list event_year_list">
<h3 class="to_parent btn_event">
  <a href="/event/" class="arrow">公演・イベント情報</a>
</h3>
<?php

  $side_total_event_count = 0;
  $side_no_event = false;

  // 年・月
  $side_month = '';	//月
  $side_year_array = array();	//年（3年先まで取得）
  $past_year_array = array();	//年（3年先〜4年前まで取得）
  for($ahead = 0; $ahead<=3; $ahead++){
    $side_year_array[] = date_i18n('Y') + $ahead;
  }
  if(isset($_GET['month_select'])){
  	$side_month = urlencode($_GET['month_select']);	//パラメータの月を優先
  }

  $args = array(
    'pad_counts' => true,
    'hide_empty' => true
  );
  $genres = get_terms( 'genre' , $args );
  if ( count( $genres ) != 0 ) {
    foreach ( $genres as $genre ) {
      $genre = sanitize_term( $genre, 'genre' );
      $genre_id = 'genre_' . $genre->term_id;
      $genre_name = $genre->name;
      $genre_slug = $genre->slug;
      // $term_link = get_term_link( $term, $taxonomy );
      if ( is_wp_error( $genre_slug ) ) {
        continue;
      }
      $query = array(
        'post_type'=>'event',
        'post_status'=>'publish',
        'posts_per_page'=>-1,
        'tax_query' => array(
          array(
            'taxonomy' => 'expire_category',	//タクソノミーを指定（公開終了カテゴリは非表示）
            'field' => 'slug',	//ターム名をスラッグで指定する
            'terms' => 'expired_event',	//表示したいタームをスラッグで指定
            'operator'=>'NOT IN'
          ),
          'relation' => 'AND',
          array(
            'taxonomy' => 'genre',	//タクソノミーを指定（公開終了カテゴリは非表示）
            'field' => 'slug',	//ターム名をスラッグで指定する
            'terms' => $genre_slug,	//表示したいタームをスラッグで指定
            'operator'=>'IN'
          )
        )
      );
      ?>
      <dl <?php if($post_genre_slug == $genre_slug) echo 'class="nav_category_show"';?>>
      <dt class="arrow"><?php echo $genre_name;?></dt>
      <?php
      $events = get_posts($query);
      ?>
      <dd>
      <ul>
      <?php
      if( $events ){
        foreach( $events as $event ){
          $eventID = $event->ID;
          $eventLink = get_permalink($eventID);
        ?>
        <li <?php if($page_url == $eventLink) echo 'class="nav_category_current"';?>>
          <a href="<?php echo $eventLink;?>" class="arrow_simple">
          <?php echo $event->post_title;?>
          </a>
        </li>
        <?php
        }
      }else{
        ?>
        <li><?php echo $genre_name;?>情報はありません</li>
        <?php
      }
      ?>
      </ul>
      </dd>
      </dl>
      <?php
    }
  }
  ?>
</nav>
