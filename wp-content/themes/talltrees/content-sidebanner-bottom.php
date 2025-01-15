<?php

// ====================================
// 施設空き状況〜周辺情報の枠下のバナー
// ====================================
$theme_path   = get_stylesheet_directory_uri(); //テーマパス
$blog_path    = get_bloginfo("url"); //ブログURL

?>
<ul class="banner_area banner_area_bottom clearfix fixHeight">
	
	<!--
	<li>
		<a href="http://ise-kanbun.jp/sibiten/index.html" target="_blank">
			<img src="<?php echo $theme_path;?>/images/common/bnr-shibiten.jpg" alt="市美展">
			<img src="<?php echo $theme_path;?>/images/common/sp/bnr-shibiten_sp.jpg" alt="市美展" class="sp">
		</a>
	</li>
	-->
	<li>
		<a href="https://www.city.ise.mie.jp/" target="_blank">
			<img src="<?php echo $theme_path;?>/images/common/bnr-city.jpg" alt="伊勢市">
			<img src="<?php echo $theme_path;?>/images/common/sp/bnr-city_sp.jpg" alt="伊勢市" class="sp">
		</a>
	</li>
	<li>
		<a href="http://www.sinfo-t.jp/" target="_blank">
			<img src="<?php echo $theme_path;?>/images/common/bnr-sinfonia.jpg" alt="シンフォニアテクノロジー">
			<img src="<?php echo $theme_path;?>/images/common/sp/bnr-sinfonia_sp.jpg" alt="シンフォニアテクノロジー" class="sp">
		</a>
	</li>
</ul>
<!-- /.banner_area -->