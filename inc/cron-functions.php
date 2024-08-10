<?php 
//Cron
$parametri = array( 'one' );
if( ! wp_next_scheduled( 'check_id_hook', $parametri ) ) {
	wp_schedule_event( time(), 'onesec', 'check_id_hook', $parametri );
}
 
add_action( 'check_id_hook', 'check_id', 10, 3 );
 
function check_id( $test ) {
  $collab_one = carbon_get_theme_option('crb_collab_one');
  $collab_two = carbon_get_theme_option('crb_collab_two');
  $opts_one = array( "ssl"=>array( "verify_peer"=>false, "verify_peer_name"=>false,), 'http'=>array('method'=>"GET",'header'=>"X-Api-Key: $collab_one\r\n" . "accept: application/json\r\n"));
  $opts_two = array( "ssl"=>array( "verify_peer"=>false, "verify_peer_name"=>false,), 'http'=>array('method'=>"GET",'header'=>"X-Api-Key: $collab_two\r\n" . "accept: application/json\r\n"));

  $context_one = stream_context_create($opts_one);
  $context_two = stream_context_create($opts_two);
  $file_one = file_get_contents("https://collaborator.pro/ua/api/public/deal/list-owner?per-page=40&page=1&language=ua", false, $context_one); 
  // $file_one_twopage = file_get_contents("https://collaborator.pro/ua/api/public/deal/list-owner?page=2&language=ua", false, $context_one); 
  $file_two = file_get_contents("https://collaborator.pro/ua/api/public/deal/list-owner?per-page=40&page=1&language=ua", false, $context_two); 
  // $file_two_twopage = file_get_contents("https://collaborator.pro/ua/api/public/deal/list-owner?page=2&language=ua", false, $context_two); 

  $items_one = json_decode($file_one, true);
  $items_two = json_decode($file_two, true);
  $items_one_twopage = json_decode($file_one_twopage, true);
  $items_two_twopage = json_decode($file_two_twopage, true);
  $items = array_merge($items_one['items'], $items_two['items']);

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
  $sortItems = array_orderby($items, 'id', SORT_DESC);
  $noHaveTask = array();
  foreach ($sortItems as $i) {
    $status = $i['status'];
    $publicationType = $i['publicationType'];
    if ($status === 'В роботі' && $publicationType === 'Ви пишете') {
      $task_id = $i['id']; 
      // Перевіряємо чи є вже завдання з таким ID
      $get_task_id = get_task_ID($task_id);
      // Якщо немає, то додаємо в массив noHaveTask (Завдання значить ще немає)
      if (!$get_task_id) { 
        //Створюємо 
        array_push($noHaveTask, $task_id); 
      }
    }
  }
  // Перевіряємо чи є замовлення без завдання
  if ($noHaveTask) {
    $noHaveTaskId = array();
    foreach ($noHaveTask as $notaskid) {
      // Перевіряємо чи є замовлення в базі данних NoTask
      $has_task_id = checkIdNoTask($notaskid);

      // Якщо немає, то додаємо ці замовлення в базу данних NoTask
      if ( empty( $has_task_id ) ) {
        // Записуємо id, по яким ще не відправляли 
        array_push($noHaveTaskId, $notaskid); 
        addNoTaskToDb($notask);
      } 
    }
  }
  if ($noHaveTaskId) {
    sendAlertTelegram();
  }
}

function checkIdNoTask($task_id) {
  global $wpdb;
  $check_task_id = $wpdb->get_results(
    "
      SELECT ID
      FROM notaskid
      WHERE no_task_id = '$task_id'
    "
  );
  return $check_task_id;
}

function sendAlertTelegram() {
  $chatID = carbon_get_theme_option("crb_telegram_chat_id");
  $apiToken = carbon_get_theme_option("crb_telegram_api");
  $content = "";
  $content .= "Є нові події. Перейти на сайт https://prott.com.ua/.\n";
  
  $data = [
    'chat_id' => $chatID, 
    'text' => $content,
    'parse_mode' => 'HTML'
  ];
  $response = file_get_contents("https://api.telegram.org/bot".$apiToken."/sendMessage?" . http_build_query($data) );
}

function addNoTaskToDb($notask) {
  addNoTaksDb();
  $wpdb->query( $wpdb->prepare( 
    "
      INSERT INTO notaskid
      ( no_task_id )
      VALUES ( %s,)
    ",
    array(
      $notask, 
    )
  ) );
}

function addNoTaskDb() {
  global $wpdb;

  $charset_collate = $wpdb->get_charset_collate();

  if($wpdb->get_var("SHOW TABLES LIKE 'notaskid'") != 'notaskid') {
    $sql = "CREATE TABLE `notaskid` (
        `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `no_task_id` bigint(20) NOT NULL,
        `date_create` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY (`ID`),
        KEY `no_task_id` (`no_task_id`),
      ) $charset_collate;";

    $wpdb->query( $sql );

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    return true;
  }
}