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
                'category_name' => 'vystavka',
                'order' => 'ASC'
              ]);
              //Проверяем есть ли посты
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
        <section class="poster">
          <h1>Афиша</h1>
          <div class="poster-tabs">
              <div>Текущие</div>
              <div>Будущие</div>
              <div>Предыдущие</div>
            </div>
          <div class="poster-posts">
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
            <div class="poster-posts-content">
              <a href="<?=get_the_permalink()?>" class="poster-posts-permalink">
                <img src="<?php if( has_post_thumbnail() ) the_post_thumbnail_url();
                  else echo get_template_directory_uri().'/assets/images/img-default.png';
                ?>" alt="<?php the_title()?>" class="poster-posts-thumb" />
              </a>
              <div class="poster-posts-excerpt"><?php the_excerpt()?></div>
              <a href="<?=get_permalink()?>" class="poster-posts-permalink">
                <h4 class="poster-posts-title"><?php the_title()?></h4>
              </a>
            </div>
            <?php } ?>
          </div>
          <!-- /.poster-posts -->
          <?php foreach (get_the_category() as $category) {
            printf(
              '<a href="%s" class="button-link">Вся %s</a>',
              esc_url(get_category_link($category)),
              esc_html($category->name)
            ); }
          } else _e('Posts not found.', 'museum');
          wp_reset_postdata(); // Сбрасываем $post
          ?>
        </section>
        <!-- /.poster -->
        <section class="programs">
          <h2>Образовательные программы</h2>
          <!-- Slider main container -->
          <div class="swiper-container programs-slider">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
              <?php
              global $post;
              //Формируем запрос в БД
              $query = new WP_Query([
                'posts_per_page' => 7,
                'category_name' => 'programmy',
                'order' => 'ASC'
              ]);
              //Проверяем есть ли посты
              $i = 1;
              if ($query->have_posts()) {
                while ($query->have_posts()) {
                  $query->the_post();?>
              <!-- Slides -->
              <div class="swiper-slide" data-num="<?=$i++?>">
                <div class="programs-article-post">
                  <img src="<?php
                    if( has_post_thumbnail() ) echo get_the_post_thumbnail_url();
                    else echo get_template_directory_uri().'/assets/images/img-default.png';
                  ?>" alt="<?php the_title()?>">
                  <div class="programs-article-text">
                    <h3 class="programs-article-title"><?php the_title()?></h3>
                    <?php the_content() ?>
                  </div>
                </div>
              </div>
              <?php }
              } else _e('Posts not found.', 'museum');?>
            </div>
            <div class="swiper-button-arr">
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-arr-num"><sapn class="swiper-num-area"></sapn></div>
              <div class="swiper-button-next"></div>
            </div>
          </div>
          <?php foreach (get_the_category() as $category) {
            printf(
              '<a href="%s" class="button-link">Все %s</a>',
              esc_url(get_category_link($category)),
              esc_html($category->name)
            );
          }
          wp_reset_postdata(); // Сбрасываем $post
          ?>
        </section>
        <!-- /.programs -->
      <section class="news">
          <h2>События</h2>
          <div class="news-posts">
            <?php
            global $post;

            $myposts = get_posts([
              'numberposts' => 3,
              'category_name' => 'sobytiya',
              'order' => 'ASC'
            ]);

            if ($myposts) {
              $cnt=1;
              foreach ($myposts as $post) {
                setup_postdata($post);
                if($cnt == 1){?>
            <div class="news-posts-content item-<?=$cnt++?>">
              <a href="<?=get_the_permalink()?>" class="news-posts-permalink">
                <img src="<?php if( has_post_thumbnail() ) the_post_thumbnail_url();
                  else echo get_template_directory_uri().'/assets/images/img-default.png';
                ?>" alt="<?php the_title()?>" class="news-posts-thumb" />
              </a>
              <span class="date"><?php the_time('j F Y')?></span>
              <a href="<?=get_permalink()?>" class="news-posts-permalink">
                <h4 class="news-posts-title"><?php the_title()?></h4>
              </a>
              <div class="news-posts-text"><?php the_content()?></div>
            </div>            
            <?php }else{ ?>
            <div class="news-posts-content item-<?=$cnt++?>">
              <a href="<?=get_the_permalink()?>" class="news-posts-permalink">
                <img src="<?php if( has_post_thumbnail() ) the_post_thumbnail_url();
                  else echo get_template_directory_uri().'/assets/images/img-default.png';
                ?>" alt="<?php the_title()?>" class="news-posts-thumb" />
              </a>
              <span class="date"><?php the_time('j F Y')?></span>
              <a href="<?=get_permalink()?>" class="news-posts-permalink">
                <h3 class="news-posts-title"><?php the_title()?></h3>
              </a>
            </div>
            <?php }
            } ?>
          </div>
          <!-- /.news-posts -->
          <?php foreach (get_the_category() as $category) {
            printf(
              '<a href="%s" class="button-link">Все %s</a>',
              esc_url(get_category_link($category)),
              esc_html($category->name)
            ); }
          } else _e('Posts not found.', 'museum');
          wp_reset_postdata(); // Сбрасываем $post
          ?>
        </section>
        <!-- /.news -->
      </div>
    </main>
<?php get_footer(); ?>
