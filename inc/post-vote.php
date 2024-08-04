<?php 

// Віддаєм кількість голосів
function get_vote_count($post_id, $current_meta) {
  $sum_vote = 0;

  $translate_meta = $current_meta.$post_id;
  $get_post_meta = get_post_meta( $post_id, $translate_meta, true );
  $current_meta_result = $get_post_meta ? $get_post_meta : '0';
  $sum_vote = $sum_vote + $current_meta_result;
  return $sum_vote;
}

function post_vote_function() {
  //Получаем данные
  $post_id = stripslashes_deep($_POST['postId']);
  $item_meta = stripslashes_deep($_POST['itemMeta']);
  $current_meta = $item_meta . $post_id;
  
  //Обновляем мета данные
  if ( metadata_exists( 'post', $post_id, $current_meta ) ) {
    $count_value = get_post_meta( $post_id, $current_meta, true );
    $count_value = $count_value + 1;
    update_post_meta( $post_id, $current_meta, $count_value );
  } else {
    add_post_meta( $post_id, $current_meta, 1, true); 
  } 

  $sum_count = get_vote_count($post_id, $item_meta);

  echo $sum_count;
  wp_die();
}

add_action('wp_ajax_vote_post_click_action', 'post_vote_function');
add_action('wp_ajax_nopriv_vote_post_click_action', 'post_vote_function');

?>