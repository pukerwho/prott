<?php 

function links_activated() {
  global $wpdb;

  $charset_collate = $wpdb->get_charset_collate();

  if($wpdb->get_var("SHOW TABLES LIKE 'perelinkovka_footer'") != 'perelinkovka_footer') {
    $sql = "CREATE TABLE `perelinkovka_footer` (
        `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `post_URL` varchar(255) NOT NULL,
        `top_links` varchar(255) NOT NULL,
        `q_links` varchar(255) NOT NULL,
        `date_create` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY (`ID`),
        KEY `post_URL` (`post_URL`),
        KEY `top_links` (`top_links`)
      ) $charset_collate;";

    $wpdb->query( $sql );

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    return true;
  }
}

links_activated();


function get_post_keywords() {
  $posts_links_array = array();
  $posts_url_array = array();
  $count_post_in_array = 6;

  $footer_post_args = array('numberposts' => -1);
  $footer_posts = get_posts($footer_post_args);
  shuffle($footer_posts);
  foreach ($footer_posts as $post) {
    if (count($posts_links_array) < $count_post_in_array) {
      $post_id = $post->ID;
      $post_keywords = get_post_meta($post_id, '_crb_post_keywords', true);
      if ($post_keywords) {
        $post_url = get_the_permalink($post->ID);
        $post_keywords_array = explode(",", $post_keywords);
        shuffle($post_keywords_array);
        foreach ($post_keywords_array as $keyword) {
          $keyword = trim($keyword);
          $ahref = '<a href="'.$post_url.'">'.$keyword.'</a>';
          if (!in_array($post_url, $posts_url_array)) {
            array_push($posts_links_array, $ahref); 
            array_push($posts_url_array, $post_url);
          } 
        }
      }
    } else {
      return $posts_links_array;
    }
  }
  return $posts_links_array;
}

function get_term_keywords() {
  $terms_links_array = array();
  $terms_url_array = array();
  $count_term_in_array = get_option( '_crb_footer_links_numbers' );;
  $cities = get_terms(  array('taxonomy' => 'city') );
  shuffle( $cities );
  
  foreach ($cities as $city) {
    if (count($terms_links_array) < $count_term_in_array) {
      $city_id = $city->term_id;
      $term_keywords = get_term_meta($city_id, '_crb_category_keywords', true);
      
      if ($term_keywords) {
        $term_url = get_term_link($city->term_id, 'city');
        $term_keywords_array = explode(",", $term_keywords);
        shuffle($term_keywords_array);
        $keyword = $term_keywords_array[0];
        $keyword = trim($keyword);
        $ahref = '<a href="'.$term_url.'">'.$keyword.'</a>';
        if (!in_array($term_url, $terms_url_array)) {
          array_push($terms_links_array, $ahref); 
          array_push($terms_url_array, $term_url); 
        }
      }
    } else {
      return $terms_links_array;
    }
  }
  return $terms_links_array;
  
}

function prepare_links() {  
  $get_posts_links = get_post_keywords();
  // $get_terms_links = get_term_keywords();
  // $all_links = array_merge($get_posts_links, $get_terms_links); 
  return $get_posts_links;
}

function check_links($post_URL) {
  global $wpdb;
  $check_footer_links = $wpdb->get_results(
    "
      SELECT ID
      FROM perelinkovka_footer
      WHERE post_URL = '$post_URL'
    "
  );
  return $check_footer_links;
}

function save_links($id) {
  global $wpdb;
  $links = prepare_links();
  foreach($links as $link) {
    $wpdb->query( $wpdb->prepare( 
      "
        INSERT INTO perelinkovka_footer
        ( post_URL, top_links )
        VALUES ( %s, %s)
      ",
      array(
        $id, 
        $link, 
      )
    ) );
  }
}

function get_footer_links($id) {
  global $wpdb;
  
  $current_top_links = $wpdb->get_results("SELECT top_links FROM perelinkovka_footer WHERE post_URL = '$id'");
  return $current_top_links;
}

function footer_links($id) {
  $has_links = check_links($id);
	if ( empty( $has_links ) ) {
    save_links($id);
  } 
  $get_links = get_footer_links($id);
  return $get_links;
}

?>