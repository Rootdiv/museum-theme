<?php
//Добавление расширенных возможностей
if ( ! function_exists( 'museum_theme_setup' ) ) :

  function museum_theme_setup() {
    //Подключение файлов перевода
    load_theme_textdomain( 'museum', get_template_directory() . '/languages' );

    //Добавление тега title
    add_theme_support( 'title-tag' );

    //Добавление миниатюр
    add_theme_support( 'post-thumbnails', array( 'post' ) );

    //Добавление пользовательского логотипа
    add_theme_support( 'custom-logo', [
      'width'       => 250,
      'flex-height' => true,
      'header-text' => 'museum',
      'unlink-homepage-logo' => true // WP 5.5
    ] );

    //Регистрация меню
    register_nav_menus( [
      'header_menu' => __('Menu in header', 'museum'),
      'footer_menu' => __('Menu in footer', 'museum')
    ] );

  }
endif;
add_action( 'after_setup_theme', 'museum_theme_setup' );

/**
 * Подключение сайдбара.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function museum_theme_widgets_init() {

  register_sidebar(
    array(
      'name'          => esc_html__( 'Menu in footer', 'museum' ),
      'id'            => 'sidebar-footer',
      'description'   => esc_html__( 'Add menu here.', 'museum' ),
      'before_widget' => '<section id="%1$s" class="footer-menu %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="footer-menu-title">',
      'after_title'   => '</h2>'
    )
  );

  register_sidebar(
    array(
      'name'          => esc_html__( 'Text in footer', 'museum' ),
      'id'            => 'sidebar-footer-text',
      'description'   => esc_html__( 'Add text here.', 'museum' ),
      'before_widget' => '<section id="%1$s" class="footer-text %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '',
      'after_title'   => ''
    )
  );

  register_sidebar(
    array(
      'name'          => esc_html__( 'Contacts', 'museum' ),
      'id'            => 'sidebar-contacts',
      'description'   => esc_html__( 'Add widgets here.', 'museum' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>'
    )
  );

  register_sidebar(
    array(
      'name'          => esc_html__( 'Popular events', 'museum' ),
      'id'            => 'sidebar-articles',
      'description'   => esc_html__( 'Add widgets here.', 'museum' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );
}
add_action( 'widgets_init', 'museum_theme_widgets_init' );

/**
 * Добавление нового виджета WorkTime_Widget.
 */
class WorkTime_Widget extends WP_Widget {

