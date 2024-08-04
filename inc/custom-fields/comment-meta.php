<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'comment_meta', 'Comment Information' )
->add_fields( array(
  Field::make( 'radio', 'crb_comment_rating', 'Rating' )->set_options( array(
		'5' => 5,
		'4' => 4,
		'3' => 3,
		'2' => 2,
		'1' => 1,
	) ),
) );
?>