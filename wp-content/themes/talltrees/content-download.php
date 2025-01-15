<?php
$theme_path = get_stylesheet_directory_uri(); //テーマパス
$blog_path  = get_bloginfo("url"); //ブログURL
$page_url   = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];  // 現在のページのURL
?>

<article>
<?php
  $downloads = get_field('downloads');
  if(!empty($downloads)){
    foreach($downloads as $download){
      if($download['title']){
        if($download['link_id']){
          echo '<h2 id="'.$download['link_id'].'">'.$download['title'].'</h2>';
        }else{
          echo '<h2>'.$download['title'].'</h2>';
        }
      }
      $pdf_sets = $download['pdf_set'];
      if(!empty($pdf_sets)){
        ?>
        <section>
        <table class="table_2">
          <col width="40%">
          <col width="30%">
          <col width="30%">
          <thead>
            <tr>
            <th>資料名</th>
            <th>ダウンロード</th>
            <th>更新日</th>
            </tr>
          </thead>
          <tbody>
        <?php
        foreach($pdf_sets as $pdf_set){
          $name = $pdf_set['name'];
          $pdf = $pdf_set['pdf'];
          $update = $pdf_set['update'];
          ?>
          <tr>
            <td class="table_item"><?php echo $name;?></td>
            <td><a href="<?php echo $pdf['url'];?>" class="pdf_link" target="_blank">PDFファイル<span>PDF</span></a></td>
            <td><?php echo $update;?></td>
          </tr>
          <?php
        }
        ?>
          </tbody>
        </table>
        </section>
        <?php
      }
    }
  }else{
    echo '<!--<p>順次公開いたします。</p>-->';
  }
?>

</article>
