<?php 
// addNoTaskDb();
//Cron

// $parametri = array( 'one' );
// if( ! wp_next_scheduled( 'check_id_hook', $parametri ) ) {
// 	wp_schedule_event( time(), 'onesec', 'check_id_hook', $parametri );
// }
 
// add_action( 'check_id_hook', 'check_id', 10, 3 );
 
function check_id( $test ) {
  error_log('check_id() виконано: ' . date('Y-m-d H:i:s'));
  $noHaveTaskId_write = array();
  $noHaveTaskId_collab = array();

  $collab_one = carbon_get_theme_option('crb_collab_one');
  $collab_two = carbon_get_theme_option('crb_collab_two');
  $collab_three = carbon_get_theme_option('crb_collab_three');
  $opts_one = array( "ssl"=>array( "verify_peer"=>false, "verify_peer_name"=>false,), 'http'=>array('method'=>"GET",'header'=>"X-Api-Key: $collab_one\r\n" . "accept: application/json\r\n"));
  $opts_two = array( "ssl"=>array( "verify_peer"=>false, "verify_peer_name"=>false,), 'http'=>array('method'=>"GET",'header'=>"X-Api-Key: $collab_two\r\n" . "accept: application/json\r\n"));
  $opts_three = array( "ssl"=>array( "verify_peer"=>false, "verify_peer_name"=>false,), 'http'=>array('method'=>"GET",'header'=>"X-Api-Key: $collab_three\r\n" . "accept: application/json\r\n"));

  $context_one = stream_context_create($opts_one);
  $context_two = stream_context_create($opts_two);
  $context_three = stream_context_create($opts_three);
  $file_one = file_get_contents("https://collaborator.pro/ua/api/public/deal/list-owner?per-page=40&page=1&language=ua", false, $context_one); 
  $file_two = file_get_contents("https://collaborator.pro/ua/api/public/deal/list-owner?per-page=40&page=1&language=ua", false, $context_two); 
  $file_three = file_get_contents("https://collaborator.pro/ua/api/public/deal/list-owner?per-page=40&page=1&language=ua", false, $context_three); 

  $items_one = json_decode($file_one, true);
  $items_two = json_decode($file_two, true);
  $items_three = json_decode($file_three, true);
  $items = array_merge($items_one['items'], $items_two['items'], $items_three['items']);

  $sortItems = array_orderby($items, 'id', SORT_DESC);
  $noHaveTask = array();
  foreach ($sortItems as $i) {
    $status = $i['status'];
    if ($status === 'В роботі') {
      $task_id = $i['id']; 
      $task_content = nl2br($i['task']['task']);
      $task_website = $i['site'];
      $task_anchors = $i['task']['anchors'];
      $task_type = $i['publicationType'];
      $task_title = $i['task']['title'];
      $task_url = $i['task']['url'];
      $task_html = $i['task']['contentHtml'];
      $task_metatitle = $i['task']['metaTitle'];
      $task_metadescription = $i['task']['metaDescription'];
      $task_date_create = date("d.m, H:i", strtotime($i['createdAt']));
      // Перевіряємо чи є вже завдання з таким ID
      $get_task_id = get_task_ID($task_id);
      // Якщо немає, то додаємо в массив noHaveTask (Завдання значить ще немає) + Створюємо завдання
      if ( empty( $get_task_id ) ) {
        // Заповнюємо масив айдішками
        array_push($noHaveTask, $task_id); 
        createTask($task_id, $task_content, $task_website, $task_date_create, $task_anchors, $task_type, $task_title, $task_url, $task_html, $task_metatitle, $task_metadescription);
      }
    }
  }
  // Перевіряємо чи є замовлення без завдання
  if ($noHaveTask) {
    foreach ($noHaveTask as $notaskid) {
      // Перевіряємо чи є замовлення в базі данних NoTask
      $has_task_id = checkIdNoTask($notaskid);

      $task_type = null;
      foreach ($sortItems as $item) {
        if ($item['id'] === $notaskid) {
          $task_type = $item['publicationType'];
          break;
        }
      }

      // Спочатку додаємо до масиву для сповіщення
      if ($task_type === 'Ви пишете') {
        $noHaveTaskId_write[] = $notaskid;
      } else {
        $noHaveTaskId_collab[] = $notaskid;
      }

      // Потім перевіряємо і додаємо в базу, якщо ще немає
      if ( count($has_task_id) === 0 ) {
        addNoTaskToDb($notaskid);
      }
    }
  }
  $now = new DateTime("now", new DateTimeZone('Europe/Kyiv'));
  $dayOfWeek = $now->format('N'); // 1 – понеділок, 7 – неділя
  $hour = (int)$now->format('G'); // години 0–23

  // Для "Ви пишете": щодня з 09:00 до 22:00
  if (count($noHaveTaskId_write) > 0 && $hour >= 9 && $hour < 22) {
    sendAlertTelegram($noHaveTaskId_write, 'write');
  }

  // Для "Готова стаття": лише з понеділка по п’ятницю до 19:00
  if (
    count($noHaveTaskId_collab) > 0 &&
    $dayOfWeek >= 1 && $dayOfWeek <= 5 &&
    $hour < 19
  ) {
    sendAlertTelegram($noHaveTaskId_collab, 'collab');
  }
}

