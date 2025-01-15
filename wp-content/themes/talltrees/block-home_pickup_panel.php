<?php
foreach($pickup_set as $pickup){
  $kijiObj = $pickup['kiji'];
  $pickupID = $kijiObj->ID;
  $label = $pickup['label'];
  $subtitle = $pickup['subtitle'];
  $title = $kijiObj->post_title;
  $url = get_permalink($pickupID);
  $limit = get_field('limit',$pickupID);
  $thumb = get_field('thumb',$pickupID)['sizes']['pickup'];
  if(!$thumb){
    $thumb = '/image-nowprinting.jpg';
  }
  $schedule_dates = array();
  $schedule = '';
  $schedule_array = get_field('schedule', $pickupID);

  if(!empty($schedule_array)){
    $schedule_year_array = array();
    foreach($schedule_array as $schedule){
      $schedule_year = new DateTime($schedule['date']); // 開催日
      $schedule_year = $schedule_year->format('Y');

      $format_style = 'n月j日';
      if ( !in_array($schedule_year, $schedule_year_array) ) {
        $schedule_year_array[] = $schedule_year;
        $format_style = 'Y年n月j日';
      }
      $schedule_date = tt_format_date($schedule['date'], $format_style, '');

      $is_holiday = $schedule['is_holiday'];  // 祝日表示
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

  //チケットの状態
  $cat_args = array();
  $ticket_tags = '';
  $ticket_terms = wp_get_post_terms($pickupID, 'ticket', $cat_args);
  foreach($ticket_terms as $ticket_term){
    $ticket_slug = $ticket_term->slug;
    $ticket_name = $ticket_term->name;

    // タグの色を取得する
    $tag_id = 'ticket_'.$ticket_term->term_id;
    $tag_color = '';
    $tag_color_num = get_field('tag_color', $tag_id);
    if($tag_color_num){
      $tag_color = 'style="background-color:'.$tag_color_num.'; border-color:'.$tag_color_num.';"';
    }

    if($ticket_term === end($ticket_terms)){
      $ticket_tags .= '<span class="tag-ticket tag-'.$ticket_slug.'"'.$tag_color.'>'.$ticket_name.'</span>'."\n";
    }else{
      $ticket_tags .= '<span class="tag-ticket tag-'.$ticket_slug.'"'.$tag_color.'>'.$ticket_name.'</span>';
    }
  }

  ?>
  <li>
    <a href="<?php echo $url;?>">
    <div class="panelWrapper clearfix">
    <div class="label label-<?php echo $label;?>">UP COMMING</div>
    <div class="thumb"><img src="<?php echo $thumb;?>" alt="<?php echo $title;?>"></div>
    <div class="detail">
      <?php if($subtitle) ?><p class="catchCopy"><?php echo $subtitle;?></p>
      <p class="eventTitle"><?php echo $title;?></p>
      <div class="metaInfo clearfix">
        <p class="date"><?php echo $schedule;?></p>
        <p class="status"><?php echo $ticket_tags;?></p>
      </div>
    </div>
    </div>
    </a>
  </li>
  <?php
}
?>
