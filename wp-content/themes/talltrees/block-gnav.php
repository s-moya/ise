<?php
$active_calendar = false;
$active_event = false;
$active_ticket = false;
$active_about = false;
$active_guide = false;
$active_access = false;
$active_circle = false;
$active_culture = false;
$topLevelPage ='';
if(is_page()){
  $topLevelPage = get_most_parent_page($post->ID)->post_name;
}
if(is_page('event_calendar')){
  $active_calendar = true;
}else if(is_post_type_archive('event') || is_singular('event')){
  $active_event = true;
}else if(is_page('ticket') || $topLevelPage == 'ticket'){
  $active_ticket = true;
}else if(is_page('about') || $topLevelPage == 'about'){
  $active_about = true;
}else if(is_page('guide') || $topLevelPage == 'guide'){
  $active_guide = true;
}else if(is_page('access') || $topLevelPage == 'access'){
  $active_access = true;
}else if(is_page('culture') || is_post_type_archive('culture') || is_singular('culture')){
  $active_culture = true;
}else if(is_page('circle') || $topLevelPage == 'circle'){
  $active_circle = true;
}
?>
<div class="navHeader clearfix">
  <p class="siteLogo"><a href="/"><?php echo get_bloginfo('name');?></a></p>
  <div class="menuToggle"><a href="">MENU</a></div>
</div>
<ul class="clearfix">
  <li><a href="/event_calendar/" <?php if($active_calendar) echo 'class="current"';?>>イベントカレンダー</a></li>
  <li><a href="/event/" <?php if($active_event) echo 'class="current"';?>>公演・イベント情報</a></li>
  <li><a href="/ticket/" <?php if($active_ticket) echo 'class="current"';?>>チケット購入</a></li>
  <li class="parentNav">
    <a href="/about/" <?php if($active_about) echo 'class="current"';?>>施設案内</a>
    <ul class="childNav">
      <?php
  		$aboutPage_id = get_id_by_slug('about');
  		$pages_args = array(
  			'post_type' => 'page',
  			'posts_per_page' => -1,
  			'post_parent' => $aboutPage_id
  		);
  		$childPages = get_posts($pages_args);
  		foreach($childPages as $childPage){
  			$childPageLink = get_permalink($childPage->ID);
  		?>
  		<li><a href="<?php echo get_permalink($childPage->ID);?>"><span><?php echo $childPage->post_title;?></span></a></li>
  		<?php }?>
    </ul>
  </li>
  <li class="parentNav">
    <a href="/guide/" <?php if($active_guide) echo 'class="current"';?>>利用案内</a>
    <ul class="childNav">
      <?php
  		$guidePage_id = get_id_by_slug('guide');
  		$pages_args = array(
  			'post_type' => 'page',
  			'posts_per_page' => -1,
  			'post_parent' => $guidePage_id
  		);
  		$childPages = get_posts($pages_args);
  		foreach($childPages as $childPage){
  			$childPageLink = get_permalink($childPage->ID);
  		?>
  		<li><a href="<?php echo get_permalink($childPage->ID);?>"><span><?php echo $childPage->post_title;?></span></a></li>
  		<?php }?>
    </ul>
  </li>
  <li><a href="/access/" <?php if($active_access) echo 'class="current"';?>>交通アクセス</a></li>
</ul>

<div class="subNavArea">
<ul class="subNav">
  <li><a href="/info/topics/">お知らせ</a>
  </li><li><a href="/sitemap/">サイトマップ</a>
  </li><li><a href="/faq/">よくある質問</a></li>
</ul>
<div class="contactWrapper"><a href="/contact/" class="contactBtn">お問い合わせ</a></div>
<?php get_template_part( 'content', 'search_form' );?>
</div>
