<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
if (!is_user_logged_in()) {
  wp_die('Доступ заборонено. Увійдіть у свій обліковий запис.');
}

$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
$slug = isset($_GET['task_slug']) ? preg_replace('/[^a-z0-9_\-]/i', '', $_GET['task_slug']) : 'images';
$domain = isset($_GET['task_domain']) ? preg_replace('/[^a-z0-9_\-\.]/i', '', $_GET['task_domain']) : 'domain';
$domain_part = explode('.', $domain);
$domain = $domain_part[0];
if (!$post_id) wp_die('Невірний ID');

$html = get_post_meta($post_id, '_crb_tasks_html', true);
if (!$html) wp_die('HTML не знайдено');

preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $matches);
$image_urls = array_filter($matches[1], function($url) {
  return filter_var($url, FILTER_VALIDATE_URL);
});

if (empty($image_urls)) wp_die('Зображень не знайдено');

$tmp_dir = sys_get_temp_dir() . '/images_' . $post_id . '_' . uniqid();
if (!mkdir($tmp_dir, 0777, true)) {
  wp_die('Не вдалося створити тимчасову папку');
}

$context = stream_context_create([
  'http' => ['timeout' => 10]
]);

foreach ($image_urls as $index => $url) {
    $i = $index + 1;
  $img_data = @file_get_contents($url, false, $context);
  if ($img_data && strlen($img_data) > 100) {
    $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
    $ext = $ext ?: 'jpg';
    $filename = "{$slug}-{$i}-{$domain}.{$ext}";
    file_put_contents($tmp_dir . "/$filename", $img_data);
  }
}

$zip_path = $tmp_dir . '.zip';
$zip = new ZipArchive();
if ($zip->open($zip_path, ZipArchive::CREATE) !== TRUE) {
  wp_die('Не вдалося створити ZIP-архів');
}

foreach (glob("$tmp_dir/*") as $file) {
  $zip->addFile($file, basename($file));
}
$zip->close();

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="images_' . $post_id . '.zip"');
header('Content-Length: ' . filesize($zip_path));
ob_clean();
while (ob_get_level()) {
  ob_end_clean();
}
flush();
readfile($zip_path);

// Чистка
foreach (glob("$tmp_dir/*") as $file) {
  unlink($file);
}
rmdir($tmp_dir);
unlink($zip_path);
exit;