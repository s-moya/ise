<?php
$theme_path   = get_stylesheet_directory_uri(); //テーマパス
$blog_path    = get_bloginfo("url"); //ブログURL

$ticketPage = 'trash';
$ticketPageId = get_id_by_slug('ticket');
if($ticketPageId) $ticketPage = get_post_status($ticketPageId);

$membersPage = 'trash';
$membersPageId = get_id_by_slug('members');
if($membersPageId) $membersPage = get_post_status($membersPageId);

$mailnewsPage = 'trash';
$mailnewsPageId = get_id_by_slug('mailnews');
if($mailnewsPageId) $mailnewsPage = get_post_status($mailnewsPageId);

$artistPage = 'trash';
$artistPageId = get_id_by_slug('artist');
if($artistPageId) $artistPage = get_post_status($artistPageId);


$sibitenPage = 'trash';
$sibitenPageId = get_id_by_slug('sibiten');
if($sibitenPageId) $sibitenPage = get_post_status($sibitenPageId);

if($ticketPage == 'publish' || $membersPage == 'publish' || $mailnewsPage == 'publish' || $artistPage == 'publish' || $sibitenPage == 'publish'){
?>

<ul class="banner_area clearfix fixHeight">

	<li>
		<a href="https://ticket.kxdfs.co.jp/ise-kanbun-s/showList" target="_blank" rel="noopener noreferrer">
			<img src="<?php echo $theme_path;?>/images/common/bnr-ticket.jpg" alt="">
			<img src="<?php echo $theme_path;?>/images/common/sp/bnr-ticket_sp.jpg" alt="" class="sp">
		</a>
	</li>

  <?php
  if($sibitenPage == 'publish'){
  ?>
  <li><a href="/sibiten-report70/"><img src="<?php echo $theme_path;?>/images/common/bnr-shibiten2024.jpg" alt="市美展">
    <img src="<?php echo $theme_path;?>/images/common/sp/bnr-shibiten2024_sp.jpg" alt="市美展" class="sp">
  </a></li>
  <?php
  }
  if($membersPage == 'publish'){
  ?>
  <li><a href="/members/"><img src="<?php echo $theme_path;?>/images/common/bnr-member2.jpg" alt="">
    <img src="<?php echo $theme_path;?>/images/common/sp/bnr-member2_sp.jpg" alt="" class="sp">
  </a></li>
  <?php
  }
  ?>
  
	<!--
	<li>
		<a href="https://www.ise-kanbun.jp/src/pdf/news1909.pdf" target="_blank">
			<img src="<?php echo $theme_path;?>/images/common/bnr-news09.jpg" alt="">
			<img src="<?php echo $theme_path;?>/images/common/sp/bnr-news09_sp.jpg" alt="" class="sp">
		</a>
	</li>
	-->
  
  <?php
  if($mailnewsPage == 'publish'){
  ?>
  <li><a href="/mailnews/"><img src="<?php echo $theme_path;?>/images/common/bnr-mail.jpg" alt="">
    <img src="<?php echo $theme_path;?>/images/common/sp/bnr-mail_sp.jpg" alt="" class="sp">
  </a></li>
  <?php
  }
  if($artistPage == 'publish'){
  ?>
  <li><a href="/artist/"><img src="<?php echo $theme_path;?>/images/common/bnr-artist.jpg" alt="">
    <img src="<?php echo $theme_path;?>/images/common/sp/bnr-artist_sp.jpg" alt="" class="sp">
  </a></li>
  <?php } ?>

	<li>
		<a href="https://www.instagram.com/ise_kanbun/" target="_blank" rel="noopener noreferrer">
			<img src="<?php echo $theme_path;?>/images/common/bnr-insta.jpg" alt="">
			<img src="<?php echo $theme_path;?>/images/common/sp/bnr-insta_sp.jpg" alt="" class="sp">
		</a>
	</li>
	<li>
		<a href="https://www.facebook.com/isekanbun/" target="_blank" rel="noopener noreferrer">
			<img src="<?php echo $theme_path;?>/images/common/bnr-facebook.jpg" alt="">
			<img src="<?php echo $theme_path;?>/images/common/sp/bnr-facebook_sp.jpg" alt="" class="sp">
		</a>
	</li>
	<li>
		<a href="https://twitter.com/ise_kanbun" target="_blank" rel="noopener noreferrer">
			<img src="<?php echo $theme_path;?>/images/common/bnr-twitter.jpg" alt="">
			<img src="<?php echo $theme_path;?>/images/common/sp/bnr-twitter_sp.jpg" alt="" class="sp">
		</a>
	</li>
	<li>
		<a href="https://line.me/R/ti/p/%40725nzlcx" target="_blank" rel="noopener noreferrer">
			<img src="<?php echo $theme_path;?>/images/common/bnr-line.jpg" alt="">
			<img src="<?php echo $theme_path;?>/images/common/sp/bnr-line_sp.jpg" alt="" class="sp">
		</a>
	</li>
</ul><!-- /.banner_area -->
<?php }?>
