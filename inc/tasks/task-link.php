<?php 

function task_link_function() {
  $task_id = stripslashes_deep($_POST['taskId']);
  $post_id = $_POST['postID'];
  $task_link = stripslashes_deep($_POST['taskLink']);

  if ( metadata_exists( 'post', $post_id, '_crb_tasks_post_link' ) ) {
    update_post_meta( $post_id, '_crb_tasks_post_link', $task_link );
    update_post_meta( $post_id, '_crb_tasks_status', 'На перевірці' );
  } else {
    add_post_meta( $post_id, '_crb_tasks_post_link', $task_link, true ); 
    update_post_meta( $post_id, '_crb_tasks_status', 'На перевірці' );
  } 
  sendTelegramLink($task_id, $task_link);
  echo $post_id;
  wp_die();
}

add_action('wp_ajax_task_link_click_action', 'task_link_function');
add_action('wp_ajax_nopriv_task_link_click_action', 'task_link_function');

function sendTelegramLink($id, $task_link) {
  $chatID = carbon_get_theme_option("crb_telegram_chat_id");
  $apiToken = carbon_get_theme_option("crb_telegram_api");
  $content = "";
  $content .= "Угода <b>$id</b> виконана. </b>.\n\n";
  $content .= "<b>Посилання:</b> task_link</b>";
  
  $data = [
    'chat_id' => $chatID, 
    'text' => $content,
    'parse_mode' => 'HTML'
  ];
  $response = file_get_contents("https://api.telegram.org/bot".$apiToken."/sendMessage?" . http_build_query($data) );
}

?>