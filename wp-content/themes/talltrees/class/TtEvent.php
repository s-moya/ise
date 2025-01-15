<?php
class TtEvent
{
  // プロパティの宣言
  public $postId; // Number
  public $menuOrder; // Number
  public $title;  // String
  public $copy;   // String
  public $url;    // String
  public $thumb;   // String
  public $inList;   // bool

  public $limit;  // String
  public $limitType;  // Number multi:1 single:2 continue:3
  public $limitTypeFirstDay;  // Number continue:1 multi:2 single:3
  private $scheduleArray; // Array
  public $schedules; // Array includes some Date()
  public $targetDate; // DateTime

  public $isHoliday;   // bool (祝日)

  public $labels_array = array();

  public $catTerms;   // Array
  public $ticketTerms;// Array
  public $genreTerms; // Array
  public $labelTerms; // Array

  public $time;     // String
  public $price;    // String
  public $syusai;   // String

  public $contact;   //string
  public $remark;    //string

  public $expired;         //Array

  public $hallPlaces;     // Array
  public $hall_select_obj;

  public $places;  // Array

  private $order = array('orderby' => 'order');

  // メソッドの宣言
  public function __construct($post) {
    $this->postId = $post->ID;
    $this->title = get_field('event_title', $this->postId);
    if(!$this->title){
      $this->title = $post->post_title;
    }
    $this->menuOrder = $post->menu_order;
    $this->copy = get_field('copy', $this->postId);
    $this->url = get_permalink($this->postId);
    $this->inList = get_field('in_list', $this->postId);
    $this->thumb = get_field('thumb', $this->postId)['url'] ? : '/image-nowprinting.jpg';
    $this->limit = get_field('limit', $this->postId);
    $this->time = get_field('time', $this->postId);
    $this->price = get_field('price', $this->postId);
    $this->syusai = get_field('detail_syusai', $this->postId);
    $this->contact = get_field('contact', $this->postId);
    $this->remark = get_field('remark', $this->postId);

    $this->expired = get_the_terms($this->postId, 'expire_category');

    $this->places = get_field('place', $this->postId);

    $this->catTerms = wp_get_post_terms($this->postId, 'category', $this->order);
    $this->ticketTerms = wp_get_post_terms($this->postId, 'ticket', $this->order);
    $this->genreTerms = wp_get_post_terms($this->postId, 'genre', $this->order);
    $this->labelTerms = wp_get_post_terms($this->postId, 'labels', $this->order);

    $this->schedules = array();
    $this->isHoliday = '';

    $scheduleArray = get_field('schedule', $this->postId);
    if(! empty($scheduleArray)){

      // $limitによって変わる。continueのときは、fromdate,todateになる
      if($this->limit == 'continue'){

        $scheduleSortList = array();
        foreach($scheduleArray as $schedule){
          $scheduleSortList[] = new DateTime($schedule['date']);
          $formated_schedule = DateTime::createFromFormat('Ynd', $schedule['date']);
          $formated_schedule_date = $formated_schedule->format('Y-m-d');
          $this->isHoliday = ($schedule['is_holiday']) ? 'holiday' : '';
          if ($this->isHoliday) set_holiday($formated_schedule_date);
        }

        $startDatetime = min($scheduleSortList);
        $endDatetime = max($scheduleSortList);

        $startDateMonth = tt_format_date($scheduleArray[0]['date'], 'n', '', false);
        $endDateMonth = tt_format_date($scheduleArray[1]['date'], 'n', '', false);
        $startDateYear = tt_format_date($scheduleArray[0]['date'], 'Y', '', false);
        $endDateYear = tt_format_date($scheduleArray[1]['date'], 'Y', '', false);


        $this->limitType = 3;

        // ついたち：開始日と終了日で月または年をまたぐ場合
        if($startDateMonth < $endDateMonth || $startDateYear < $endDateYear){
          $this->limitTypeFirstDay = 1;
        }else{
          $this->limitTypeFirstDay = 4;
        }

        $diffDay = $endDatetime->diff($startDatetime, true)->format('%a');
        for($addDay = 0; $addDay <= $diffDay; $addDay++){
          $cloneStartDatetime = clone $startDatetime;
          $this->schedules[] = $cloneStartDatetime->modify('+' . $addDay .' days');
        }

      }
      else{

        if($this->limit == 'single'){
          $this->limitType = 2;
          $this->limitTypeFirstDay = 3; // ついたち
        }else{
          $this->limitType = 1;
          $this->limitTypeFirstDay = 2; // ついたち
        }

        foreach($scheduleArray as $schedule){
          $this->schedules[] = new DateTime($schedule['date']);
          $formated_schedule = DateTime::createFromFormat('Ynd', $schedule['date']);
          $formated_schedule_date = $formated_schedule->format('Y-m-d');
          $this->isHoliday = ($schedule['is_holiday']) ? 'holiday' : '';
          if ($this->isHoliday) set_holiday($formated_schedule_date);
        }
      }
    }

  }

