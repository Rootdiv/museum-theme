<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header class="header">
      <div class="container">
        <div class="header-wrapper">
          <?php
            locate_template('logo.php', true); //Подключаем лого с помощью функции require_once;
            
            wp_nav_menu( [
              'theme_location'  => 'header_menu',
              'container'       => 'nav', 
              'container_class' => 'header-nav', 
              'menu_class'      => 'header-menu', 
              'echo'            => true
            ] );
          ?>
          <a href="#" class="header-menu-toggle">
            <span></span>
            <span></span>
            <span></span>
          </a>
        </div>
      </div>
    </header>
    <div class="go-top"><b>&uarr;</b></div>
