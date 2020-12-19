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
            $logo_img = '';
            if( $custom_logo_id = get_theme_mod('custom_logo') ){
              $logo_img = wp_get_attachment_image( $custom_logo_id, 'full', false, array(
                'class'    => 'custom-logo',
                'alt'      => get_bloginfo('name'),
                'itemprop' => 'logo',
              ) );
            }
            if(!is_front_page()) $home =  ' href="'.home_url('/').'"'; else $home = '';
            if(has_custom_logo()){
              echo '<a'.$home.'>
                <div class="logo">'.$logo_img.'
                  <div class="logo-name">
                    <span>'. get_bloginfo('name') . mb_strimwidth(get_bloginfo('description'), 16, 22, '') .'</span>
                    <h3>'.mb_strimwidth(get_bloginfo('description'), 38, 100, '').'</h3>
                  </div>
                </div>
              </a>';
            }else{
              echo '<a'.$home.'>
                <div class="logo-name">
                  <span>'. get_bloginfo('name') . mb_strimwidth(get_bloginfo('description'), 16, 22, '') .'</span>
                  <h3>'.mb_strimwidth(get_bloginfo('description'), 38, 100, '').'</h3>
                </div>
              </a>';
            }
            
            wp_nav_menu( [
              'theme_location'  => 'header_menu',
              'container'       => 'nav', 
              'container_class' => 'header-nav', 
              'menu_class'      => 'header-menu', 
              'echo'            => true,
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
