<?php if ( post_password_required() ) {
	return;
} ?>

<div id="comments">
	<?php

		$post__in = get_the_ID();
		$args = array(
			'post__in' => $post__in,
			'status' => 'approve'
		);

		$comments = get_comments( $args );
	?>
	
	<?php the_comments_navigation(); ?>
	
		<div class="">
			<?php
			wp_list_comments(
				array(
					'callback'   => 'my_comment',
					'type'       => 'comment',
					'style'      => 'div',
					'short_ping' => true,
				), $comments
			);
			?>
		</div>

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p><?php esc_html_e( 'Comments are closed.', 'g-info' ); ?></p>
			<?php
		endif;

	
	?>

	<div class="">
		<?php
		comment_form(array(
			'title_reply' => '',
			'class_submit' => 'bg-main-blue text-center text-white rounded cursor-pointer px-6 py-2'
		));
		?>	
	</div>

</div><!-- #comments -->


<!-- Функция вывода комментария -->

<?php function my_comment( $comment, $args, $depth ) {

	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}

	$classes = ' ' . comment_class( empty( $args['has_children'] ) ? '' : 'parent mb-4', null, null, false );
	?>

	<<?php echo $tag, $classes; ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) { ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
	} ?>
	<div class="comment-item py-4">
    <div class="px-4">
      <div class="flex items-center mb-1">
        <div class="comment-author mr-2">
          <?php printf(__( '<span class="font-semibold">%s</span>' ), get_comment_author_link()); ?>
        </div>
        <div>
          <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>" class="text-sm text-gray-600 hover:text-main-blue">
            <?php 
              $d = "jS F Y H:i";
              $comment_ID = $comment->comment_ID;
              $comment_date = get_comment_date( $d, $comment_ID );
              echo $comment_date;
            ?>
          </a>
        </div>
      </div>

      <div class="comment-content mb-1">
        <?php comment_text(); ?>	
      </div>
      
      <?php if ( $comment->comment_approved == '0' ) { ?>
        <em class="comment-awaiting-moderation">
          <?php _e( 'Ваш коментар на модерації'); ?>
        </em><br/>
      <?php } ?>

      <div class="comment-meta flex items-center">

        <div class="font-semibold uppercase reply">
          <?php
          comment_reply_link(
            array_merge(
              $args,
              array(
                'add_below' => $add_below,
                'depth'     => $depth,
                'max_depth' => $args['max_depth']
              )
            )
          ); ?>
        </div>

        <div class="ml-4">
          <?php edit_comment_link( __( '(Edit)' ), '  ', '' ); ?>	
        </div>

      </div>
    </div>
		
	</div>

	<?php if ( 'div' != $args['style'] ) { ?>
		</div>
	<?php }
} ?>