<?php 

// додаємо нові данні 
function website_add_function() {
  $post_id = $_POST['postId'];
  $meta_value = $_POST['metaValue'];
  $meta_crb = $_POST['metaCrb'];
  $today_date = $_POST['todayDate'];

  if ( metadata_exists( 'post', $post_id, $meta_crb ) ) {
    $meta_array = get_post_meta( $post_id, $meta_crb, true );
    $meta_array = $meta_array . ',' . $meta_value;
    update_post_meta( $post_id, $meta_crb, $meta_array );
  } else {
    add_post_meta( $post_id, $meta_crb, $meta_value, true ); 
  } 
  echo $post_id;
  wp_die();
}

add_action('wp_ajax_website_add_click_action', 'website_add_function');
add_action('wp_ajax_nopriv_website_add_click_action', 'website_add_function');

// оновлюємо сьогоднішні дані
function website_edit_function() {
  $post_id = $_POST['postId'];
  $meta_value = $_POST['metaValue'];
  $meta_crb = $_POST['metaCrb'];

  if ( metadata_exists( 'post', $post_id, $meta_crb ) ) {
    $meta_array = get_post_meta( $post_id, $meta_crb, true );
    $meta_array = $meta_array . ',' . $meta_value;
    update_post_meta( $post_id, $meta_crb, $meta_array );
  } else {
    add_post_meta( $post_id, $meta_crb, $meta_value, true ); 
  } 
  echo $post_id;
  wp_die();
}

add_action('wp_ajax_website_edit_click_action', 'website_edit_function');
add_action('wp_ajax_nopriv_website_edit_click_action', 'website_edit_function');


?>