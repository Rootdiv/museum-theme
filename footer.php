    <footer class="footer">
      <div class="container">
        <div class="footer-info">
          <div class="footer-logo">
            <?php locate_template('logo.php', true, false); //Подключаем лого с помощью функции require;?>
          </div>
          <?php
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
