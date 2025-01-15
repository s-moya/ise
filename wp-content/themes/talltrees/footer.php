<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

 if(!is_page_template('page-form.php') && !is_singular('artist') && !is_page_template('page-mailnews_form.php')){
   $theme_path 	= get_stylesheet_directory_uri(); //テーマパス
   $blog_path		= get_bloginfo("url"); //ブログURL
   if(get_post_type_object(get_post_type())){
     $post_obj   = get_post_type_object(get_post_type());
     $post_type  = $post_obj->name; //ポストタイプ
     $post_type_label = $post_obj->label; //ポストタイプ名
   }else if(is_archive('event')){
     $post_type  = 'event'; //ポストタイプ
     $post_type_label = '公演・イベント情報'; //ポストタイプ名
   }
   $page_url     = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  // 現在のページのURL
   $is_recommend = false;

   if(is_page('links')){
     $array = array(
       'post_type'     =>'event',
      //  'post_status'   =>'publish',
       'posts_per_page'=>-1,
       'tax_query' => array(
         array(
           'taxonomy' => 'genre',	//タクソノミーを指定
           'field' => 'slug',	//ターム名をスラッグで指定する
           'terms' => 'jointly',	//表示したいタームをスラッグで指定
           'include_children'=>true,
           'operator'=>'IN'
         ),
         array(
           'taxonomy' => 'labels',	//タクソノミーを指定
           'field' => 'slug',	//ターム名をスラッグで指定する
           'terms' => 'jointly',	//表示したいタームをスラッグで指定
           'operator'=>'IN'
         ),
       'relation' => 'OR'
       )
     );
     $footerPosts = get_posts($array);
    //  foreach($footerPosts as $footerPost){
    //    var_dump(get_the_title($footerPost->ID));
    //  }
     echo '<!-- 合同：'.count($footerPosts).'-->'."\n";
   }
?>

<?php if(!is_front_page()){ ?>
</div><!-- /.primary -->
<?php } ?>
</div><!-- /.container -->

<?php wp_reset_query(); ?>
<div class="snsLinks">
  <ul>
    <li><a href="//www.facebook.com/sharer.php?u=<?php echo $page_url;?>&amp;t=<?php bloginfo('url');?>" class="fb" target="_blank"><span>シェア</span></a>
    </li><li><a href="//twitter.com/share?text=<?php echo urlencode(get_the_title().'｜'.get_bloginfo('name'));?>&amp;url=<?php echo urlencode($page_url);?>" class="tw" target="_blank"><span>ポスト　</span></a>
    </li><li><a href="//social-plugins.line.me/lineit/share?url=<?php echo $page_url;?>" class="line" target="_blank"><span>送る</span></a>
    <!--</li><li><a href="//plus.google.com/share?url=<?php echo $page_url;?>" class="gp" target="_blank"><span>シェア</span></a>-->
    </li><li><a href="//b.hatena.ne.jp/add?mode=confirm&url=<?php echo $page_url;?>" class="hb" target="_blank"><span>はてぶ</span></a></li>
  </ul>
</div><!-- /.snsLinks -->
<div class="pageTop">
  <a href="#page">PAGETOP</a>
</div><!-- /.pageTop -->
</div><!-- /.contentWrapper -->


<div class="adminInfo">
  <h2>シンフォニアテクノロジー響ホール伊勢<span style="font-size:0.8em;">（伊勢市観光文化会館）</span><!--<?php echo get_bloginfo('name');?>--></h2>
  <p>
    　〒516-0037　<br class="sp">三重県伊勢市岩渕1丁目13－15<br>
    <span class="accessLink"><a href="/access/" class="arrow">交通アクセス</a><br></span>
    　TEL.0596-28-5105　<br class="sp">FAX.0596-28-5106
  </p>
  <a href="/contact/" class="btn-contact"><span class="arrow">お問い合わせ</span></a>
</div><!-- /.adminInfo -->

<footer class="footer">
<div class="contentWrapper footerInner">
  <div class="content_inner clearfix fixHeight">
    <div class="block">
      <p class="title">開館・受付時間</p>
      <table>
        <tr><th>開館・受付時間</th><td>8:30～22:00</td></tr>
        <!--<tr><th><span style="font-size:0.8em; font-weight:normal;">改修工事による休館中の受付対応時間</span></th><td><span style="font-size:0.8em;">9:00～17:15</span></td></tr>-->
      </table>
      <p class="title">休館日</p>
      <p><strong>年末年始</strong><span style="font-size:0.8em;">（12月29日から翌年1月3日まで）</span></p>
    </div>
    <div class="block">
      <p class="title">指定管理者</p>
      <!--
      <p style="text-align:center;">
        <a href="https://www.kpb.co.jp" target="_blank" class="pc-only">
          <img src="<?php echo $theme_path;?>/images/common/logo-footer_kpb.jpg">
        </a>
      </p>
      <p style="text-align:center;">
        <a href="https://www.kpb.co.jp" target="_blank" class="sp-only">
          <img src="<?php echo $theme_path;?>/images/common/sp/logo-footer_kpb.jpg" width="250">
        </a>
      </p>
      -->
      <ul class="clearfix">
        <li><a href="https://www.kpb.co.jp" target="_blank">
          <img src="<?php echo $theme_path;?>/images/common/logo-footer_kpb.jpg" alt="">
          <img src="<?php echo $theme_path;?>/images/common/sp/logo-footer_kpb.jpg" alt="" class="sp">
        </a></li>
        <li><a href="http://privacymark.jp/" target="_blank">
          <img src="https://www.bunkakikaku.jp/mark/pmark.gif" alt="">
          <img src="https://www.bunkakikaku.jp/mark/pmark_sp.gif" alt="" class="sp"><br>
          <span>株式会社ケイミックス<br class="sp" />パブリックビジネスは<br>「プライバシーマーク」を<br class="sp">取得しております</span>
        </a></li>
      </ul>
    </div>
    <div class="block pc-only">
      <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fisekanbun%2F&tabs=timeline&width=330&height=300&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=false&appId" width="330" height="300" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
    </div>
    <div class="block sp-only" style="text-align:center;">
      <br>
      <div class="fb-page" data-href="https://www.facebook.com/isekanbun/" data-tabs="timeline" data-width="330" data-height="300" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"></div>
    </div>
  </div><!-- /.content_inner -->
</div><!-- /.content_inner -->

<ul class="footerNav">
  <li><a href="/sitemap/">サイトマップ</a>
  </li><li><a href="/links/">関連リンク</a>
  </li><li><a href="https://www.kpb.co.jp/privacy.html" target="blank" class="external_link">プライバシーポリシー</a></li>
</ul>
<p class="copyright"> Copyright &copy; <?php bloginfo('name');?><br class="sp"> All Rights Reserved. </p>

</footer>
</div>

<script src="<?php echo $theme_path; ?>/js/getBrowser.js"></script>
<script src="<?php echo $theme_path; ?>/js/css_browser_selector.js"></script>
<?php
}
wp_footer();

// $time_start = get_query_var('time_start', 1);
// $time_end = microtime(true);
// $time = $time_end - $time_start;

// echo $time;

?>
</body>
</html>