  // Регистрация виджета используя основной класс
  function __construct() {
    // вызов конструктора выглядит так:
    // __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
    parent::__construct(
      'worktime_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: worktime_widget
      __('Schedule', 'museum'),
      array( 'description' => __('Schedule.', 'museum'), 'classname' => 'widget-worktime', )
    );

    // скрипты/стили виджета, только если он активен
    if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
      //add_action('wp_enqueue_scripts', array( $this, 'add_worktime_widget_scripts' ));
      add_action('wp_head', array( $this, 'add_worktime_widget_style' ) );
    }
  }

  /**
  * Вывод виджета во Фронт-энде
  *
  * @param array $args     аргументы виджета.
  * @param array $instance сохраненные данные из настроек
  */
  function widget( $args, $instance ) {
    $title = $instance['title'];
    $weekdays = $instance['weekdays'];
    $weekend = $instance['weekend'];

    echo $args['before_widget'];
    echo '<div class="widget-worktime-title">';
      echo '<img src="'.get_template_directory_uri().'/assets/images/clock.svg" alt="'. __('Schedule', 'museum') .'" />';
      if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
    echo '</div>';
    if ( ! empty( $weekdays ) ) echo '<p class="weekdays" >' . $weekdays . '</p>';
    if ( ! empty( $weekend ) ) echo '<p class="weekend" >' . $weekend . '</p>';
    echo $args['after_widget'];
  }

  /**
  * Админ-часть виджета
  *
  * @param array $instance сохраненные данные из настроек
  */
  function form( $instance ) {
    $title = @ $instance['title'] ?: __('Schedule', 'museum');
    $description = @ $instance['weekdays'] ?: __('Weekdays', 'museum');
    $link = @ $instance['weekend'] ?: __('Weekend', 'museum');

    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'museum'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
      <p>
      <label for="<?php echo $this->get_field_id( 'weekdays' ); ?>"><?php _e('Weekdays:', 'museum'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'weekdays' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>">
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e('Weekend:', 'museum'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'weekend' ); ?>" name="<?php echo $this->get_field_name( 'weekend' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
    </p>
    <?php
  }

  /**
  * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
  *
  * @see WP_Widget::update()
  *
  * @param array $new_instance новые настройки
  * @param array $old_instance предыдущие настройки
  *
  * @return array данные которые будут сохранены
  */
  function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['weekdays'] = ( ! empty( $new_instance['weekdays'] ) ) ? strip_tags( $new_instance['weekdays'] ) : '';
    $instance['weekend'] = ( ! empty( $new_instance['weekend'] ) ) ? strip_tags( $new_instance['weekend'] ) : '';

    return $instance;
  }

  // скрипт виджета
  function add_worktime_widget_scripts() {
  // фильтр чтобы можно было отключить скрипты
  if( ! apply_filters( 'show_worktime_widget_script', true, $this->id_base ) )
    return;

    $theme_url = get_stylesheet_directory_uri();

    wp_enqueue_script('worktime_widget_script', $theme_url .'/worktime_widget_script.js' );
  }

  // стили виджета
  function add_worktime_widget_style() {
    // фильтр чтобы можно было отключить стили
    if( ! apply_filters( 'show_worktime_widget_style', true, $this->id_base ) )
      return;
    ?>
    <style type="text/css">
      .worktime-widget a{ display:inline; }
    </style>
    <?php
  }
}
// конец класса WorkTime_Widget

// регистрация WorkTime_Widget в WordPress
function register_worktime_widget() {
  register_widget( 'WorkTime_Widget' );
}
add_action( 'widgets_init', 'register_worktime_widget' );

/**
 * Добавление нового виджета Social_Widget.
 */
class Social_Widget extends WP_Widget {