  /*
   * @return String
   */
  public function getCatTags(){
    foreach($this->catTerms as $cat_term){
      $cat_slug = $cat_term->slug;
      $cat_name = $cat_term->name;
      if($cat_slug == 'all'){
        $cat_name = '合同開催';
      }
      // $cat_tags .= '<span class="tag tag-'.$cat_slug.'">'.$cat_name.'</span>';
      if($cat_term === end($this->catTerms)){
        $cat_tags .= '<span class="tag tag-'.$cat_slug.'">'.$cat_name.'</span>'."\n";
      }else{
        $cat_tags .= '<span class="tag tag-'.$cat_slug.'">'.$cat_name.'</span>';
      }
    }
    return $cat_tags;
  }

  /*
   * @return String
   */
  public function getTicketTags(){
  }

  /*
   * @return String
   */
  public function getGenreTags(){
  }

  /*
   * @return String
   */
  public function getLabelTags(){
    $labels_name = '';
    $labels_tags = '';
    $labels_array = '';

    // $labels_terms = wp_get_post_terms($post_id, 'labels', $cat_args);
    foreach($this->labelTerms as $labels_term){
    	$labels_slug = $labels_term->slug;
    	$labels_name = $labels_term->name;

      $this->labels_array[] .= $labels_slug;

    	$labels_tags .= '<span class="tag tag-ticket tag-'.$labels_slug.'">'.$labels_name.'</span>';
    }
    return $labels_tags;
  }

