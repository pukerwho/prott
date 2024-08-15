<?php 
//Прийняти замовлення
function task_accept_function() {
  $post_id = stripslashes_deep($_POST['postID']);
  if ( metadata_exists( 'post', $post_id, '_crb_tasks_accept' ) ) {
    update_post_meta( $post_id, '_crb_tasks_accept', 'yes' );
    update_post_meta( $post_id, '_crb_tasks_status', 'В роботі' );
  } else {
    add_post_meta( $post_id, '_crb_tasks_accept', 'yes', true );
    update_post_meta( $post_id, '_crb_tasks_status', 'В роботі' );
  } 
  echo 'hi';
  wp_die();
}

add_action('wp_ajax_task_accept_click_action', 'task_accept_function');
add_action('wp_ajax_nopriv_task_accept_click_action', 'task_accept_function');

?>