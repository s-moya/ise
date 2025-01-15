<?php
$pickup_set = array();
$pickup_in_list = array();
$pickup_status = array();
$pickup_terms = array();
$pickup_set = get_field('pickup_set');
if(!empty($pickup_set)){
  foreach($pickup_set as $pickup_check){
    $pickupKiji = $pickup_check['kiji'];
    $pickup_in_list[] = get_field('in_list', $pickupKiji->ID); // 一覧に表示するか
    $pickup_status[] = get_post_status($pickupKiji->ID); // 公開ステータス
    $pickup_terms[] = wp_get_object_terms($pickupKiji->ID, 'expire_category');
  }
}
if(!empty($pickup_set)){
?>
<div class="pickupArea">
  <ul class="pickupSlider fixHeight">
    <?php include( 'block-home_pickup_panel.php'); ?>
  </ul>
</div><!-- /.pickupArea -->
<?php
}
?>
