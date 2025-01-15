<?php

/*
  各館TOP：kukikuki便り
*/

?>
<h2>blog　KUKI◇UKIUKI便り</h2>
<div class="blog_list">
  <ul>
    <?php
    $rss = simplexml_load_file('http://blog.goo.ne.jp/kuki_culture/rss2.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
    $postNum = 0;
    foreach($rss->channel->item as $item){
      $title = $item->title;
      // $title = mb_strimwidth(strip_tags($title), 0, 46, "...");
      $link = $item->link;
      $date = date("Y.n.j", strtotime($item->pubDate));
      $blogcat = $item->category;
      $postNum++;
      if($postNum <= 5):
    ?>
    <li>
      <div class="meta_block"><span><?php echo $date;?></span></div>
      <p><a href="<?php echo $link;?>" target="_blank"><?php echo $title;?></a></p>
    </li>
    <?php
      endif;
    } ?>

  </ul><!-- /.info_list -->
  <p class="more"><a href="http://blog.goo.ne.jp/kuki_culture/arcv" target="_blank">一覧を見る</a></p>
</div>
