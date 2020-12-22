<?php 
$args = array(
  'prev_text'  =>  '
      <svg width="15" height="7" class="pagination-prev-icon">
        <use xlink:href="'. get_template_directory_uri() .'/assets/images/sprite.svg#arrow"></use>
      </svg>
    '.__('Back', 'museum'),
  'next_text'  =>  __('Forward', 'museum').'
      <svg width="15" height="7" class="pagination-next-icon">
        <use xlink:href="'. get_template_directory_uri() .'/assets/images/sprite.svg#arrow"></use>
      </svg>',
);
the_posts_pagination($args);
