<?php
/*
template : header
問い合わせフォーム用修正済み
*/

// タイムゾーン設定
// date_default_timezone_set('Asia/Tokyo');
//jsの自動読み込み無効
wp_deregister_script('jquery');

$cacheVar = '1801';
$theme_path 	= get_stylesheet_directory_uri(); //テーマパス
$blog_path		= get_bloginfo("url"); //ブログURL
if(get_post_type_object(get_post_type())){
  $post_obj   = get_post_type_object(get_post_type());
  $post_type  = $post_obj->name; //ポストタイプ
  $post_type_label = $post_obj->label; //ポストタイプ名
}else if(is_archive('event')){
  $post_type  = 'event'; //ポストタイプ
}
$page_url    = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  // 現在のページのURL

global $template; ?><!DOCTYPE html><?php
	//確認用テンプレート取得
	// echo '<!--'.$template.'-->'."\n";
?>
<html <?php language_attributes();?> class="no-js <?php
if(is_singular('artist')) echo 'artistiFrame';
echo (is_page()) ? ' html-'.$post->post_name : '';
?>">
<head>


<?php
// previewでは非表示
if (strpos($_SERVER['HTTP_HOST'], 'preview') === false){?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-16451826-51"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-16451826-51');
</script>
<?php } ?>


<meta charset="<?php bloginfo( 'charset' ); ?>">
<?php if( is_page('setting') ){?>
<meta name='robots' content='noindex,follow' />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php if( check_device() === 'tablet' ){ ?>
<meta name="viewport" content="width=1250"><?php
}else{?>
<meta name="viewport" content="width=device-width,user-scalable=no">
<?php }?>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $theme_path;?>/images/favicon.ico">
<title><?php get_template_part( 'content-title', get_post_format() );?></title>
<meta name="description" content="<?php bloginfo('description');?>" />
<meta name="keywords" content="伊勢市観光文化会館,シンフォニアテクノロジー響ホール伊勢,三重県伊勢市,TallTrees,トールツリーズ,株式会社ケイミックスパブリックビジネス" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<?php
wp_reset_query();
if(!is_page_template('page-form.php') && !is_singular('artist') && !is_page_template('page-mailnews_form.php')){
wp_head();
?>
<link href='//fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<link rel="stylesheet" media="all" href="<?php echo $theme_path;?>/css/reset_min.css">
<link rel="stylesheet" media="all" href="<?php echo $theme_path;?>/css/style.css?var=<?php echo $cacheVar;?>">
<link rel="stylesheet" media="all" href="<?php echo $theme_path;?>/css/general_top.css?var=<?php echo $cacheVar;?>">
<link rel="stylesheet" media="all" href="<?php echo $theme_path;?>/css/common.css?var=<?php echo $cacheVar;?>">
<link rel="stylesheet" media="all" href="<?php echo $theme_path;?>/css/jquery.mCustomScrollbar.css">
<link rel="stylesheet" media="all and (max-width: 767px)" href="<?php echo $theme_path;?>/css/mobile.css?var=<?php echo $cacheVar;?>">
<link rel="stylesheet" media="all" href="<?php echo $theme_path;?>/css/hall_style.css">
<link rel="stylesheet" media="all" href="<?php echo $theme_path;?>/css/plus.css">

<script type="text/javascript" src="<?php echo $theme_path;?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo $theme_path;?>/js/jquery.heightLine.js"></script>
<script type="text/javascript" src="<?php echo $theme_path;?>/js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path;?>/js/jquery.mCustomScrollbar.js"></script>
<?php if(is_front_page()){?>
<script type="text/javascript" src="<?php echo $theme_path;?>/js/jQueryAutoHeight.js"></script>
<?php }?>
<link rel="stylesheet" href="<?php echo $theme_path;?>/css/jquery.fancybox.css" type="text/css" />
<script type="text/javascript" src="<?php echo $theme_path;?>/js/jquery.fancybox.js"></script>
<script type="text/javascript" src="<?php echo $theme_path;?>/js/jquery.sudoSlider.js"></script>
<script type="text/javascript" src="<?php echo $theme_path;?>/js/fixHeight.js"></script>
<script type="text/javascript" src="<?php echo $theme_path;?>/js/common.js?var=<?php echo $cacheVar;?>"></script>
<script type="text/javascript" src="<?php echo $theme_path;?>/js/mobile_function.js?var=<?php echo $cacheVar;?>"></script>

<?php
if(is_front_page()){?>
<link rel="stylesheet" href="<?php echo $theme_path;?>/css/bgstretcher.css">
<script type="text/javascript" src="<?php echo $theme_path;?>/js/bgstretcher.js"></script>

<link rel="stylesheet" href="<?php echo $theme_path;?>/css/juicyslider.css">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>
<script src="<?php echo $theme_path;?>/js/juicyslider.js"></script>

<link rel="stylesheet" href="<?php echo $theme_path;?>/css/owl.carousel.css">
<link rel="stylesheet" href="<?php echo $theme_path;?>/css/owl.theme.default.css">
<script src="<?php echo $theme_path;?>/js/owl.carousel.min.js"></script>
<?php
  // TOPメインスライダー
  $mainVisualObj = CFS()->get('mainVisual');
  $menus = get_field('menus');
  ?>
  <script type="text/javascript">
  $(function(){
    jQuery.preloadImages = function(){
      for(var i = 0; i<arguments.length; i++){
        $("<img>").attr("src", arguments[i]);
      }
    };
    $.preloadImages(<?php
      if(!empty($mainVisualObj)){
        foreach($mainVisualObj as $mainVisual){
          $slide_image = $mainVisual['image'];
          echo '"'. $slide_image .'",';
        }
      }
      foreach($menus as $menu){
        $thumb = $menu['thumb']['url'];
        echo '"'. $thumb .'"';
        if($menu != end($menus)){
          echo ',';
        }
      }
    ?>);
  });
  </script>
<?php
}
?>
<?php
}else{
  ?>
  <link rel="stylesheet" href="<?php echo $theme_path;?>/css/reset_min.css">
  <link rel="stylesheet" href="<?php echo $theme_path;?>/css/style.css">
  <link rel="stylesheet" href="<?php echo $theme_path;?>/css/general_top.css">
  <link rel="stylesheet" href="<?php echo $theme_path;?>/css/common.css">
  <link rel="stylesheet" media="all and (max-width: 767px)" href="<?php echo $theme_path;?>/css/mobile.css">
  <script>
  $(function(){
    $('#closeModal').click(function(){
      parent.$.fancybox.close();
    });
  });
  </script>
  <?php
}?>
<!--[if lt IE 9]>
<script src="<?php echo $theme_path;?>/js/html5shiv.js"></script>
<![endif]-->
<!--// キャッシュの無効化 //-->
<meta http-equiv="Cache-Control" content="no-store">
</head>

<?php
if(!is_page_template('page-form.php') && !is_singular('artist') && !is_page_template('page-mailnews_form.php')){

	$page_slug = '';
  $page_color = 'all';
	if(is_front_page('index')){
	  $page_color = 'all';

	}else if(is_page()){

	  // if(is_page_template('page-hall.php')){
    if(is_parent_slug()){
	    $most_par_post = get_most_parent_page();
	    $page_slug = $most_par_post->post_name;
	  }else{
	    $page_slug = $post->post_name;
	  }

	  switch($page_slug){
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
	?>
<body id="<?php echo $page_color;?>" <?php body_class(); ?>>
<div class="wrapper" id="page">
<div id="fb-root"></div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<header id="top" class="header">
  <div class="content_inner clearfix">
    <div class="innerBlock">
      <?php if(is_front_page()){ ?>
      <h1 class="siteLogo"><a href="/"><?php bloginfo('name');?></a></h1>
      <?php }else{ ?>
      <p class="siteLogo"><a href="/"><?php bloginfo('name');?></a></p>
      <?php }?>

      <div class="headerNav clearfix">
        <div class="clearfix">
        <ul class="subNav">
          <li><a href="/info/topics/">お知らせ</a>
          </li><li><a href="/sitemap/">サイトマップ</a>
          </li><li><a href="/faq/">よくある質問</a>
          </li><li><a href="/contact/" class="contactBtn">お問い合わせ</a></li>
        </ul><!-- /.subNav -->
        <!--<ul class="snsBtns">
          <li><a href="<?php bloginfo('rss2_url'); ?>" target="_blank"><img src="<?php echo $theme_path;?>/images/common/btn-rss.png" alt="rss"></a>
          </li><li><a href="https://www.facebook.com/isekanbun/" target="_blank">
            <img src="<?php echo $theme_path;?>/images/common/btn-fb.png" alt="facebook"></a>
          </li>
          <li><a href="https://twitter.com/ise_kanbun" target="_blank"><img src="<?php echo $theme_path;?>/images/common/btn-tw.png" alt="twitter"></a></li>
        </ul>--><!-- /.snsBtns -->
        </div>
        <?php get_template_part( 'content', 'search_form' );?>
      </div>
      <div class="menuToggle"><a href="">MENU</a></div>
    </div>
  </div><!-- /.content_inner -->

  <div class="gNav fixedNav">
  <?php get_template_part( 'block-gnav', get_post_format() );?>
  </div><!-- /.gNav -->

  <div class="spNav">
  <?php get_template_part( 'block-gnav', get_post_format() );?>
  </div><!-- /.spNav -->

  <?php
  if( !is_front_page() ){
  ?>
  <div class="gNav gNavArea">
    <div class="content_inner">
    <?php get_template_part( 'block-gnav', get_post_format() );?>
    </div>
  </div><!-- /.gNav -->
  <?php
  }
  ?>

</header>
<?php
  if( !is_front_page() && !is_singular('artist') && !is_page_template('page-mailnews_form.php')){
    get_template_part( 'content-topicpath_title', get_post_format() );
  ?>
  <div class="contentWrapper">
    <div class="container clearfix <?php
    if(is_page()){
      $topLevelPage ='';
      $topLevelPage = get_most_parent_page($post->ID)->post_name;
      $thisPagePostName = $post->post_name;
      echo 'page_'. $thisPagePostName. ' page_'.$topLevelPage. ' single_page';
    }
    if(is_page('event_calendar')) echo ' page_calendar';
    if(is_category() || is_archive('event') || is_single() || is_404() || is_search()) echo ' single_page';
    if(is_singular('post')) echo ' page_post_single';
    ?>">
    <div class="primary">
  <?php
  }
}else{
?>
<body <?php body_class();?>>
<?php } ?>
