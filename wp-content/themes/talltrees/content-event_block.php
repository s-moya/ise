<?php

// if($list){
//   $post_id = $list->ID; // 記事ID
// }else{
//   $post_id = $post->ID; // 記事ID
// }

if($list){
  $post = $list; // 記事ID
}
$post_id = $post->ID; // 記事ID
// var_dump($post->post_modified);

$title = get_field('event_title', $post_id);
if(!$title){
  $title = get_the_title($post_id);
}
$copy = get_field('copy',$post_id);
$limit = get_field('limit',$post_id);
$url = get_permalink($post_id);
$thumb = get_field('thumb',$post_id)['url'];
if(!$thumb){
  $thumb = '/image-nowprinting.jpg';
}
$date_single = '';
$date_start = '';
$date_end = '';
$cat_args = array('orderby' => 'order');
$cat_tags = '';
$ticket_tags = '';

// 日付フォーマット指定
if(is_front_page('index')){
  $format_style = 'Y/n/j';
} else if ($post_type != 'page' && (is_tax() || is_archive())){
  $format_style = 'Y年n月j日';
} else {
  $format_style = 'n月j日';
}

// 日付を取得
$schedule_dates = array();
$schedule = '';
$schedule_array = get_field('schedule', $post_id);
$schedule_year_array = array();

if(!empty($schedule_array)){
  foreach($schedule_array as $schedule){
    $schedule_year = new DateTime($schedule['date']); // 開催日
    $schedule_year = $schedule_year->format('Y');

    $format_style = 'n月j日';
    if ( !in_array($schedule_year, $schedule_year_array) ) {
      $schedule_year_array[] = $schedule_year;
      $format_style = 'Y年n月j日';
    }
    $schedule_date = tt_format_date($schedule['date'], $format_style, '');

    $is_holiday = $schedule['is_holiday'];
    if( $is_holiday ) {
      $schedule_date = str_replace( ')', '･祝)', $schedule_date ); // 祝日表示
    }

    $schedule_dates[] = $schedule_date;

  }
  // 開催日の種類によって出力を変更
  switch($limit){
    case 'multi':
      $glue	= ', ';
      break;
    case 'continue':
      $glue	= ' 〜 ';
      break;
    default :
      $glue	= ' ';
      break;
  }
  $schedule = implode($glue,$schedule_dates);
}


//カテゴリ
$cat_terms = wp_get_post_terms($post_id, 'category', $cat_args);
foreach($cat_terms as $cat_term){
  $cat_slug = $cat_term->slug;
  $cat_name = $cat_term->name;
  if($cat_slug == 'all'){
    $cat_name = '合同開催';
  }
  // $cat_tags .= '<span class="tag tag-'.$cat_slug.'">'.$cat_name.'</span>';
  if($cat_term === end($cat_terms)){
    $cat_tags .= '<span class="tag tag-'.$cat_slug.'">'.$cat_name.'</span>'."\n";
  }else{
    $cat_tags .= '<span class="tag tag-'.$cat_slug.'">'.$cat_name.'</span>';
  }
}

//チケットの状態
$ticket_terms = wp_get_post_terms($post_id, 'ticket', $cat_args);
foreach($ticket_terms as $ticket_term){
  $ticket_slug = $ticket_term->slug;
  $ticket_name = $ticket_term->name;

  // タグの色を取得する
  $tag_id = 'ticket_'.$ticket_term->term_id;
  $tag_color = '';
  $tag_color_num = get_field('tag_color', $tag_id);
  if($tag_color_num){
    $tag_color = 'style="border-color:'.$tag_color_num.'; color:'.$tag_color_num.';"';
  }

  if($ticket_term === end($ticket_terms)){
    $ticket_tags .= '<span class="tag-ticket tag-'.$ticket_slug.'"'.$tag_color.'>'.$ticket_name.'</span>'."\n";
  }else{
    $ticket_tags .= '<span class="tag-ticket tag-'.$ticket_slug.'"'.$tag_color.'>'.$ticket_name.'</span>';
  }
}

