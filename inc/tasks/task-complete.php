<?php 
//Прийняти замовлення
function task_complete_function() {
  $post_id = stripslashes_deep($_POST['postID']);
  if ( metadata_exists( 'post', $post_id, '_crb_tasks_complete' ) ) {
    update_post_meta( $post_id, '_crb_tasks_complete', 'yes' );
    update_post_meta( $post_id, '_crb_tasks_status', 'Перевірено' );
  } else {
    add_post_meta( $post_id, '_crb_tasks_complete', 'yes', true );
    update_post_meta( $post_id, '_crb_tasks_status', 'Перевірено' );
  } 
  echo 'hi';
  wp_die();
}

add_action('wp_ajax_task_complete_click_action', 'task_complete_function');
add_action('wp_ajax_nopriv_task_complete_click_action', 'task_complete_function');

?>