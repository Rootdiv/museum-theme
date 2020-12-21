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
                    <h1 class="article-title"><?php the_content() ?></h1>
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
      </div>
    </main>
<?php get_footer(); ?>