//ジャンル
$genre_terms = wp_get_post_terms($post_id, 'genre', $cat_args);
$genre_data = '';
foreach($genre_terms as $genre_term){
  $genre_slug = $genre_term->slug;
  $genre_name = $genre_term->name;
  $genre_id = $genre_term->term_id;
  $genre_data .= ' genre_'.$genre_id;
}

// 総合TOP || 各館TOPのループ
// -------------------------------------------------------
if(is_front_page('index') || is_page_template('page-hall.php')){
?>

  <li class="clearfix<?php echo $genre_data;?>">
  <div class="thumb"><a href="<?php echo $url;?>"><img src="<?php echo $thumb;?>" alt="">
  <?php
  // NEW・UPDATEをそれぞれ**日間だけ表示
  $hide_baloon = get_field('hide_baloon');  //baloonを表示するかどうか
  $modified = false; //更新したかどうかのフラグ
  $visibleDays = $mark_days; //○日間表示
  $today = (int) date_i18n('U');
  $entry = (int) get_the_time('U', $post_id);
  $update = (int) get_the_modified_time('U', $post_id);	// 最終日の更新日
  $elapsed = (float)($today - $entry) / 86400.0;
  $elapsed_update = (float)($today - $update) / 86400.0;
  if(!$hide_baloon){
    if( $visibleDays > $elapsed ){ ?>
      <div class="bl bl-new">NEW</div>
    <?php
    }else if ( $visibleDays > $elapsed_update ){
      $modified = true;
    ?>
      <div class="bl bl-update">UPDATE</div>
    <?php
    }
  }
  ?>
  </a>
  </div>
  <div class="detail">
    <?php echo $cat_tags;?>
    <span class="date"><?php echo $schedule;?></span>
    <h3><a href="<?php echo $url;?>"><?php echo $title;?></a></h3>
    <?php echo $ticket_tags;?>
    <?php
    // echo ($modified) ? '<span>get_the_modified_date' .get_the_modified_time('Y-m-d H:i:s', $list->ID). '</span>' : '' ;
    // echo ($modified) ? '<span>最終' .$list->post_modified. '</span>' : '' ;
    ?>
  </div>
  </li>
<?php


// 固定ページ以外 カテゴリかアーカイブページのループ
// -------------------------------------------------------
} else if ( $post_type != 'page' && (is_tax() || is_archive()) ){

  // $title = str_replace('<br>', '', $list->post_title);

  // ラベル（主催・共催など）
  $labels_name = '';
  $labels_tags = '';
  $labels_terms = wp_get_post_terms(get_the_ID(), 'labels', $cat_args);
  foreach($labels_terms as $labels_term){
  	$labels_slug = $labels_term->slug;
  	$labels_name = $labels_term->name;
  	$labels_tags .= '<span class="tag tag-ticket tag-'.$labels_slug.'">'.$labels_name.'</span>';
  }

  // キャッチコピー
  $copy = get_field('copy');
  $time = get_field('time');
  $ticket_release = get_field('ticket_release');

?>

<li class="clearfix<?php echo $genre_data;?>">
  <div class="meta_block clearfix">
  <p class="date"><?php echo $schedule;?></p>
  <span class="labels_container">
    <?php echo $labels_tags;?>
  </span>
  </div>
  <!-- /.meta_block -->
  <div class="deteil_container clearfix">
    <div class="detail">
      <p class="date spText"><?php echo $schedule;?></p>
      <h3><a href="<?php echo $url;?>" class="arrow"><?php echo $title;?></a></h3>
      <p class="catch_copy"><?php echo $copy;?></p>
      <?php
      if($time){?>
      <table>
        <tr>
          <th>時間</th>
          <td class="free_area"><?php echo $time;?></td>
        </tr>
      </table>
      <?php }
      if($ticket_release){?>
      <dl class="clearfix fixHeight">
        <dt>発売日</dt>
        <dd><?php echo $ticket_release;?></dd>
      </dl>
      <?php }?>
      <span class="labels_container spText">
        <?php echo $labels_tags;?>
      </span>
    </div>
    <!-- /.detail -->
    <div class="thumb"><a href="<?php echo $url;?>">
      <img src="<?php echo $thumb;?>" alt=""></a>
    </div>
  </div>
  <!-- /.deteil_concontainer -->

</li>
<?php
}
?>
