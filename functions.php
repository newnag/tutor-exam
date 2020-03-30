<?php
  // สร้างเมนู
  register_nav_menus(
    array(
            'mainmenu' => 'mainmenu',
            'footer' =>  'Footer Menu' ,
    )
  );

  // ปิด admin bar
  if ( ! current_user_can( 'manage_options' ) ) {
    add_filter('show_admin_bar', '__return_false');
  }