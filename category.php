<?php get_header()?>
  <main>
    <div class="container">
      <?php if ( function_exists( 'the_breadcrumbs' ) ) the_breadcrumbs(); ?>
      <section class="category-wrapper">
        <div class="category-list">
          <?php while ( have_posts() ){ the_post(); ?>
            <a href="<?=get_permalink()?>" class="category-card">
              <img src="<?php if( has_post_thumbnail() ) the_post_thumbnail_url(null, 'thumbnail');
                  else echo get_template_directory_uri().'/assets/images/img-default.png';
                ?>" alt="<?php the_title()?>"  class="category-card-thumb" />
              <div class="category-card-text">
                <h2 class="category-card-title"><?php the_title()?></h2>
                <p><?php the_excerpt()?></p>
              </div>
            </a>
            <!-- /.category-card -->
          <?php } ?>
          <?php if ( ! have_posts() ){ ?>
            <div class="category-list-none"><?php _e('Posts not found.', 'universal')?></div>
          <?php } ?>
        </div>
        <!-- /.category-list -->
        <?php locate_template('pagination.php', true); ?>
      </section>
      <!-- /.category-wrapper -->
    </div>
    <!-- /.container -->
  </main>
<?php get_footer()?>
