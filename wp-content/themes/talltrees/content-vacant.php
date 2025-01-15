<?php

/*
  各館：施設利用受付ページ
*/

?>
<section class="vacant_list">
<?php
$vacant_lists = get_field('vacant_list');
if(!empty($vacant_lists)){
  foreach($vacant_lists as $vacant_list){
    echo ($vacant_list['vacant_name']) ? '<h2>'.$vacant_list['vacant_name'].'</h2>' : '';
    $pdf_sets = $vacant_list['pdf_set'];
    if(!empty($pdf_sets)){?>
    <section>
    <table class="table_2">
      <col width="35%">
      <col width="35%">
      <col width="30%">
      <thead>
        <tr>
        <th>月</th>
        <th>空き状況</th>
        <th>更新日</th>
        </tr>
      </thead>
      <tbody>
    <?php
    foreach($pdf_sets as $pdf_set){
      $tsuki = $pdf_set['tsuki'];
      $pdf = $pdf_set['pdf'];
      $update = $pdf_set['update'];
      ?>
      <tr>
        <!-- <td class="table_item"><?php //echo tt_format_date($tsuki, 'Y年n月', '', false);?></td> -->
        <td class="table_item"><?php echo $tsuki;?></td>
        <td><a href="<?php echo $pdf;?>" class="pdf_link" target="_blank">PDFリンク<span>PDF</span></a></td>
        <!-- <td><?php //echo tt_format_date($update, 'Y年n月j日', '', false);?></td> -->
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
}
?>
</section>
