<?php 

function task_delivery_function() {
  
  $task_id = stripslashes_deep($_POST['taskId']);
  $task_user = stripslashes_deep($_POST['taskUser']);
  $title = wp_strip_all_tags('Завдання '.$task_id);
  
  $my_post = array(
    'post_title'    => $title,
    'post_name' => $task_id,
    'post_status'   => 'publish',
    'post_type' => 'tasks',
    'post_author'   => $task_user,
    'meta_input'   => array(
      '_crb_tasks_id' => $task_id,
      '_crb_tasks_status' => 'В процесі написання',
    ),
  );
  wp_insert_post( $my_post );
  echo 'hi';
  wp_die();
}

add_action('wp_ajax_task_delivery_click_action', 'task_delivery_function');
add_action('wp_ajax_nopriv_task_delivery_click_action', 'task_delivery_function');

?>