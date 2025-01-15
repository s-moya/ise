<?php

// 各館固定ページのサイドバー

$sidebar_title = '';
$theme_path = get_stylesheet_directory_uri(); //テーマパス
$blog_path  = get_bloginfo("url"); //ブログURL
$page_url   = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  // 現在のページのURL

// if(is_page_template('page-hall.php') || is_page_template('page-planetarium.php')){
$par_post = get_most_parent_page();
$par_page_slug = $par_post->post_name;
$par_page_title = $par_post->post_title;
$par_page_id = $par_post->ID;
// }

$this_page_cat = get_field('cat_page'); // カスタムフィールドでページカテゴリを追加
$this_page_slug = get_page_slug(get_the_ID()); // 現在のページスラッグ

?>
<aside>
<?php

// 各館ページ
// ------------------------------------------------------
if( is_page_template('page-hall.php') ){
?>
<nav class="nav_category">
  <h3><a href="/<?php echo $par_page_slug;?>/"><?php echo $par_page_title;?></a></h3>
  <dl <?php if ($this_page_cat == 'outline') echo ' class="nav_category_show"';?>>
    <dt class="arrow">施設のご案内</dt>
    <dd>
    <ul><?php echo tt_get_child_pages('outline', $par_page_id, $this_page_slug);?></ul>
    </dd>
  </dl>
  <?php if(tt_get_child_pages('ticket', $par_page_id, $this_page_slug)){?>
  <dl><?php
    $child_page_args = array(
      'post_type'=>'page', 'orderby'=>'order', 'posts_per_page'=>-1, 'post_parent'=>$par_page_id,
      'meta_query'=>array(
        array('key'=>'cat_page', 'value'=>'ticket', 'compare'=>'==', 'type'=>'CHAR')
      )
    );
    $child_page_array = get_posts($child_page_args);
    foreach($child_page_array as $child_page){?>
      <dt class="has_link"><a href="<?php echo get_permalink($child_page->ID);?>" class="arrow">
        <?php echo get_the_title($child_page->ID);?></a></dt>
    <?php }?>
  </dl>
  <?php }?>
  <dl<?php if ($this_page_cat == 'subscribe') echo ' class="nav_category_show"';?>>
    <dt class="arrow">ご利用ガイド</dt>
    <dd>
      <ul><?php echo tt_get_child_pages('subscribe', $par_page_id, $this_page_slug);?></ul>
    </dd>
  </dl>
  <dl<?php if ($this_page_cat == 'price') echo ' class="nav_category_show"';?>>
    <dt class="arrow">ご利用料金</dt>
    <dd>
      <ul><?php echo tt_get_child_pages('price', $par_page_id, $this_page_slug);?></ul>
    </dd>
  </dl>
  <dl><?php
    $child_page_args = array(
      'post_type'=>'page', 'orderby'=>'order', 'posts_per_page'=>-1, 'post_parent'=>$par_page_id,
      'meta_query'=>array(
        array('key'=>'cat_page', 'value'=>'access', 'compare'=>'==', 'type'=>'CHAR')
      )
    );
    $child_page_array = get_posts($child_page_args);
    foreach($child_page_array as $child_page){?>
      <dt class="has_link"><a href="<?php echo get_permalink($child_page->ID);?>" class="arrow">
        <?php echo get_the_title($child_page->ID);?></a></dt>
    <?php }?>
  </dl>
</nav>

<?php
if(!empty(tt_get_child_pages('none', $par_page_id, $this_page_slug))){?>
  <nav class="nav_other">
  <ul><?php echo tt_get_child_pages('none', $par_page_id, $this_page_slug, 'arrow');?></ul>
  </nav>
<?php
}

// バナー
include('content-sidebanner.php');
}

// プラネタリウム
// ------------------------------------------------------
if(is_page_template('page-planetarium.php')){ ?>
<nav class="nav_category">
  <h3><a href="/<?php echo $par_page_slug;?>/"><?php echo $par_page_title;?></a></h3>
  <dl <?php if ($this_page_cat == 'outline') echo ' class="nav_category_show"';?>>
    <dt class="arrow">施設のご案内</dt>
    <dd>
    <ul><?php echo tt_get_child_pages('outline', $par_page_id, $this_page_slug);?></ul>
    </dd>
  </dl>
  <dl<?php if ($this_page_cat == 'subscribe') echo ' class="nav_category_show"';?>>
    <dt class="arrow">ご利用ガイド</dt>
    <dd>
      <ul><?php echo tt_get_child_pages('subscribe', $par_page_id, $this_page_slug);?></ul>
    </dd>
  </dl>
  <dl<?php if ($this_page_cat == 'price') echo ' class="nav_category_show"';?>>
    <dt class="arrow">ご利用料金</dt>
    <dd>
      <ul><?php echo tt_get_child_pages('price', $par_page_id, $this_page_slug);?></ul>
    </dd>
  </dl>
  <dl><?php
    $child_page_args = array(
      'post_type'=>'page', 'orderby'=>'order', 'posts_per_page'=>-1, 'post_parent'=>$par_page_id,
      'meta_query'=>array(
        array('key'=>'cat_page', 'value'=>'access', 'compare'=>'==', 'type'=>'CHAR')
      )
    );
    $child_page_array = get_posts($child_page_args);
    foreach($child_page_array as $child_page){?>
      <dt class="has_link"><a href="<?php echo get_permalink($child_page->ID);?>" class="arrow">
        <?php echo get_the_title($child_page->ID);?></a></dt>
    <?php }?>
  </dl>
</nav>
<?php
}

// 各館基本情報
// ------------------------------------------------------
?>
<section class="side_info">
  <?php
    $address = get_field('address', $par_page_id);
    $open = get_field('open', $par_page_id);
    $tel = get_field('tel', $par_page_id);
    $fax = get_field('fax', $par_page_id);
    $closed = get_field('closed', $par_page_id);
    $open_sub_array = get_field('open_sub', $par_page_id);
    $closed_sub_array = get_field('closed_sub', $par_page_id);
  ?>
  <h4><?php echo get_the_title($par_page_id);?></h4>
  <ul>
    <?php
    if($address){?>
    <li><?php echo $address?></li>
    <?php
    }
    if($tel || $fax){?>
    <li class="side_info_tel clearfix">
      <dl>
      <?php
      if($tel){?>
        <dt>TEL</dt>
        <dd><?php echo $tel;?></dd>
      <?php
      }
      if($fax){?>
        <dt>FAX</dt>
        <dd><?php echo $fax?></dd>
      <?php
      }?>
      </dl>
    </li>
    <?php
    }
    if($open || $closed || !empty($open_sub_array) || !empty($closed_sub_array)){?>
    <li class="side_info_other">
      <dl>
        <?php
        if($open){?>
        <dt>開館時間</dt>
        <?php
          echo '<dd>： '.$open;
          if(!empty($open_sub_array)){
            echo '<ul>'."\n";
            foreach($open_sub_array as $open_sub){
              echo '<li class="list_mark">'.$open_sub['notes'].'</li>'."\n";
            }
            echo '</ul>'."\n";
          }
          echo '</dd>';
        }if($closed){?>
          <dt>休館日</dt>
          <?php
            echo '<dd>： '.$closed;
            if(!empty($closed_sub_array)){
              echo '<ul>';
              foreach($closed_sub_array as $closed_sub){
                echo '<li class="list_mark">'.$closed_sub['notes'].'</li>'."\n";
              }
              echo '</ul>'."\n";
            }
            echo '</dd>'."\n";
        }?>
      </dl>
    </li>
    <?php
    }?>
  </ul>
</section>
</aside>
