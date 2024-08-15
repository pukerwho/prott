<?php 

function taskFinishDate($author_date, $link_date) {
  $start = date("Y/m/d H:i:s", $author_date);
  $finish = date("Y/m/d H:i:s", $link_date);
  $start_datetime = new DateTime($start);
  $diff = $start_datetime->diff(new DateTime($finish)); 
  $hours = $diff->h;
  return $hours;
}

function taskContinueDate($author_date) {
  $start = date("Y/m/d H:i:s", $author_date);
  $start_datetime = new DateTime($start);
  $current_time = current_time( 'Y/m/d H:i:s' );
  $diff = $start_datetime->diff(new DateTime($current_time)); 
  $hours = $diff->h;
  return $hours;
}

?>