<?php 

function task_pay_function() {
  $post_id = $_POST['postID'];
  if ( metadata_exists( 'post', $post_id, '_crb_tasks_pay' ) ) {
    update_post_meta( $post_id, '_crb_tasks_pay', 'yes' );
  } else {
    add_post_meta( $post_id, '_crb_tasks_pay', 'yes', true ); 
  } 
  echo $post_id;
  wp_die();
}

add_action('wp_ajax_task_pay_click_action', 'task_pay_function');
add_action('wp_ajax_nopriv_task_pay_click_action', 'task_pay_function');

?>