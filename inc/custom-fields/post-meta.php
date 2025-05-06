<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_post_theme_options' );
function crb_post_theme_options() {
  Container::make( 'post_meta', 'More' )
    ->where( 'post_type', '=', 'tasks' )
    ->add_fields( array(
      Field::make( 'checkbox', 'crb_tasks_accept', 'Заявка прийнята' ),
      Field::make( 'checkbox', 'crb_tasks_complete', 'Завдання виконано' ),
      Field::make( 'text', 'crb_tasks_id', 'ID' ),
      Field::make( 'text', 'crb_tasks_date_create', 'Коли створена заявка' ),
      Field::make( 'text', 'crb_tasks_site', 'Сайт' ),
      Field::make( 'text', 'crb_tasks_anchors', 'Анкори/Посилання' ),
      Field::make( 'text', 'crb_tasks_author', 'Автор' ),
      Field::make( 'text', 'crb_tasks_author_date', 'Коли передано автору' ),
      Field::make( 'text', 'crb_tasks_status', 'Статус' ),
      Field::make( 'text', 'crb_tasks_post_link', 'Посилання на статтю' ),
      Field::make( 'text', 'crb_tasks_link_date', 'Коли додано посилання' ),
      Field::make( 'text', 'crb_tasks_pay', 'Оплата' ),
  ) );
  Container::make( 'post_meta', 'More' )
    ->where( 'post_type', '=', 'todo' )
    ->add_fields( array(
      Field::make( 'text', 'crb_todo_from', 'Від кого' ),
      Field::make( 'textarea', 'crb_todo_task', 'Завдання' ),
      Field::make( 'textarea', 'crb_todo_answer', 'Відповідь' ),
      Field::make( 'text', 'crb_todo_status', 'Статус' ),
      Field::make( 'text', 'crb_todo_price', 'Вартість' ),
      Field::make( 'text', 'crb_todo_pay', 'Оплата' ),
  ) );
  Container::make( 'post_meta', 'More' )
    ->where( 'post_type', '=', 'websites' )
    ->add_fields( array(
      Field::make( 'text', 'crb_websites_orders', 'Замовлень' ),
      Field::make( 'text', 'crb_websites_dr', 'DR' ),
      Field::make( 'text', 'crb_websites_keywords', 'Keywords' ),
      Field::make( 'text', 'crb_websites_tf', 'TF' ),
      Field::make( 'text', 'crb_websites_cf', 'CF' ),
      Field::make( 'text', 'crb_websites_ga', 'GA' ),
      Field::make( 'text', 'crb_websites_gsc', 'GSC' ),
      Field::make( 'text', 'crb_websites_colbr_rating', 'КолабРейтинг' ),
      Field::make( 'text', 'crb_websites_colbr_position', 'КолабПозиція' ),
      Field::make( 'separator', 'crb_separator', __( 'Інше' ) ),
      Field::make( 'select', 'crb_websites_gruop', __( 'Группа/Аккаунт' ) )
      ->set_options( array(
        'account_color_one' => 'Перший',
        'account_color_two' => 'Другий',
        'account_color_three' => 'Третій',
        'account_color_new' => 'Наповнненя',
      ) ),
      Field::make( 'text', 'crb_websites_number', 'Порядок для експорта' ),
  ) );
  Container::make( 'post_meta', 'More' )
    ->where( 'post_type', '=', 'drops' )
    ->add_fields( array(
      Field::make( 'text', 'crb_drops_dr', 'DR' ),
      Field::make( 'text', 'crb_drops_tf', 'TF' ),
      Field::make( 'text', 'crb_drops_cf', 'CF' ),
      Field::make( 'text', 'crb_drops_expired', 'Expired' ),
      Field::make( 'association', 'crb_drops_websites', 'Сайти')
      ->set_types( array(
        array(
          'type'      => 'post',
          'post_type' => 'websites',
        )
      ) )
      // Field::make( 'text', 'crb_websites_week', 'Update Week' ),
  ) );
  
}

?>