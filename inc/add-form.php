<?php 
function telegramMessage() {
  $title = stripslashes_deep($_POST['title']);
  $city = stripslashes_deep($_POST['city']);
  $email = stripslashes_deep($_POST['email']);
  $phone = stripslashes_deep($_POST['phone']);
  $address = stripslashes_deep($_POST['address']);
  $menu = stripslashes_deep($_POST['menu']);
  $price = stripslashes_deep($_POST['price']);
  $parkingCheckbox = stripslashes_deep($_POST['parkingCheckbox']);
  $wifiCheckbox = stripslashes_deep($_POST['wifiCheckbox']);
  $banketCheckbox = stripslashes_deep($_POST['banketCheckbox']);
  $menuCheckbox = stripslashes_deep($_POST['menuCheckbox']);
  $summerCheckbox = stripslashes_deep($_POST['summerCheckbox']);
  $musicCheckbox = stripslashes_deep($_POST['musicCheckbox']);
  $hookanCheckbox = stripslashes_deep($_POST['hookanCheckbox']);
  $vipCheckbox = stripslashes_deep($_POST['vipCheckbox']);
  $biznesCheckbox = stripslashes_deep($_POST['biznesCheckbox']);
  $deliveryCheckbox = stripslashes_deep($_POST['deliveryCheckbox']);
  $kidsCheckbox = stripslashes_deep($_POST['kidsCheckbox']);
  $corpCheckbox = stripslashes_deep($_POST['corpCheckbox']);
  $weddingCheckbox = stripslashes_deep($_POST['weddingCheckbox']);
  $cardCheckbox = stripslashes_deep($_POST['cardCheckbox']);

  $chatID = carbon_get_theme_option("crb_telegram_chat_id");
  $apiToken = carbon_get_theme_option("crb_telegram_api");
  $content = "";
  $content .= "<b>Заклад</b>: $title\n";
  $content .= "<b>Місто</b>: $city\n";
  $content .= "<b>Email</b>: $email\n";
  $content .= "<b>Телефон</b>: $phone\n";
  $content .= "<b>Адреса</b>: $address\n";
  $content .= "<b>Меню</b>: $menu\n";
  $content .= "<b>Середній чек</b>: $price\n";
  $content .= "<b>Паркінг</b>: $parkingCheckbox\n";
  $content .= "<b>Wi-fi</b>: $wifiCheckbox\n";
  $content .= "<b>Банкет</b>: $banketCheckbox\n";
  $content .= "<b>Онлайн меню</b>: $menuCheckbox\n";
  $content .= "<b>Літній майданчик</b>: $summerCheckbox\n";
  $content .= "<b>Жива музика</b>: $musicCheckbox\n";
  $content .= "<b>Кальян</b>: $hookanCheckbox\n";
  $content .= "<b>VIP-кімната</b>: $vipCheckbox\n";
  $content .= "<b>Бізнес ланч</b>: $biznesCheckbox\n";
  $content .= "<b>Доставка</b>: $deliveryCheckbox\n";
  $content .= "<b>Дитяча кімната</b>: $kidsCheckbox\n";
  $content .= "<b>Корпоративи</b>: $corpCheckbox\n";
  $content .= "<b>Весілля</b>: $weddingCheckbox\n";
  $content .= "<b>Безготівковий розрахунок</b>: $cardCheckbox\n";
  $data = [
    'chat_id' => $chatID, 
    'text' => $content,
    'parse_mode' => 'HTML'
  ];
  $response = file_get_contents("https://api.telegram.org/bot".$apiToken."/sendMessage?" . http_build_query($data) );
  echo "yes";
  wp_die();
}

add_action('wp_ajax_telegram_add_action', 'telegramMessage');
add_action('wp_ajax_nopriv_telegram_add_action', 'telegramMessage');
?>