  // Регистрация виджета используя основной класс
  function __construct() {
    // вызов конструктора выглядит так:
    // __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
    parent::__construct(
      'social_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: foo_widget
      __('Social networks', 'museum'),
      array( 'description' => __('Links to social networks.', 'museum'), 'classname' => 'widget-social' )
    );

    // скрипты/стили виджета, только если он активен
    if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
      //add_action('wp_enqueue_scripts', array( $this, 'add_social_widget_scripts' ));
      add_action('wp_head', array( $this, 'add_social_widget_style' ) );
    }
  }

  /**
  * Вывод виджета во Фронт-энде
  *
  * @param array $args     аргументы виджета.
  * @param array $instance сохраненные данные из настроек
  */
  function widget( $args, $instance ) {
    $title = $instance['title'];
    $vkontakte = $instance['vkontakte'];
    $facebook = $instance['facebook'];
    $instagram = $instance['instagram'];
    $twitter = $instance['twitter'];
    $youtube = $instance['youtube'];

  echo $args['before_widget'];
  if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
    echo '<div class="widget-social-link">';
    if ( ! empty( $vkontakte ) ) {
      echo '<a class="widget-social-link-vk" href="' . $vkontakte . '" tagert="_blank">
        <svg width="15" height="15" fill="#ffffff" class="widget-link-icon">
          <use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#vk"></use>
        </svg>
      </a>';
    }
    if ( ! empty( $facebook ) ) {
      echo '<a class="widget-social-link-fb" href="' . $facebook . '" tagert="_blank">
        <svg width="15" height="15" fill="#ffffff" class="widget-link-icon">
          <use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#facebook"></use>
        </svg>
      </a>';
    }
    if ( ! empty( $instagram ) ) {
      echo '<a class="widget-social-link-inst" href="' . $instagram . '" tagert="_blank">
          <img class="widget-link-icon" src="'.get_template_directory_uri().'/assets/images/instagram.svg" alt="Instagram" />
      </a>';
    }
    if ( ! empty( $twitter ) ) {
      echo '<a class="widget-social-link-twit" href="' . $twitter . '" tagert="_blank">
        <svg width="15" height="15" fill="#ffffff" class="widget-link-icon">
          <use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#twitter"></use>
        </svg>
      </a>';
    }
    if ( ! empty( $youtube ) ) {
      echo '<a class="widget-social-link-yt" href="' . $youtube . '" tagert="_blank">
        <svg width="15" height="15" fill="#ffffff" class="widget-link-icon">
          <use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#youtube"></use>
        </svg>
      </a>';
    }
    echo '</div>';
    echo $args['after_widget'];
  }

  /**
  * Админ-часть виджета
  *
  * @param array $instance сохраненные данные из настроек
  */
  function form( $instance ) {
    $title = @ $instance['title'] ?: '';
    $vkontakte = @ $instance['vkontakte'] ?: '';
    $facebook = @ $instance['facebook'] ?: '';
    $instagram = @ $instance['instagram'] ?: '';
    $twitter = @ $instance['twitter'] ?: '';
    $youtube = @ $instance['youtube'] ?: '';

  ?>
  <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'museum'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
  </p>
  <p>
    <label for="<?php echo $this->get_field_id( 'vkontakte' ); ?>"><?php _e('VKontakte:', 'museum'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'vkontakte' ); ?>" name="<?php echo $this->get_field_name( 'vkontakte' ); ?>" type="text" value="<?php echo esc_attr( $vkontakte ); ?>">
  </p>
  <p>
    <label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e('Facebook:', 'museum'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>">
  </p>
  <p>
    <label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e('Instagram:', 'museum'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text" value="<?php echo esc_attr( $instagram ); ?>">
  </p>
  <p>
    <label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('Twitter:', 'museum'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>">
  </p>
  <p>
    <label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e('Youtube:', 'museum'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo esc_attr( $youtube ); ?>">
  </p>
  <?php
  }

  /**
  * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
  *
  * @see WP_Widget::update()
  *
  * @param array $new_instance новые настройки
  * @param array $old_instance предыдущие настройки
  *
  * @return array данные которые будут сохранены
  */
  function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['vkontakte'] = ( ! empty( $new_instance['vkontakte'] ) ) ? strip_tags( $new_instance['vkontakte'] ) : '';
    $instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
    $instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? strip_tags( $new_instance['instagram'] ) : '';
    $instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
    $instance['youtube'] = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';

    return $instance;
  }

  // скрипт виджета
  function add_social_widget_scripts() {
  // фильтр чтобы можно было отключить скрипты
  if( ! apply_filters( 'show_social_widget_script', true, $this->id_base ) )
    return;

    $theme_url = get_stylesheet_directory_uri();

    wp_enqueue_script('social_widget_script', $theme_url .'/social_widget_script.js' );
  }

  // стили виджета
  function add_social_widget_style() {
    // фильтр чтобы можно было отключить стили
    if( ! apply_filters( 'show_social_widget_style', true, $this->id_base ) )
    return;
    ?>
    <style type="text/css">
      .social_widget a{ display:inline; }
    </style>
    <?php
  }
}
// конец класса Social_Widget

// регистрация Social_Widget в WordPress
function register_social_widget() {
  register_widget( 'Social_Widget' );
}
add_action( 'widgets_init', 'register_social_widget' );

/**
 * Добавление нового виджета Phones_Widget.
 */
class Phones_Widget extends WP_Widget {

  // Регистрация виджета используя основной класс
  function __construct() {
  // вызов конструктора выглядит так:
  // __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
  parent::__construct(
    'phones_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: foo_widget
    __('Phones', 'museum'),
    array( 'description' => __('Phones.', 'museum'), 'classname' => 'widget-phones-wrapper' )
  );

  // скрипты/стили виджета, только если он активен
  if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
    //add_action('wp_enqueue_scripts', array( $this, 'add_phones_widget_scripts' ));
    add_action('wp_head', array( $this, 'add_phones_widget_style' ) );
    }
  }

  /**
  * Вывод виджета во Фронт-энде
  *
  * @param array $args     аргументы виджета.
  * @param array $instance сохраненные данные из настроек
  */
  function widget( $args, $instance ) {
    $title = $instance['title'];
    $phone1 = $instance['phone1'];
    $phone2 = $instance['phone2'];

    echo $args['before_widget'];
      if (!empty( $title )) echo $args['before_title'] . $title . $args['after_title'];
      $letters = array('(', ')', '-', ' ', '+', '–');
      $link_phone1 = str_ireplace($letters, '', $phone1);
      if (substr($link_phone1,0,1) == 8) $link_phone1[0] = 7;
      $link_phone2 = str_ireplace($letters, '', $phone2);
      if (substr($link_phone2,0,1) == 8) $link_phone2[0] = 7;
      if (!empty( $phone1 || !empty( $phone2 ) )){
        echo '<div class="widget-phones">
          <img src="'.get_template_directory_uri().'/assets/images/phone.svg" alt="Телефон" />';
          if (!empty( $phone1 )) echo '<a class="widget-phone" tel="+'.$link_phone1.'">'.$phone1.'</a>';
          if (!empty( $phone2 )) echo '<a class="widget-phone" tel="+'.$link_phone2.'">'.$phone2.'</a>';
        echo '</div>';
      }
    echo $args['after_widget'];
  }

  /**
  * Админ-часть виджета
  *
  * @param array $instance сохраненные данные из настроек
  */
    function form( $instance ) {
      $title = @ $instance['title'] ?: '';
      $phone1 = @ $instance['phone1'] ?: '';
      $phone2 = @ $instance['phone2'] ?: '';

    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'museum'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'phone1' ); ?>"><?php _e('Phone 1:', 'museum'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone1' ); ?>" type="text" value="<?php echo esc_attr( $phone1 ); ?>">
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'phone2' ); ?>"><?php _e('Phone 2:', 'museum'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone2' ); ?>" type="text" value="<?php echo esc_attr( $phone2 ); ?>">
    </p>
    <?php
  }

  /**
  * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
  *
  * @see WP_Widget::update()
  *
  * @param array $new_instance новые настройки
  * @param array $old_instance предыдущие настройки
  *
  * @return array данные которые будут сохранены
  */
  function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['phone1'] = ( ! empty( $new_instance['phone1'] ) ) ? strip_tags( $new_instance['phone1'] ) : '';
    $instance['phone2'] = ( ! empty( $new_instance['phone2'] ) ) ? strip_tags( $new_instance['phone2'] ) : '';

    return $instance;
  }

  // скрипт виджета
  function add_phones_widget_scripts() {
    // фильтр чтобы можно было отключить скрипты
    if( ! apply_filters( 'show_phones_widget_script', true, $this->id_base ) ) return;

    $theme_url = get_stylesheet_directory_uri();

    wp_enqueue_script('phones_widget_script', $theme_url .'/phones_widget_script.js' );
  }

  // стили виджета
  function add_phones_widget_style() {
    // фильтр чтобы можно было отключить стили
    if( ! apply_filters( 'show_phones_widget_style', true, $this->id_base ) )
    return;
    ?>
    <style type="text/css">
      .phones-widget a{ display:inline; }
    </style>
    <?php
  }
}
// конец класса Phones_Widget