function array_orderby() {
  $args = func_get_args();
  $data = array_shift($args);
  foreach ($args as $n => $field) {
    if (is_string($field)) {
      $tmp = array();
      foreach ($data as $key => $row)
        $tmp[$key] = $row[$field];
      $args[$n] = $tmp;
    }
  }
  $args[] = &$data;
  call_user_func_array('array_multisort', $args);
  return array_pop($args);
}

function createTask($task_id, $task_content, $task_website, $task_date_create, $task_anchors, $task_type, $task_title, $task_url, $task_html, $task_metatitle, $task_metadescription){
  $title = wp_strip_all_tags('Завдання '.$task_id);
  
  $my_post = array(
    'post_title'    => $title,
    'post_content'    => $task_content,
    'post_name' => $task_id,
    'post_status'   => 'publish',
    'post_type' => 'tasks',
    'post_author'   => 1,
    'meta_input'   => array(
      '_crb_tasks_id' => $task_id,
      '_crb_tasks_site' => $task_website,
      '_crb_tasks_anchors' => $task_anchors,
      '_crb_tasks_date_create' => $task_date_create,
      '_crb_tasks_type' => $task_type,
      '_crb_tasks_title' => $task_title,
      '_crb_tasks_url' => $task_url,
      '_crb_tasks_metatitle' => $task_metatitle,
      '_crb_tasks_metadescription' => $task_metadescription,
      '_crb_tasks_html' => wp_kses_post($task_html),
      '_crb_tasks_status' => 'Нове завдання',
    ),
  );
  wp_insert_post( $my_post );
}

function checkIdNoTask($task_id) {
  global $wpdb;
  $check_task_id = $wpdb->get_results(
    "
      SELECT ID
      FROM notask_col
      WHERE no_task = '$task_id'
    "
  );
  return $check_task_id;
}

function sendAlertTelegram($noHaveTaskId, $type = 'collab') {
  $chatID = ($type === 'write') 
      ? carbon_get_theme_option("crb_telegram_chat_write") 
      : carbon_get_theme_option("crb_telegram_chat_ready");
  $apiToken = carbon_get_theme_option("crb_telegram_api");
  $content = "";
  $content .= "⚡ Є нові завдання";
  
  $data = [
    'chat_id' => $chatID, 
    'text' => $content,
    'parse_mode' => 'HTML'
  ];
  $response = file_get_contents("https://api.telegram.org/bot".$apiToken."/sendMessage?" . http_build_query($data) );
}

function addNoTaskToDb($notaskid) {
  global $wpdb;
  $wpdb->query( $wpdb->prepare( 
    "
      INSERT INTO notask_col
      ( no_task )
      VALUES ( %d)
    ",
    array(
      $notaskid, 
    )
  ) );
}

function addNoTaskDb() {
  global $wpdb;

  $charset_collate = $wpdb->get_charset_collate();

  if($wpdb->get_var("SHOW TABLES LIKE 'notask_col'") != 'notask_col') {
    
    $sql = "CREATE TABLE `notask_col` (
        `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `no_task` bigint(20) NOT NULL,
        `date_create` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY (`ID`),
        KEY `no_task` (`no_task`)
      ) $charset_collate;";

    $wpdb->query( $sql );

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    return true;
  }
}