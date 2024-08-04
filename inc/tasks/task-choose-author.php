<?php 

function task_choose_author_function() {
  
  $task_id = stripslashes_deep($_POST['taskId']);
  $task_author = stripslashes_deep($_POST['taskAuthor']);
  $task_site = stripslashes_deep($_POST['taskSite']);
  $title = wp_strip_all_tags('Завдання '.$task_id);
  
  $my_post = array(
    'post_title'    => $title,
    'post_name' => $task_id,
    'post_status'   => 'publish',
    'post_type' => 'tasks',
    'post_author'   => 1,
    'meta_input'   => array(
      '_crb_tasks_id' => $task_id,
      '_crb_tasks_author' => $task_author,
      '_crb_tasks_site' => $task_site,
      '_crb_tasks_status' => 'В процесі написання',
    ),
  );
  wp_insert_post( $my_post );
  sendTelegramAuthor($task_id, $task_author);
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