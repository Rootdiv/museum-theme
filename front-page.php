<?php get_header(); ?>
    <main>
      <div class="container">
        <section class="hero">
          <!-- Slider main container -->
          <div class="swiper-container hero-slider">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
              <?php
              global $post;
              //Формируем запрос в БД
              $query = new WP_Query([
                'posts_per_page' => 7,
                'category_name' => 'sobytiya',
                'order' => 'ASC'
              ]);
              //Проверяем есть ли посты
              global $i;
              $i = 1;
              if ($query->have_posts()) {
                while ($query->have_posts()) {
                  $query->the_post();?>
              <!-- Slides -->
              <div class="swiper-slide" data-num="<?=$i++?>">
                <div class="article-post">
                  <img src="<?php
                    if( has_post_thumbnail() ) echo get_the_post_thumbnail_url();
                    else echo get_template_directory_uri().'/assets/images/img-default.png';
                  ?>" alt="<?php the_title()?>">
                  <a class="article-permalink" href="<?=get_the_permalink()?>">
                    <h4 class="article-title"><?php the_content() ?></h4>
                  </a>
                  <a class="article-btn" href="#">Купить билет</a>
                </div>
              </div>
              <?php }
              } else _e('Posts not found.', 'museum');
              wp_reset_postdata(); // Сбрасываем $post
              ?>
            </div>
            <div class="swiper-button-arr">
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-arr-num"><sapn class="swiper-num-area"></sapn></div>
              <div class="swiper-button-next"></div>
            </div>
          </div>
        </section>
        <!-- /.hero -->
        <section class="afisha">
          <?php foreach (get_the_category() as $category) {
              echo '<h1>'.esc_html($category->name).'</h1>';
          }?>
          <div class="afisha-tabs">
              <div>Текущие</div>
              <div>Будущие</div>
              <div>Предыдущие</div>
            </div>
          <div class="afisha-posts">
            <?php
            global $post;

            $myposts = get_posts([
              'numberposts' => 6,
              'category_name' => 'afisha',
              'order' => 'ASC'
            ]);

            if ($myposts) {
              foreach ($myposts as $post) {
                setup_postdata($post);?>
            <div class="afisha-posts-content">
              <a href="<?=get_the_permalink()?>" class="afisha-posts-permalink">
                <img src="<?php if( has_post_thumbnail() ) the_post_thumbnail_url();
                  else echo get_template_directory_uri().'/assets/images/img-default.png';
                ?>" alt="<?php the_title()?>" class="afisha-posts-thumb" />
              </a>
              <div class="afisha-posts-excerpt"><?php the_excerpt()?></div>
              <a href="<?=get_permalink()?>" class="afisha-posts-permalink">
                <h4 class="afisha-posts-title"><?php the_title()?></h4>
              </a>
            </div>
            <?php }
            }
            wp_reset_postdata(); // Сбрасываем $post
            ?>
          </div>
          <!-- /.afisha-posts -->
          <?php foreach (get_the_category() as $category) {
            printf(
              '<a href="%s" class="afisha-link">Вся %s</a>',
              esc_url(get_category_link($category)),
              esc_html($category->name)
            );
          }?>
        </section>
        <!-- /.afisha -->
      </div>
    </main>
<?php get_footer(); ?>