// регистрация Phones_Widget в WordPress
function register_phones_widget() {
  register_widget( 'Phones_Widget' );
}
add_action( 'widgets_init', 'register_phones_widget' );

/**
 * Добавление нового виджета Posts_Widget.
 */
class Posts_Widget extends WP_Widget {

  // Регистрация виджета используя основной класс
  function __construct() {
  // вызов конструктора выглядит так:
  // __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
  parent::__construct(
    'posts_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: foo_widget
    __('Popular events', 'museum'),
    array( 'description' => __('Popular events.', 'museum'), 'classname' => 'widget-posts', )
  );

  // скрипты/стили виджета, только если он активен
  if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
    //add_action('wp_enqueue_scripts', array( $this, 'add_posts_widget_scripts' ));
    add_action('wp_head', array( $this, 'add_posts_widget_style' ) );
    }
  }

  /**
  * Вывод виджета во Фронт-энде
  *
  * @param array $args     аргументы виджета.
  * @param array $instance сохраненные данные из настроек
  */
  function widget( $args, $instance ) {
    $title = $instance['title'];
    $count = $instance['count'];

    echo $args['before_widget'];
      if (!empty( $title )) echo $args['before_title'] . $title . $args['after_title'];
      if ( ! empty( $count ) ) {
        echo '<div class="widget-posts-wrapper">';
          global $post;
          $category = get_the_category();
          rsort( $category );
          $category_slug = $category[0]->slug;

          $posts = get_posts( array(
            'category_name'    => $category_slug,
            'posts_per_page' => $count,
            'exclude' => $GLOBALS['post']->ID,
          ) );

          foreach( $posts as $post ){
            setup_postdata($post);?>
          <a href="<?php the_permalink() ?>" class="posts-link">
          <img class="posts-thumb" src="<?php
            if( has_post_thumbnail() ) echo get_the_post_thumbnail_url();
            else echo get_template_directory_uri().'/assets/images/img-default.png';
          ?>" alt="<?php the_title(); ?>">
            <div class="posts-info">
              <span><?php the_time('j F Y')?></span>
            </div>
            <h4 class="posts-title"><?php the_title()?></h4>
          </a>
          <?php
          }
          wp_reset_postdata();
        echo '</div>';
      }
    echo $args['after_widget'];
  }

  /**
  * Админ-часть виджета
  *
  * @param array $instance сохраненные данные из настроек
  */
    function form( $instance ) {
      $title = @ $instance['title'] ?: __('Popular events', 'museum');
      $count = @ $instance['count'] ?: '4';

    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'museum'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number of posts:', 'museum'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
    </p>
    <?php
  }

  /**
  * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
  *
  * @see WP_Widget::update()
  *
  * @param array $new_instance новые настройки
  * @param array $old_instance предыдущие настройки
  *
  * @return array данные которые будут сохранены
  */
  function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

    return $instance;
  }

  // скрипт виджета
  function add_posts_widget_scripts() {
    // фильтр чтобы можно было отключить скрипты
    if( ! apply_filters( 'show_posts_widget_script', true, $this->id_base ) ) return;

    $theme_url = get_stylesheet_directory_uri();

    wp_enqueue_script('posts_widget_script', $theme_url .'/posts_widget_script.js' );
  }

  // стили виджета
  function add_posts_widget_style() {
    // фильтр чтобы можно было отключить стили
    if( ! apply_filters( 'show_posts_widget_style', true, $this->id_base ) )
    return;
    ?>
    <style type="text/css">
      .posts-widget a{ display:inline; }
    </style>
    <?php
  }
}
// конец класса Posts_Widget