  public function getScheduleTxt(){
    // 開催日の種類によって出力を変更
    switch($this->limit){
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
    return print_r($this->schedules, true);
  }

  /*
   * @return String
   */
  public function getContact(){
    $contact = $this->contact;
    return $contact;
  }

  // 会場を取得
  public function getPlace(){

    $place = '';

		// 会場を取得
		$places_obj = get_field_object('place', $this->postId);	// 会場obj
		$places_select_value = $places_obj['value'];	// 会場selected
		$place_num = count($places_select_value);	// 会場selected数

		if(!empty($places_select_value)){
			foreach($places_select_value as $places_select){
        if($places_select == 'other'){
          $places_name = get_field_object('place_other', $this->postId)['value'];
        }else{
          $places_name = $places_obj['choices'][$places_select]; // 会場名
        }

				if($places_select === end($places_select_value)){
					$place .= $places_name.'<br>';
				}else{
					$place .= $places_name.'、';
				}
			}
		}

    return $place;
  }

  // tr th td を表示
  public function getOpenHtml($targetDate){
    $html =
'
    <tr>'."\n";
    $html .=
'     <th>';
    $html .= $this->setScheduleFormat($this->limit,$targetDate). '</th>'."\n";
    $html .=
'     <td>'."\n";
    return $html;
  }

  // /td /tr を表示
  public function getCloseHtml(){
    $html =
    '
          </td>
        </tr>
    ';
    return $html;
  }


  // イベント内容を表示
  public function getHtml($targetDate, $event_count_exceptContinue){
    // var_dump($this->getScheduleTxt());

    $postTitle = $this->title;

    // 詳細ページを表示　にチェックされてたらリンクを表示
    if($this->inList === true && empty($this->expired)){
      $postTitle = '<a href="'.$this->url .'">' . $postTitle . '</a>';
    }

    $html = "";
    $html .=
'       <div class="detail">
          <div class="meta_block clearfix">
';
    $html .=
'           <h3>';
    $html .= $postTitle;
    $html .= '</h3>
';
    $html .= ($this->labelTerms) ? '<span class="labels_container">'.$this->getLabelTags().'</span>
' : '';
    $html .= '</div>
';
    $html .=
'
          <dl class="clearfix fixHeight detail_info">
';
    $html .= ($this->time) ?'
            <dt>時間<span>：</span></dt>
            <dd>'.$this->time.'</dd>' : '';
    $html .= ($this->places) ?'
            <dt>会場<span>：</span></dt>
            <dd>'.$this->getPlace().'</dd>' : '';
    $html .= ($this->price) ?
'
            <dt>入場料等<span>：</span></dt>
            <dd>'.$this->price.'</dd>' : '';
    $html .= ($this->syusai) ?
'
            <dt>主催<span>：</span></dt>
            <dd class="syusai">'.$this->syusai.'</dd>' : '';
    $html .= ($this->contact) ?
'
            <dt>お問い合わせ<span>：</span></dt>
            <dd>'.$this->contact.'</dd>' : '';
    $html .= ($this->remark) ?
'
            <dt>備考<span>：</span></dt>
            <dd>'.$this->remark.'</dd>' : '';
    $html .= (!$this->time && !$this->price && !$this->syusai && !$this->contactTarget && !$this->remark) ?
'
            <dt>&nbsp;<br><br></dt>
            <dd>&nbsp;<br><br></dd>' : '';
$html .=
'
          </dl>
        </div>
        <!-- /.detail -->';
    return $html;
  }

  /*
   * @param $dateTime DateTime
   * @return bool
   */
  public function isExistInDate($dateTime){
    foreach($this->schedules as $schedule){
       if($dateTime->format('Y-m-d') == $schedule->format('Y-m-d')){
         return true;
       }
    }
    return false;
  }


  /*
   * @return bool
   */
  public function isExistInDate_side($dateTime, $nowMonth){
    // 今月より前の月はリンクを表示させないようにする
    if($dateTime >= $nowMonth){
      foreach($this->schedules as $key => $schedule){
        if($dateTime->format('Ym') == $schedule->format('Ym')){
          return true;
        }
      }
    }
    return false;
  }

  /*
   * @return bool
   * 過去のリンクも記事が入っていたら表示する
   */
  public function isExistInDate_withPastSchedule($dateTime, $nowMonth){
    foreach($this->schedules as $key => $schedule){
      if($dateTime->format('Ym') == $schedule->format('Ym')){
        return true;
      }
    }
    return false;
  }

  //  開始日・終了日を取得／表示
  public function setScheduleFormat($dateLimit, $targetDate){
    $format_style = 'j日';

    $schedule_dates = array();
    $schedule_dates_multi = array();
    $schedule_dates_continue = array();
    $schedule_array = get_field('schedule',$this->postId);

    // 飛び石日程：$targetDateと一致する日付を1つずつ出す
    if($dateLimit == 'multi'){
      foreach($schedule_array as $schedule){
        // $schedule_dates_multi[]  = $schedule['date'];
        $formated_schedule_date = tt_format_date($schedule['date'], 'Y-m-d', 'Ymd', false);
        $is_holiday = get_holiday($formated_schedule_date);
        if(tt_format_date($targetDate, 'Ymd', 'Y-n-j', false) == $schedule['date']){
          $schedule_dates[] = tt_format_date($schedule['date'], $format_style, '', true, $is_holiday);
        }
      }
      // foreach($schedule_dates_multi as $schedule_date_multi){
      //   if(tt_format_date($targetDate, 'Ymd', 'Y-n-j', false) == $schedule_date_multi){
      //     $schedule_dates[] = tt_format_date($schedule_date_multi, $format_style, '');
      //   }
      // }

    // 連続日程：
    // 開始月or終了月が閲覧月と異なる場合はn月j日として表示する
    // 開始年or終了年が閲覧年と異なる場合はY年n月j日として表示する
    }else if($dateLimit == 'continue'){
      $targetMonth = date_i18n('n');  // 月
      if(isset($_GET['month_select'])){
        $targetMonth = urlencode($_GET['month_select']);  //パラメータの月を優先
      }
      $targetYear = date_i18n('Y'); // 年
      if(isset($_GET['year_select'])){
        $targetYear = urlencode($_GET['year_select']);  //パラメータの年を優先
      }
      foreach($schedule_array as $schedule){
        // $schedule_dates_continue[] = $schedule['date'];
        $eventMonth = tt_format_date($schedule['date'], 'n', '', false);
        $eventYear = tt_format_date($schedule['date'], 'Y', '', false);
        $format_style = 'j日';
        if($targetMonth != $eventMonth){
          $format_style = 'n月j日';
        }
        if($targetYear != $eventYear){
          $format_style = 'Y年n月j日';
        }

        $formated_schedule_date = tt_format_date($schedule['date'], 'Y-m-d', 'Ymd', false);
        $is_holiday = get_holiday($formated_schedule_date);
        $schedule_dates[] = tt_format_date($schedule['date'], $format_style, '', true, $is_holiday);
      }
      // foreach($schedule_dates_continue as $schedule_date_continue){
      //   $eventMonth = tt_format_date($schedule_date_continue, 'n', '', false);
      //   $eventYear = tt_format_date($schedule_date_continue, 'Y', '', false);
      //   $format_style = 'j日';
      //   if($targetMonth != $eventMonth){
      //     $format_style = 'n月j日';
      //   }
      //   if($targetYear != $eventYear){
      //     $format_style = 'Y年n月j日';
      //   }
      //   $schedule_dates[]  = tt_format_date($schedule_date_continue, $format_style, '');
      // }

    }else{
      foreach($schedule_array as $schedule){
        $formated_schedule_date = tt_format_date($schedule['date'], 'Y-m-d', 'Ymd', false);
        $is_holiday = get_holiday($formated_schedule_date);
        $schedule_dates[] = tt_format_date($schedule['date'], $format_style, '', true, $is_holiday);
      }
    }

    // 開催日の種類によって出力を変更
    switch($this->limit){
      // case 'multi':
      //   $glue	= ' ･ ';
      //   break;
      case 'continue':
        $glue	= ' 〜<br>';
        break;
      default :
        $glue	= ' ';
        break;
    }
    $set_schedule = implode($glue,$schedule_dates);
    return $set_schedule;

  }

  //日付の種類取得（continue, multi, single）
  public function getLimit(){
    return get_field('limit', $this->postId);
  }

  //postID取得
  public function getPostID(){
    return $this->postId;
  }

  // post 比較
  // public function cmpEvent( $a , $b){
  //   $cmp = strcmp( $a->limitType , $b->limitType ); //limit type を比較
  //   if( $cmp == 0 ){
  //     $cmp = strcmp( $a->postID , $b->postID ) ; //同じならpost id を比較
  //   }
  //   return $cmp;
  // }
  //
  // public function usortEvent($eventObj){
  //   usort($eventObj, $this->cmpEvent());
  // }
}
