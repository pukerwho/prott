<?php 

function task_choose_author_function() {

  $post_id = stripslashes_deep($_POST['postId']);
  $task_author = stripslashes_deep($_POST['taskAuthor']);
  $task_author_date = current_time( 'timestamp' );
  
  if ( metadata_exists( 'post', $post_id, '_crb_tasks_author' ) ) {
    update_post_meta( $post_id, '_crb_tasks_author', $task_author );
    update_post_meta( $post_id, '_crb_tasks_status', 'В процесі написання' );
    update_post_meta( $post_id, '_crb_tasks_author_date', $task_author_date );
  } else {
    add_post_meta( $post_id, '_crb_tasks_author', $task_author, true );
    add_post_meta( $post_id, '_crb_tasks_author_date', $task_author_date, true );
    update_post_meta( $post_id, '_crb_tasks_status', 'В процесі написання' );
  } 
  // sendTelegramAuthor($task_id, $task_author);
  echo 'hi';
  wp_die();
}

add_action('wp_ajax_task_author_click_action', 'task_choose_author_function');
add_action('wp_ajax_nopriv_task_author_click_action', 'task_choose_author_function');

function sendTelegramAuthor($id, $task_author) {
  $chatID = carbon_get_theme_option("crb_telegram_chat_id");
  $apiToken = carbon_get_theme_option("crb_telegram_api");
  $content = "";
  $content .= "Угода <b>$id</b> в роботі. Пише <b>$task_author</b>.\n";
  
  $data = [
    'chat_id' => $chatID, 
    'text' => $content,
    'parse_mode' => 'HTML'
  ];
  $response = file_get_contents("https://api.telegram.org/bot".$apiToken."/sendMessage?" . http_build_query($data) );
}

?>