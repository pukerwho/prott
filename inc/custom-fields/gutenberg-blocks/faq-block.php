<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( 'TREBA FAQ Block' )
	->add_fields( array(
		Field::make( 'complex', 'crb_block_faq', 'FAQ' )->add_fields( array(
      Field::make( 'text', 'crb_block_faq_question', 'Вопрос' ),
      Field::make( 'textarea', 'crb_block_faq_answer', 'Ответ' ),
    )),
	) )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
		?>
    
    <div id="citylist-faq" class="mb-6">
      <div>
        <div itemscope itemtype="https://schema.org/FAQPage">
          <?php 
            $post_faqs = $fields['crb_block_faq']; 
            foreach( $post_faqs as $post_faq ):
          ?>
            <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="content border-b border-gray-200 pb-4 mb-4 last-of-type:border-none last-of-type:pb-0 last-of-type:mb-0">
              <div class="text-lg font-bold mb-2" itemprop="name"><?php echo $post_faq['crb_block_faq_question']; ?></div>
              <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="font-light">
                <p itemprop="text"><?php echo $post_faq['crb_block_faq_answer']; ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

		<?php
	} );