// регистрация Posts_Widget в WordPress
function register_posts_widget() {
  register_widget( 'Posts_Widget' );
}
add_action( 'widgets_init', 'register_posts_widget' );

//Подключение стилей и скриптов
function enqueue_museum_style() {
  wp_enqueue_style( 'style', get_stylesheet_uri() );
  wp_enqueue_style( 'swipe-slider', get_template_directory_uri().'/assets/css/swiper-bundle.min.css', 'museum-theme', time() );
  wp_enqueue_style( 'museum-theme', get_template_directory_uri().'/assets/css/museum-theme.css', 'style', time() );
  wp_enqueue_style( 'Roboto', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap');
  wp_enqueue_style( 'Open-Sans', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap');
  wp_register_script( 'jquery-core', '//code.jquery.com/jquery-3.5.1.min.js');
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'swiper', get_template_directory_uri().'/assets/js/swiper-bundle.min.js', null, time(), true);
  wp_enqueue_script( 'scripts', get_template_directory_uri().'/assets/js/scripts.js', 'swiper', time(), true);
}
add_action( 'wp_enqueue_scripts', 'enqueue_museum_style' );

add_action( 'wp_enqueue_scripts', 'adminAjax_data', 99 );
function adminAjax_data(){
  wp_localize_script( 'jquery', 'adminAjax',
    array(
      'url' => admin_url('admin-ajax.php')
    )
  );
}

add_action( 'phpmailer_init', 'my_phpmailer_config' );
function my_phpmailer_config( $phpmailer ) {

	$phpmailer->isSMTP();
	$phpmailer->Host = 'smtp.mail.ru';
	$phpmailer->SMTPAuth = true;
	$phpmailer->Port = 465;
	require_once 'mail_config.php';
	$phpmailer->FromName = 'Wordpress Museum-dev';
}

add_action('wp_ajax_contacts_form', 'ajax_form');
add_action('wp_ajax_nopriv_contacts_form', 'ajax_form');
function ajax_form() {
  $mail_to = get_option('admin_email');
  $contact_name = $_POST['contact_name'];
  $contact_email = $_POST['contact_email'];
  $contact_comment = $_POST['contact_comment'];
  $message = 'Пользователь отправил сообщение с сайта Museum-dev:'.PHP_EOL.'Имя '.$contact_name.PHP_EOL.'E-mail '.$contact_email.PHP_EOL.'Сообщение '.$contact_comment;
  $headers = 'From: Владимир <'.$mail_to.'>' . "\r\n";
  $send_message = wp_mail($mail_to, 'Новая заявка с сайта', $message, $headers);
  if($send_message) echo 'Всё получилось';
  else echo 'Где-то есть ошибка';
  wp_die();
}

#Изменяем настройки облака тегов
add_action( 'widget_tag_cloud_args', 'edit_widget_tag_cloud_args' );
function edit_widget_tag_cloud_args($args){
  $args['unit'] = 'px';
  $args['smallest'] = 14;
  $args['largest'] = 14;
  $args['number'] = 12;
  $args['orderby'] = 'count';
  return $args;
}

#Отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
  //размеры которые нужно удалить
  return array_diff( $sizes, [
    'medium',
    'medium_large',
    'large',
    '1536x1536',
    '2048x2048'
  ] );
}

