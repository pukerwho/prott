<?php
function justread_filter_achive( $query ) {
  if (is_page('old')) {

    $meta_query = ['relation' => 'AND'];

    if (isset($_GET['filter-site']) && $_GET['filter-site'] !== 'All') {
      $meta_query[] = array(
        'key' => '_crb_tasks_site',
        'value' => $_GET['filter-site'],
        'compare' => 'LIKE'
      );
    }

    if (isset($_GET['filter-author']) && $_GET['filter-author'] !== 'All') {
      $meta_query[] = array(
        'key' => '_crb_tasks_author',
        'value' => $_GET['filter-author'],
        'compare' => 'LIKE'
      );
    }
    if (!empty($_GET['task_id'])) {
      $meta_query[] = array(
        'key' => '_crb_tasks_id',
        'value' => $_GET['task_id'],
        'compare' => 'LIKE'
      );
    }

    $query->set('meta_query', $meta_query);

    // if (isset($_GET['article_orderby']) && $_GET['article_orderby'] !== 'All') {
    //   $query->set('meta_key', $_GET['article_orderby']);
    //   $query->set('orderby', 'meta_value_num');
    // }

    // $query->set('posts_per_page', isset($_GET['article_perpage']) ? (int)$_GET['article_perpage'] : 20);

    return $query;
  }
}
add_action( 'pre_get_posts','justread_filter_achive');