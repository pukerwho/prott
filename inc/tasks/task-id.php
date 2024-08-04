<?php 
function get_task_ID($task_id) {
  global $wpdb;
  $check_task_id = $wpdb->get_results(
    "
      SELECT post_id
      FROM wp_postmeta
      WHERE meta_value = '$task_id'
    "
  );
  return $check_task_id;
}
?>