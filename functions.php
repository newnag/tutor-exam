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

// ปิด content edit
function RemoveContent_edit(){
  remove_post_type_support( 'post', 'editor');
}
add_action('admin_init','RemoveContent_edit');


// ------------------------------------ Module ส่วนคำถามคำตอบ ----------------------------------- //

// เพิ่ม meta box
function adding_custom_meta_boxes( ) {
  // คำตอบที่ถูกต้อง
  add_meta_box('question','คำถาม','boxQuestion','post','normal','default');
  add_meta_box('correct_anw','คำตอบที่ถูกต้อง','question_function','post','normal','default');
  add_meta_box('normal_anw1','คำตอบอื่นๆที่1','question_function1','post','normal','default');
  add_meta_box('normal_anw2','คำตอบอื่นๆที่2','question_function2','post','normal','default');
  add_meta_box('normal_anw3','คำตอบอื่นๆที่3','question_function3','post','normal','default');
}
add_action( 'add_meta_boxes', 'adding_custom_meta_boxes', 10, 2 );

// ฟังก์ชั่นคำถาม
function boxQuestion($post){
  wp_nonce_field( basename(__FILE__),'wp_cpt_nonce' );
  //ประกาศตัวแปรแสดงค่าจาก meta box
  $question = get_post_meta($post->ID,'question',true); // คำถาม

  echo '<span>กรอกคำถามตรงนี้</span> <br>';
  echo '<textarea rows="4" cols="50" style="width:100%;" name="question">'.$question.'</textarea> <br>';
}

// ฟังก์ชั่นคำตอบ
function question_function($post){
  wp_nonce_field( basename(__FILE__),'wp_cpt_nonce' );
  //ประกาศตัวแปรแสดงค่าจาก meta box
  $anwser_corr = get_post_meta($post->ID,'correct_anw',true); // คำตอบที่ถูก

  // คำตอบที่ถูก
  echo '<span>กรอกคำตอบที่ถูกต้องตรงนี้</span> <br>';
  echo '<input style="width:100%;" type="text" name="corr_anwser" value="'.$anwser_corr.'"> <br>';
}
// ฟังก์ชั่นคำตอบอื่นๆ1
function question_function1($post){
  wp_nonce_field( basename(__FILE__),'wp_cpt_nonce' );
  //ประกาศตัวแปรแสดงค่าจาก meta box
  $anwser1 = get_post_meta($post->ID,'normal_anw1',true); // คำตอบ1

  // คำตอบที่ถูก
  echo '<span>กรอกคำตอบอื่นๆ ที่ 1</span> <br>';
  echo '<input style="width:100%;" type="text" name="anwser1" value="'.$anwser1.'"> <br>';
}
// ฟังก์ชั่นคำตอบอื่นๆ2
function question_function2($post){
  wp_nonce_field( basename(__FILE__),'wp_cpt_nonce' );
  //ประกาศตัวแปรแสดงค่าจาก meta box
  $anwser2 = get_post_meta($post->ID,'normal_anw2',true); // คำตอบ2

  // คำตอบที่ถูก
  echo '<span>กรอกคำตอบอื่นๆ ที่ 2</span> <br>';
  echo '<input style="width:100%;" type="text" name="anwser2" value="'.$anwser2.'"> <br>';
}
// ฟังก์ชั่นคำตอบอื่นๆ3
function question_function3($post){
  wp_nonce_field( basename(__FILE__),'wp_cpt_nonce' );
  //ประกาศตัวแปรแสดงค่าจาก meta box
  $anwser3 = get_post_meta($post->ID,'normal_anw3',true); // คำตอบ3

  // คำตอบที่ถูก
  echo '<span>กรอกคำตอบอื่นๆ ที่ 3</span> <br>';
  echo '<input style="width:100%;" type="text" name="anwser3" value="'.$anwser3.'"> <br>';
}

// เซฟคำตอบเข้า DB
add_action( 'save_post', 'save_anwser', 10, 2 );
add_action( 'save_post', 'save_anwser1', 10, 2 );
add_action( 'save_post', 'save_anwser2', 10, 2 );
add_action( 'save_post', 'save_anwser3', 10, 2 );
add_action( 'save_post', 'save_question', 10, 2 );

