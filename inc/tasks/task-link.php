<?php 

function task_link_function() {
  $task_id = stripslashes_deep($_POST['taskId']);
  $post_id = $_POST['postID'];
  $clbr_type = $_POST['clbrType'];
  $task_link = stripslashes_deep($_POST['taskLink']);
  $task_link_date = current_time( 'timestamp' );

  if ( metadata_exists( 'post', $post_id, '_crb_tasks_post_link' ) ) {
    update_post_meta( $post_id, '_crb_tasks_post_link', $task_link );
    update_post_meta( $post_id, '_crb_tasks_link_date', $task_link_date );
    update_post_meta( $post_id, '_crb_tasks_status', 'На перевірці' );
  } else {
    add_post_meta( $post_id, '_crb_tasks_post_link', $task_link, true ); 
    add_post_meta( $post_id, '_crb_tasks_link_date', $task_link_date, true );
    update_post_meta( $post_id, '_crb_tasks_status', 'На перевірці' );
  } 
  sendTelegramLink($task_id, $task_link, $clbr_type);
  echo $post_id;
  wp_die();
}

add_action('wp_ajax_task_link_click_action', 'task_link_function');
add_action('wp_ajax_nopriv_task_link_click_action', 'task_link_function');

function sendTelegramLink($id, $task_link, $clbr_type) {
  $chatID = carbon_get_theme_option("crb_telegram_id_naperevirku");
  $apiToken = carbon_get_theme_option("crb_telegram_api_bot_naperevirku");
  if ($clbr_type == '1') {
    $type = '✅ Тип: Готова стаття.';
    $clbr_link = "https://collaborator.pro/ua/deal/default/show-info-article?id=" . $id;
  } else {
    $type = '✍️ Тип: З написанням.';
    $clbr_link = "https://collaborator.pro/ua/deal/default/performer-article?id=" . $id;
  }
  
  $content = "$type\n\n💪 Угода <a href='$clbr_link'><b>$id</b></a> на перевірці.\n\n🔗 Посилання: <b>$task_link</b>.";

  $url = "https://api.telegram.org/bot{$apiToken}/sendMessage";

  $data = [
    'chat_id' => $chatID,
    'text' => $content,
    'parse_mode' => 'HTML'
  ];

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $response = curl_exec($ch);
  curl_close($ch);

  // необов'язково, але корисно для налагодження
  // error_log($response);
}