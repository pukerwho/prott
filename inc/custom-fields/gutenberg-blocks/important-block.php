<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( 'TREBA Important Block' )
	->add_fields( array(
		Field::make( 'textarea', 'crb_post_important_block', 'Текст' ),
	) )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
		?>
    
    <div class="bg-emerald-100 border-l-8 border-emerald-500 rounded px-4 pl-4 lg:pl-8 py-4 mb-4">
      <div class="custom-style-text">
        <?php echo esc_html( $fields['crb_post_important_block'] ); ?>
      </div>
    </div>

		<?php
	} );