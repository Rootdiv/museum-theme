<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <!-- Шапка поста -->
  <header class="entry-header <?=get_post_type()?>-header">
		<div class="container">
      <?php if ( function_exists( 'the_breadcrumbs' ) ) the_breadcrumbs(); ?>
      <div class="post-header">
        <?php //Проверяем точно ли мы на странице поста
        if ( is_singular() ) :
          the_title( '<h1 class="post-header-title">', '</h1>' );
        else :
          the_title( '<h1 class="post-header-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
        endif;?>
        <span><?php the_time('j F Y')?></span>
      </div>
      <!-- /.post-header -->
    </div>
	</header><!-- /Шапка поста -->
  <div class="container">
    <!-- Содержимое поста -->
    <div class="post-content-wrapper">
      <div class="post-image">
        <img src="<?php if( has_post_thumbnail() ) the_post_thumbnail_url();
        else echo get_template_directory_uri().'/assets/images/img-default.png';?>" alt="<?php the_title() ?>">
      </div>
      <div class="post-content">
        <?php //Содержимое поста
        the_content(
          sprintf(
            wp_kses(
              /* translators: %s: Name of current post. Only visible to screen readers */
              __( 'Continue reading <span class="screen-reader-text">"%s"</span>', 'museum' ),
              array(
                'span' => array(
                  'class' => array(),
                ),
              )
            ),
            wp_kses_post( get_the_title() )
          )
        );

        wp_link_pages(
          array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'museum' ),
            'after'  => '</div>',
          )
        );?>
      </div>
      <!-- /.post-content -->
    </div><!-- /Содержимое поста -->
    <!-- Подвал поста-->
    <footer class="entry-footer post-footer">
      <div class="post-social">
        <?php meks_ess_share(); //Поделится в соцсетях ?>
      </div>
      <div class="post-nav">
        <?php //Выводим ссылки на предыдущий и следующий пост
        the_post_navigation(
          array(
            'prev_text' => '<span class="post-nav-prev">
              <svg width="40" height="16" class="prev-icon">
                <use xlink:href="'. get_template_directory_uri() .'/assets/images/sprite.svg#arrow"></use>
              </svg>
            ' . esc_html__( 'Previous', 'museum' ) . '</span>',
            'next_text' => '<span class="post-nav-next">' . esc_html__( 'Following', 'museum' ) . '
              <svg width="40" height="16" class="prev-icon">
                <use xlink:href="'. get_template_directory_uri() .'/assets/images/sprite.svg#arrow"></use>
              </svg>
            </span>',
          )
        );?>
      </div>
    </footer><!-- /Подвал поста-->
  </div>
  <!-- /.container -->
  <div class="sidebar-post">
    <div class="container">
      <!-- Подключаем сайдбар -->
      <?php get_sidebar('articles') ?>
    </div>
    <!-- /.container -->
  </div>
  <!-- /.sidebar-post -->
</article>