#Отмена `-scaled` размера - ограничение максимального размера картинки
add_filter( 'big_image_size_threshold', '__return_zero' );

#Меняем стиль многоточия в отрывках
add_filter('excerpt_more', function($more) {
	return '...';
});

//Disable auto-update email notifications for plugins.
add_filter( 'auto_plugin_update_send_email', '__return_false' );

//Disable auto-update email notifications for themes.
add_filter( 'auto_theme_update_send_email', '__return_false' );

//Отключение email-уведомления при обновлении
function wpplus_disable_update_emails( $send, $type, $core_update, $result ) {
  if ( !empty ($type) && $type == 'success' ) {
    return false;
  }
  return true;
}
add_filter ( 'auto_core_update_send_email', 'wpplus_disable_update_emails', 10, 4 );

//Склонение слов после числительных
function plural_form($number, $after) {
  $cases = array (2, 0, 1, 1, 1, 2);
  echo $number.' '.$after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
}

/*
 * "Хлебные крошки" для WordPress
 * автор: Dimox
 * версия: 2019.03.03
 * лицензия: MIT
*/
function the_breadcrumbs() {

  /* === ОПЦИИ === */
  $text['home']     = __('Main', 'museum'); // текст ссылки "Главная"
  $text['category'] = '%s'; // текст для страницы рубрики
  $text['search']   = __('Search results for the query', 'museum').' "%s"'; // текст для страницы с результатами поиска
  $text['tag']      = __('Records with tag', 'museum').' "%s"'; // текст для страницы тега
  $text['author']   = __('Article author', 'museum').' %s'; // текст для страницы автора
  $text['404']      = __('Error 404', 'museum'); // текст для страницы 404
  $text['page']     = __('Page', 'museum').' %s'; // текст 'Страница N'
  $text['cpage']    = __('Page comments', 'museum').' %s'; // текст 'Страница комментариев N'

  $wrap_before    = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">'; // открывающий тег обертки
  $wrap_after     = '</div><!-- .breadcrumbs -->'; // закрывающий тег обертки
  $sep            = '
  <span class="breadcrumbs__separator">
    <svg width="15" height="10" fill="#666666" class="icon">
      <use xlink:href="'.get_template_directory_uri().'/assets/images/sprite.svg#arrow"></use>
    </svg>
  </span>'; // разделитель между "крошками"
  $before         = '<span class="breadcrumbs__current">'; // тег перед текущей "крошкой"
  $after          = '</span>'; // тег после текущей "крошки"

  $show_on_home   = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
  $show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать
  $show_current   = 1; // 1 - показывать название текущей страницы, 0 - не показывать
  $show_last_sep  = 1; // 1 - показывать последний разделитель, когда название текущей страницы не отображается, 0 - не показывать
  /* === КОНЕЦ ОПЦИЙ === */

  global $post;
  $home_url       = home_url('/');
  $link           = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
  $link          .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
  $link          .= '<meta itemprop="position" content="%3$s" />';
  $link          .= '</span>';
  $parent_id      = ( $post ) ? $post->post_parent : '';
  $home_link      = sprintf( $link, $home_url, $text['home'], 1 );

  if ( is_home() || is_front_page() ) {

    if ( $show_on_home ) echo $wrap_before . $home_link . $wrap_after;

  } else {

    $position = 0;

    echo $wrap_before;

    if ( $show_home_link ) {
      $position += 1;
      echo $home_link;
    }

    if ( is_category() ) {
      $parents = get_ancestors( get_query_var('cat'), 'category' );
      foreach ( array_reverse( $parents ) as $cat ) {
        $position += 1;
        if ( $position > 1 ) echo $sep;
        echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
      }
      if ( get_query_var( 'paged' ) ) {
        $position += 1;
        $cat = get_query_var('cat');
        echo $sep . sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
        echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
      } else {
        if ( $show_current ) {
          if ( $position >= 1 ) echo $sep;
          echo $before . sprintf( $text['category'], single_cat_title( '', false) ) . $after;
        } elseif ( $show_last_sep ) echo $sep;
      }

    } elseif ( is_search() ) {
      if ( get_query_var( 'paged' ) ) {
        $position += 1;
        if ( $show_home_link ) echo $sep;
        echo sprintf( $link, $home_url . '?s=' . get_search_query(), sprintf( $text['search'], get_search_query() ), $position );
        echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
      } else {
        if ( $show_current ) {
          if ( $position >= 1 ) echo $sep;
          echo $before . sprintf( $text['search'], get_search_query() ) . $after;
        } elseif ( $show_last_sep ) echo $sep;
      }

    } elseif ( is_year() ) {
      if ( $show_home_link && $show_current ) echo $sep;
      if ( $show_current ) echo $before . get_the_time('Y') . $after;
      elseif ( $show_home_link && $show_last_sep ) echo $sep;

    } elseif ( is_month() ) {
      if ( $show_home_link ) echo $sep;
      $position += 1;
      echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position );
      if ( $show_current ) echo $sep . $before . get_the_time('F') . $after;
      elseif ( $show_last_sep ) echo $sep;

    } elseif ( is_day() ) {
      if ( $show_home_link ) echo $sep;
      $position += 1;
      echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position ) . $sep;
      $position += 1;
      echo sprintf( $link, get_month_link( get_the_time('Y'), get_the_time('m') ), get_the_time('F'), $position );
      if ( $show_current ) echo $sep . $before . get_the_time('d') . $after;
      elseif ( $show_last_sep ) echo $sep;

    } elseif ( is_single() && ! is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $position += 1;
        $post_type = get_post_type_object( get_post_type() );
        if ( $position > 1 ) echo $sep;
        echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->labels->name, $position );
        if ( $show_current ) echo $sep . $before . get_the_title() . $after;
        elseif ( $show_last_sep ) echo $sep;
      } else {
        $cat = get_the_category(); $catID = $cat[0]->cat_ID;
        $parents = get_ancestors( $catID, 'category' );
        $parents = array_reverse( $parents );
        $parents[] = $catID;
        foreach ( $parents as $cat ) {
          $position += 1;
          if ( $position > 1 ) echo $sep;
          echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
        }
        if ( get_query_var( 'cpage' ) ) {
          $position += 1;
          echo $sep . sprintf( $link, get_permalink(), get_the_title(), $position );
          echo $sep . $before . sprintf( $text['cpage'], get_query_var( 'cpage' ) ) . $after;
        } else {
          if ( $show_current ) echo $sep . $before . get_the_title() . $after;
          elseif ( $show_last_sep ) echo $sep;
        }
      }

    } elseif ( is_post_type_archive() ) {
      $post_type = get_post_type_object( get_post_type() );
      if ( get_query_var( 'paged' ) ) {
        $position += 1;
        if ( $position > 1 ) echo $sep;
        echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->label, $position );
        echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
      } else {
        if ( $show_home_link && $show_current ) echo $sep;
        if ( $show_current ) echo $before . $post_type->label . $after;
        elseif ( $show_home_link && $show_last_sep ) echo $sep;
      }

    } elseif ( is_attachment() ) {
      $parent = get_post( $parent_id );
      $cat = get_the_category( $parent->ID ); $catID = $cat[0]->cat_ID;
      $parents = get_ancestors( $catID, 'category' );
      $parents = array_reverse( $parents );
      $parents[] = $catID;
      foreach ( $parents as $cat ) {
        $position += 1;
        if ( $position > 1 ) echo $sep;
        echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
      }
      $position += 1;
      echo $sep . sprintf( $link, get_permalink( $parent ), $parent->post_title, $position );
      if ( $show_current ) echo $sep . $before . get_the_title() . $after;
      elseif ( $show_last_sep ) echo $sep;

    } elseif ( is_page() && ! $parent_id ) {
      if ( $show_home_link && $show_current ) echo $sep;
      if ( $show_current ) echo $before . get_the_title() . $after;
      elseif ( $show_home_link && $show_last_sep ) echo $sep;

    } elseif ( is_page() && $parent_id ) {
      $parents = get_post_ancestors( get_the_ID() );
      foreach ( array_reverse( $parents ) as $pageID ) {
        $position += 1;
        if ( $position > 1 ) echo $sep;
        echo sprintf( $link, get_page_link( $pageID ), get_the_title( $pageID ), $position );
      }
      if ( $show_current ) echo $sep . $before . get_the_title() . $after;
      elseif ( $show_last_sep ) echo $sep;

    } elseif ( is_tag() ) {
      if ( get_query_var( 'paged' ) ) {
        $position += 1;
        $tagID = get_query_var( 'tag_id' );
        echo $before . 'Теги' . $after . $sep;
        echo $sep . sprintf( $link, get_tag_link( $tagID ), single_tag_title( '', false ), $position );
        echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
      } else {
        if ( $show_home_link && $show_current ) echo $sep;
        echo $before . 'Теги' . $after . $sep;
        if ( $show_current ) echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;
        elseif ( $show_home_link && $show_last_sep ) echo $sep;
      }

    } elseif ( is_author() ) {
      $author = get_userdata( get_query_var( 'author' ) );
      if ( get_query_var( 'paged' ) ) {
        $position += 1;
        echo $sep . sprintf( $link, get_author_phones_url( $author->ID ), sprintf( $text['author'], $author->display_name ), $position );
        echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
      } else {
        if ( $show_home_link && $show_current ) echo $sep;
        if ( $show_current ) echo $before . sprintf( $text['author'], $author->display_name ) . $after;
        elseif ( $show_home_link && $show_last_sep ) echo $sep;
      }

    } elseif ( is_404() ) {
      if ( $show_home_link && $show_current ) echo $sep;
      if ( $show_current ) echo $before . $text['404'] . $after;
      elseif ( $show_last_sep ) echo $sep;

    } elseif ( has_post_format() && ! is_singular() ) {
      if ( $show_home_link && $show_current ) echo $sep;
      echo get_post_format_string( get_post_format() );
    }

    echo $wrap_after;

  }
} // end of the_breadcrumbs()
