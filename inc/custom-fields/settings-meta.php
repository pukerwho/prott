<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
  Container::make( 'theme_options', __('Штаб') )
  ->add_tab( __('Загальні'), array(
    Field::make( 'text', 'crb_collab_one', 'Для коллаборатора аккаунт 1' ),
    Field::make( 'text', 'crb_collab_two', 'Для коллаборатора аккаунт 2' ),
    Field::make( 'text', 'crb_telegram_api', 'Telegram Апі' ),
    Field::make( 'text', 'crb_telegram_chat_id', 'Telegram Чат айді' ),
    Field::make( 'text', 'crb_test', 'test' ),
    Field::make( 'text', 'crb_chart_week', 'Chart Week' ),
    Field::make( 'text', 'crb_chart_week_drops', 'Chart Week For Drops' ),
    
  ))
  ->add_tab( __('Скрипты'), array(
    Field::make( 'textarea', 'crb_google_analytics', 'Google Analytics' ),
    Field::make( 'footer_scripts', 'crb_footer_scripts', 'Скрипты в футере' ),
    
  ));
}

?>