<?php
get_header();
?>
<div id="artist" style="width:800px;">
<div id="green">
<div class="right_column no_float">
<?php

while ( have_posts() ) : the_post();
  echo '<h1 class="short">'.get_the_title().'</h1>'."\n";
  echo '<div class="profile">'."\n";

  $thumb = get_field('img')['url'];
  $profile = get_field('profile');
  $daihyo = get_field('daihyo');
  $hensei = get_field('hensei');
  $address = get_field('address');
  $tel = get_field('tel');
  $fax = get_field('fax');
  $mail = get_field('mail');
  $url = get_field('url');
  $genre = get_field('genre');
  $price = get_field('price');
  $works = get_field('works');
  $other = get_field('other');

  ?>

<div class="profilcopy"><?php
if($thumb) {?>
  <img src="<?php echo $thumb;?>" alt="" class="imgLeft"><?php }
  if($profile) echo $profile;
  ?></div>
<div class="data">
<dl>
<dt><span class="smark">■</span> 代表者名</dt>
<dd><?php echo ($daihyo) ? $daihyo : '-';?></dd>
</dl>
<dl>
<dt><span class="smark">■</span> 編成</dt>
<dd><?php echo ($hensei) ? $hensei : '-';?></dd>
</dl>
<dl>
<dt><span class="smark">■</span> 住所</dt>
<dd><?php echo ($address) ? $address : '-';?></dd>
</dl>
<dl>
<dt><span class="smark">■</span> 電話</dt>
<dd><?php echo ($tel) ? $tel : '-';?></dd>
</dl>
<dl>
<dt><span class="smark">■</span> FAX</dt>
<dd><?php echo ($fax) ? $fax : '-';?></dd>
</dl>
<dl>
<dt><span class="smark">■</span> メール</dt>
<dd><?php echo ($mail) ? $mail : '-';?></dd>
</dl>
<dl>
<dt><span class="smark">■</span>ホームページ</dt>
<dd><?php echo ($url) ? '<a href="'.$url.'" target="_blank" class="external_link">'.$url.'</a>' : '-';?></dd></dl>
<dl>
<dt><span class="smark">■</span> ジャンル</dt>
<dd><?php echo ($genre) ? $genre : '-';?></dd>
</dl>
<dl>
<dt><span class="smark">■</span> 公演料など</dt>
<dd><?php echo ($price) ? $price : '-';?></dd></dl>
<dl>
<dt><span class="smark">■</span> 過去の実績</dt>
<dd><?php echo ($works) ? $works : '-';?></dd></dl>
<dl>
<dt><span class="smark">■</span> その他</dt>
<dd><?php echo ($other) ? $other : '-';?></dd>
</dl>
</div>


  <?php
  echo '</div>'."\n";
// End the loop.
endwhile;

?>
</div>
</div>
</div><!-- / artist -->
<?php
get_footer();
