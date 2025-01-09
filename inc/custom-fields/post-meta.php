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
      // Field::make( 'text', 'crb_websites_week', 'Update Week' ),
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