<?php
/*
Template Name: Страница контактов
Template Post Type: page
*/

get_header();?>
<main>
  <section class="section">
    <div class="container">
      <?php if ( function_exists( 'the_breadcrumbs' ) ) the_breadcrumbs(); ?>
      <?php the_title('<h1 class="page-title">', '</h1>', true); ?>
      <h2 class="contacts-title"><?php _e('Feedback form', 'museum') ?></h2>
      <div class="contacts-wrapper">
        <!-- <form action="#" class="contacts-form" method="POST">
          <input name="contact_name" type="text" class="input contacts-input" placeholder="Ваше имя">
          <input name="contact_email" type="email" class="input contacts-input" placeholder="Ваш Email">
          <textarea name="contact_comment" id="" class="textarea contacts-textarea" placeholder="Ваш вопрос"></textarea>
          <button type="submit" class="button more">Отправить</button>
        </form> -->
        <?php //echo do_shortcode('[contact-form-7 id="155" title="Контактная форма" html_class="contacts-form"]') ?>
        <?php the_content() ?>
      </div>
      <!-- /.contacts-wrapper -->
    </div>
    <!-- /.container -->
  </section>
  <!-- /.section -->
</main>
<?php get_footer();