function save_anwser($post_id,$post){
  //verify nonce
  if(!isset($_POST['wp_cpt_nonce']) || !wp_verify_nonce($_POST['wp_cpt_nonce'],basename(__FILE__))){
    return $post_id;
  }

  // verify slug
  $post_slug = 'post';
  if($post_slug != $post->post_type){
      return;
  }

  //ส่วนบันทึกค่า คำตอบที่ถูกต้อง
  $pub_ans_load = '';
  if(isset($_POST['corr_anwser'])){
      $pub_ans_load = $_POST['corr_anwser'];
  }else{
      $pub_ans_load = '';
  }

  // อัพข้อมูลขึ้น DB
  update_post_meta($post_id,'correct_anw',$pub_ans_load);
}
// ฟังก์ชั่นเซฟคำตอบที่1
function save_anwser1($post_id,$post){
  //verify nonce
  if(!isset($_POST['wp_cpt_nonce']) || !wp_verify_nonce($_POST['wp_cpt_nonce'],basename(__FILE__))){
    return $post_id;
  }

  // verify slug
  $post_slug = 'post';
  if($post_slug != $post->post_type){
      return;
  }

  //ส่วนบันทึกค่า คำตอบที่ถูกต้อง
  $pub_ans_load1 = '';
  if(isset($_POST['anwser1'])){
      $pub_ans_load1 = $_POST['anwser1'];
  }else{
      $pub_ans_load1 = '';
  }

  // อัพข้อมูลขึ้น DB
  update_post_meta($post_id,'normal_anw1',$pub_ans_load1);
}
// ฟังก์ชั่นเซฟคำตอบที่2
function save_anwser2($post_id,$post){
  //verify nonce
  if(!isset($_POST['wp_cpt_nonce']) || !wp_verify_nonce($_POST['wp_cpt_nonce'],basename(__FILE__))){
    return $post_id;
  }

  // verify slug
  $post_slug = 'post';
  if($post_slug != $post->post_type){
      return;
  }

  //ส่วนบันทึกค่า คำตอบที่ถูกต้อง
  $pub_ans_load2 = '';
  if(isset($_POST['anwser2'])){
      $pub_ans_load2 = $_POST['anwser2'];
  }else{
      $pub_ans_load2 = '';
  }

  // อัพข้อมูลขึ้น DB
  update_post_meta($post_id,'normal_anw2',$pub_ans_load2);
}
// ฟังก์ชั่นเซฟคำตอบที่3
function save_anwser3($post_id,$post){
  //verify nonce
  if(!isset($_POST['wp_cpt_nonce']) || !wp_verify_nonce($_POST['wp_cpt_nonce'],basename(__FILE__))){
    return $post_id;
  }

  // verify slug
  $post_slug = 'post';
  if($post_slug != $post->post_type){
      return;
  }

  //ส่วนบันทึกค่า คำตอบที่ถูกต้อง
  $pub_ans_load3 = '';
  if(isset($_POST['anwser3'])){
      $pub_ans_load3 = $_POST['anwser3'];
  }else{
      $pub_ans_load3 = '';
  }

  // อัพข้อมูลขึ้น DB
  update_post_meta($post_id,'normal_anw3',$pub_ans_load3);
}

// ฟังก์ชั่นเซฟคำถาม
function save_question($post_id,$post){
  //verify nonce
  if(!isset($_POST['wp_cpt_nonce']) || !wp_verify_nonce($_POST['wp_cpt_nonce'],basename(__FILE__))){
    return $post_id;
  }

  // verify slug
  $post_slug = 'post';
  if($post_slug != $post->post_type){
      return;
  }

  //ส่วนบันทึกค่า คำถาม
  $pub_ques_load = '';
  if(isset($_POST['question'])){
      $pub_ques_load = $_POST['question'];
  }else{
      $pub_ques_load = '';
  }

  // อัพข้อมูลขึ้น DB
  update_post_meta($post_id,'question',$pub_ques_load);
}

// -------------------------------- จบส่วนคำถามคำตอบ ------------------------------------- //

// ---------------------------------- ส่วนจัดการสมาชิก ------------------------------------ //

// เพิ่ม role
add_role('mod','Mod',array());

// จัดการสิทธิ์ role
function role_mod(){
  $mod_cap = get_role('mod'); // ดึง Role เก็บเข้าตัวแปร

  $mod_cap->add_cap( 'read' );
  $mod_cap->add_cap( 'edit_posts' );
  $mod_cap->add_cap( 'delete_posts' );
  $mod_cap->add_cap( 'delete_published_posts' );
  $mod_cap->add_cap( 'delete_others_posts' );
  $mod_cap->add_cap( 'edit_others_posts' );
  $mod_cap->add_cap( 'edit_published_posts' );
  $mod_cap->add_cap( 'publish_posts' );
  $mod_cap->add_cap( 'upload_files' );
  $mod_cap->add_cap( 'delete_posts' );

  $mod_cap->add_cap( 'list_users' ); 
  $mod_cap->add_cap( 'edit_users' );
  $mod_cap->add_cap( 'create_users' );
  $mod_cap->add_cap( 'add_users' );
  $mod_cap->add_cap( 'delete_users' );
  $mod_cap->add_cap( 'promote_users' );
}
add_action('init','role_mod');

// ----------------------------------------------------------------------------------------- //

// ปุ่มออกจากระบบ
add_filter( 'wp_nav_menu_items', 'wti_loginout_menu_link', 10, 2 );
function wti_loginout_menu_link( $items, $args ){
  if ($args->menu == 'mainmenu' || $args->menu == 'mainmenu-mobile') {
    if (is_user_logged_in()) {
        $items .= '<li class="right"><a href="'. wp_logout_url() .'">'. __("ออกจากระบบ") .'</a></li>';
    } else {
        $items .= '<li class="right"><a href="'. site_url() .'/login">'. __("เข้าสู่ระบบ") .'</a></li>';
        $items .= '<li class="right"><a href="'. site_url() .'/register">'. __("สมัครสมาชิก") .'</a></li>';
    }
  }
  return $items;
}

// เมนูข้อมูลสมาชิก
add_filter( 'wp_nav_menu_items', 'mii_info_user_menu', 9, 2 );
function mii_info_user_menu( $items, $args ) {
    if ($args->menu == 'mainmenu' || $args->menu == 'mainmenu-mobile') {
        if (is_user_logged_in()) {
            $items .= '<li class="right"><a href="'. site_url() .'/userinfo">'. __("ข้อมูลสมาชิก") .'</a></li>';
        } 
    }
    return $items;
}

// เปลี่ยนเส้นทาง logout
function redirect_to_custon_login(){
  wp_redirect(site_url() . "/login");
  exit();
}
add_action("wp_logout","redirect_to_custon_login");