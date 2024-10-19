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

function task_all_pay_function() {
  $pay_author = $_POST['payAuthor'];
  $args = array(
    'post_type'  => 'tasks',
    'numberposts' => -1,
    'meta_query' => array(
      array(
        'key'   => '_crb_tasks_author',
        'value' => $pay_author,
      )
    )
  );
  $all_posts = get_posts($args);
  foreach ($all_posts as $post) {
    $post_id = $post->ID;
    update_post_meta( $post_id, '_crb_tasks_pay', 'yes' );
  }
  echo $pay_author;
  wp_die();
}

add_action('wp_ajax_task_all_pay_click_action', 'task_all_pay_function');
add_action('wp_ajax_nopriv_task_all_pay_click_action', 'task_all_pay_function');

?>