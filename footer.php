    <footer class="footer">
      <div class="container">
        <div class="footer-info">
          <?php if(!is_front_page()) $home =  ' href="'.home_url('/').'"'; else $home = '';
            if(has_custom_logo()){
              echo '<a'.$home.'>
                <div class="logo">'. get_custom_logo( ).'
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
            
            wp_nav_menu([
              'theme_location'  => 'footer_menu',
              'container'       => 'nav',
              'container_class' => 'footer-nav-wrapper',
              'menu_class'      => 'footer-nav', 
              'echo'            => true
            ]);?>
            <?php dynamic_sidebar( 'sidebar-footer' ); ?>
            <div class="footer-contacts">
              <?php dynamic_sidebar( 'sidebar-contacts' );
              $email = get_field('email', 49);
              echo '<div class="email">
                <img src="'.get_template_directory_uri().'/assets/images/email.svg" alt="E-mail" />
                <a href="mailto:'.$email.'">'.$email.'</a>
              </div>';
            ?>
            </div>
        </div>
        <!-- /.footer-info -->
        <div class="footer-text-wrapper">
          <span class="footer-copyright">
            <?php echo get_bloginfo('description') .' &copy; '.  date('Y') . '.';?>
          </span>
          <?php dynamic_sidebar( 'sidebar-footer-text' ); ?>
        </div>
        <!-- /.footer-text-wrapper -->
      </div>
      <!-- /.container -->
    </footer>
    <?php wp_footer(); ?>
  </body>
</html>
