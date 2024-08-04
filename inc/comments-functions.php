<?php

// Меняем поля в форме комментиривания
add_filter( 'comment_form_default_fields', 'truemisha_change_labels', 25 );
function truemisha_change_labels( $fields ){
 
  // можно подсмотреть исходный HTML через:
  // print_r( $fields );

  $fields[ 'author' ] = '<div class="mb-4"><input id="author" name="author" type="text" value="" size="30" maxlength="245" required="required" placeholder="'. __("Ім'я", "treba-wp") . '" class="w-full border border-main-border rounded px-4 py-2"></div>';
 
  return $fields;
 
}

// Удаляем поля из формы комментирования
add_filter( 'comment_form_default_fields', 'truemisha_remove_url_field', 25 );
 
function truemisha_remove_url_field( $fields ) {
  unset( $fields[ 'url' ] );
  unset( $fields[ 'email' ] );
  unset( $fields[ 'cookies' ] );
  return $fields;
}

// Меняем textarea в форме комментариования
add_filter( 'comment_form_defaults', 'remove_textarea' );
add_action( 'comment_form_top', 'add_textarea' );

function remove_textarea($defaults)
{
    $defaults['comment_field'] = '';
    return $defaults;
}

function add_textarea()
{
    echo '<div class="comment-form-comment mb-2"><textarea id="comment" name="comment" rows="4" placeholder="'. __("Ваш коментар", "treba-wp") . '" aria-required="true" class="w-full border border-main-border rounded px-4 py-2 mb-2"></textarea></div>';
}

//Удаляем нотис перед формой комментирования
add_filter( 'comment_form_defaults', 'sp_add_comment_form_before' );
function sp_add_comment_form_before( $defaults ) {
  $defaults['comment_notes_before'] = '';
  return $defaults;
}