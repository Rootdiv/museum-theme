<?php
$logo_img = '';
if( $custom_logo_id = get_theme_mod('custom_logo') ){
  $logo_img = wp_get_attachment_image( $custom_logo_id, 'full', false, array(
    'class'    => 'custom-logo',
    'alt'      => get_bloginfo('name'),
    'itemprop' => 'logo'
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
