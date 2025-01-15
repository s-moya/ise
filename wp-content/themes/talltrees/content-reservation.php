<?php

/*
  各館：施設利用受付ページ
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

// 施設利用受付
$yoyaku_hall_array = get_query_var( 'yoyaku_hall_array' );  //ホール・展示室
$yoyaku_other_array = get_query_var( 'yoyaku_other_array' );  //その他

if($yoyaku_hall_array || $yoyaku_other_array){

  $pdf_status = get_field('pdf_status', $this_page_id);	// 申し込み状況PDF

  ?>
  <article class="reservation_article">
  <h1 class="short"><?php the_title();?></h1><?php
  while ( have_posts() ) : the_post();
    the_content();
  endwhile;
  wp_reset_query();
  ?>
  <h2>申込みスケジュール</h2>
  <section class="section">
    <h3>ホール／展示室</h3>
    <p class="head_line">申込期間：利用したい日の13ヶ月前の16日～同月末日正午まで</p>
    <table class="table_2">
    <col width="10%"><col width="15%"><col width="37%"><col width="20%"><col width="18%">
    <thead>
    <tr>
      <th class="status">&nbsp;</th>
      <th>ご利用月</th>
      <th>申込期間</th>
      <th>受付用紙</th>
      <th class="mtg">利用者調整会議<br>（決定日）</th>
    </tr>
    </thead>
    <tbody><?php
    // ホール・展示室
    if(!empty($yoyaku_hall_array)){
      foreach ($yoyaku_hall_array as $yoyaku_hall){
        // 決定日（利用者調整会議）前のものを取得
        if(strtotime($yoyaku_hall['meeting']) > strtotime($today)){
          $hall_riyou = explode(' ', $yoyaku_hall['riyou']);
          $hall_riyou = tt_format_date($hall_riyou[0], 'Y年n月', $date_target, false);//利用年

          $hall_start_str 	= $yoyaku_hall['kikan_start'];
          $hall_start 			= explode(' ', $hall_start_str);	//開始日時
          $hall_start_date 	= tt_format_date($hall_start[0], $date_format, $date_target);	//開始日
          $hall_start_time 	= $hall_start[1];	//開始時間

          $hall_end_str 	= $yoyaku_hall['kikan_end'];
          $hall_end 			= explode(' ', $hall_end_str);	//終了日時
          $hall_end_date 	= tt_format_date($hall_end[0], 'n月j日', $date_target);	//終了日
          $hall_end_time 	= $hall_end[1];	//終了時間

          $hall_pdf 		= $yoyaku_hall['pdf'];
          $hall_mtg_str = explode(' ', $yoyaku_hall['meeting']);
          $hall_mtg 		= tt_format_date($hall_mtg_str[0], $date_format, $date_target);//決定日

          // 受付期間によって赤帯の文言を変更する
          if(strtotime($hall_end_str) < strtotime($today)){
            $message = '<tr class="closed">';
            $message .= '<td class="status closed">受付終了</td>';
          }else if(strtotime($hall_start_str) > strtotime($today)){
            $message = '<tr>';
            $message .= '<td class="status">&nbsp;</td>';
          }else{
            $message = '<tr class="open">';
            $message .= '<td class="status open">受付中</td>';
          }

          ?>
            <?php echo $message;?>
            <td class="table_item"><?php echo $hall_riyou;?>分</td>
            <td><?php echo $hall_start_date.' 〜 '.$hall_end_date.' '.$hall_end_time;?></td>
            <td><?php
            if($hall_pdf){
              echo '<a href="'.$hall_pdf.'" class="pdf_link" target="_blank">ダウンロード<span>PDF</span></a>';
            }
            ?></td>
            <td><?php echo $hall_mtg;?></td>
          </tr><?php
        }
      }
    }else{
      echo '<tr class="closed no_schedule">
      <td class="status closed"></td>
      <td class="table_item" colspan="4">現在予約は受け付けておりません。</td></tr>
      ';
    }
    ?>
    </tbody>
    </table>
  </section>

  <section class="section">
    <h3>会議室／練習室／和室／リハーサル室／ホール附属室</h3>
    <p class="head_line">申込期間：利用したい日の4ヶ月前の16日～同月末日正午まで</p>
    <table class="table_2">
    <col width="10%"><col width="15%"><col width="37%"><col width="20%"><col width="18%">
    <thead>
      <tr>
        <th class="status">&nbsp;</th>
        <th>ご利用月</th>
        <th>申込期間</th>
        <th>受付用紙</th>
        <th class="mtg">利用者調整会議<br>（決定日）</th>
      </tr>
    </thead>
    <tbody><?php
    // その他（会議室・練習室など）
    if(!empty($yoyaku_other_array)){
      foreach ($yoyaku_other_array as $yoyaku_other){
        // 決定日（利用者調整会議）前のものを取得
        if(strtotime($yoyaku_other['meeting']) > strtotime($today)){
          $other_riyou = explode(' ', $yoyaku_other['riyou']);
          $other_riyou = tt_format_date($other_riyou[0], 'Y年n月', $date_target, false);//年

          $other_start_str 	= $yoyaku_other['kikan_start'];
          $other_start 			= explode(' ', $other_start_str);	//開始日時
          $other_start_date = tt_format_date($other_start[0], $date_format, $date_target);	//開始日
          $other_start_time = $other_start[1];	//開始時間

          $other_end_str 	= $yoyaku_other['kikan_end'];
          $other_end 			= explode(' ', $other_end_str);	//終了日時
          $other_end_date = tt_format_date($other_end[0], 'n月j日', $date_target);	//終了日
          $other_end_time = $other_end[1];	//終了時間

          $other_pdf 			= $yoyaku_other['pdf'];
          $other_mtg_str 	= explode(' ', $yoyaku_other['meeting']);
          $other_mtg 			= tt_format_date($other_mtg_str[0], $date_format, $date_target);//決定日

          // 受付期間によって赤帯の文言を変更する
          if(strtotime($other_end_str) < strtotime($today)){
            $message = '<tr class="closed">';
            $message .= '<td class="status closed">受付終了</td>';
          }else if(strtotime($other_start_str) > strtotime($today)){
            $message = '<tr>';
            $message .= '<td class="status">&nbsp;</td>';
          }else{
            $message = '<tr class="open">';
            $message .= '<td class="status open">受付中</td>';
          }

          ?><tr>
            <?php echo $message;?>
            <td class="table_item"><?php echo $other_riyou;?>分</td>
            <td><?php echo $other_start_date.' 〜 '.$other_end_date.' '.$other_end_time;?></td>
            <td><?php
            if($other_pdf){
              echo '<a href="'.$other_pdf.'" class="pdf_link" target="_blank">ダウンロード<span>PDF</span></a>';
            }
            ?></td>
            <td><?php echo $other_mtg;?></td>
          </tr><?php
        }
      }
    }else{
      echo '<tr class="closed no_schedule">
      <td class="status closed"></td>
      <td class="table_item" colspan="4">現在予約は受け付けておりません。</td></tr>
      ';
    }
    ?>
    </tbody>
    </table>
  </section>

  <section class="section">
    <div class="column_2">
      <div class="contact_link column_2_inner">
        <h3>ご予約お申込みフォーム</h3>
        <p><?php
        // 申し込みリンクを表示するか
        $hall_contact = true;
        $other_contact = true;

        // ホール・展示室
        foreach ($yoyaku_hall_array as $yoyaku_hall){
          $hall_mtg_str = $yoyaku_hall['meeting'];
          // 決定日（利用者調整会議）が過ぎていたらスキップし、最初の1件目のみ取得
          if(strtotime($hall_mtg_str) >= strtotime($today)){
            $hall_start_str = $yoyaku_hall['kikan_start'];
            $hall_end_str = $yoyaku_hall['kikan_end'];
            break;
          }
        }
        // その他（会議室・練習室など）
        foreach ($yoyaku_other_array as $yoyaku_other){
          $other_mtg_str = $yoyaku_other['meeting'];
          // 決定日（利用者調整会議）が過ぎていたらスキップし、最初の1件目のみ取得
          if(strtotime($other_mtg_str) >= strtotime($today)){
            $other_start_str = $yoyaku_other['kikan_start'];
            $other_end_str = $yoyaku_other['kikan_end'];
            break;
          }
        }

        // ホール・展示室が期間外：false
        if(!empty($yoyaku_hall_array)){
          if(
            strtotime($hall_start_str) > strtotime($today)
            || strtotime($hall_end_str) < strtotime($today)){
              $hall_contact = false;
          }
        }else{
          $hall_contact = false;
        }
        // その他が期間外：false
        if(!empty($yoyaku_other_array)){
          if(
            strtotime($other_start_str) > strtotime($today)
            || strtotime($other_end_str) < strtotime($today)){
              $other_contact = false;
          }
        }else{
          $other_contact = false;
        }

        // 両方期間外：リンク非表示
        if(!$hall_contact && !$other_contact){
          echo '<a href="" class="btn_contact btn_closed">現在はお申込み期間外です</a>';
        }else{
          ?>
            <!-- <a href="/<?php echo $hall_slug;?>/reservation_form/" class="btn_contact" onclick="window.open('/<?php echo $hall_slug;?>/reservation_form/','','width=650,height=700,toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes');return false;"><span class="arrow">お問い合わせする</span></a> -->
          <?php
          echo '<a href="/'.$hall_slug.'/reservation_form/" target="_blank" class="btn_contact"><span class="arrow external_link">お申込みフォーム</span></a>';
        }
        ?></p>
        <ul class="notes">
          <li>※ご利用されたい施設の提出期間中の申込みのみ有効となります。</li>
          <li>※その期間外に送信されたお申込みに関しては無効となります。ご了承ください。</li>
        </ul>
      </div>

      <div class="contact_link column_2_inner">
        <h3>申込み状況</h3>
        <?php
        if($pdf_status){
        ?>
        <p class="pdf_status">
          <a href="<?php echo ($pdf_status) ? $pdf_status : '';?>" target="_blank" class="arrow pdf_link">申込み状況<span>PDF</span></a><span><?php

          $pdf_date = get_field('pdf_date',$this_page_id);
          $pdf_date = tt_format_date($pdf_date, 'n/j', $date_target, false);//更新日
          echo '（'.$pdf_date.' 現在）';

          ?></span>
        </p>
        <?php
        }
        ?>
        <ul class="notes">
          <li>※最新の情報についてはお電話にてお問い合わせください。</li>
        </ul>
      </div>
    </div>
  </section>

  </article>
<?php
}else{
  ?>
  <article class="reservation_article">
  <h1 class="short"><?php the_title();?></h1>
  <?php
  while ( have_posts() ) : the_post();
    the_content();
  endwhile;
  wp_reset_query();
  ?>
  <p><strong>現在予約は受け付けておりません。<br>
    受付開始までお待ちください。
  </strong></p>
  </article>
  <?php
}
