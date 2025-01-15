<div class="side_block hoursArea">
  <h2><span>開館情報</span></h2>
  <div class="detail">
    <p>開館時間 8:30～22:00</p>
    <ul class="clearfix fixHeight">
      <!--<li class="clearfix"><strong>各種受付</strong><span>8:30～21:30</span>--></li>
    </ul>
	<!--
    <p style="margin-top:1em;">
    	<a href="/topics/post39243/">新型コロナウイルスに<br class="pc-only">関するご案内</a><br />
    </p>
    -->
    <!--
    <p style="margin-top:1em;">
    	避難所の<a href="/topics/post37900/">開設</a>・<br class="pc-only"><a href="/topics/post37927/">解除</a>に関するご案内</a>
    </p>
    -->
  </div>
</div><!-- /.side_block -->

<div class="side_block closedDays">
  <h2><span>休館日のご案内</span></h2>
  <p>
    <?php
    $topPageID = get_id_by_slug('home');
    $closed = get_field('closed', $topPageID);
    echo $closed;
    ?>
  </p>
</div><!-- /.side_block -->
