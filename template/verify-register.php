<?php /* Template Name: verifyregis */ ?>
<?php
global $wpdb,$user_ID;
if($_POST){
    $username = $wpdb->escape($_POST['user']);
    $password = $wpdb->escape($_POST['pass']);
    $password_con = $wpdb->escape($_POST['conpass']);
    $email = $wpdb->escape($_POST['email']);
    $age = $wpdb->escape($_POST['age']);
    $educate = $wpdb->escape($_POST['educate']);

    $error =array();

    // เช็คยูสซ้ำ
    if(username_exists($username)){
        $error['username_exists'] = "มียูสเซอร์นี้ในระบบแล้ว";
    }

    // เช็คช่องว่าง
    if(strpos($username, '') !== false){
        $error['username_space'] = "ห้ามมีช่องว่าง";
    }

    // เช็คไม่กรอก user
    if(empty($username)){
        $error['username_empty'] = "กรุณากรอกชื่อผู้ใช้งาน";
    }

    // เช็คพาสตรงกัน
    if(strcmp($password,$password_con)!==0){
        $error['password_confirm'] = "ท่านกรอกรหัสผ่านไม่ตรงกัน";
    }

    // เช็คพาสครบ 6 ตัว
    if(0 === preg_match("/.{6,}/", $password)){
        $error['password'] = "กรุณากรอกรหัสผ่าน 6 ตัวขึ้นไป";
    }

    // เช็คอีเมล์
    if(!is_email($email)){
        $error['email'] = "กรุณากรอกอีเมล์ให้ถูกต้อง";
    }

    // เช็คอีเมล์มีในระบบแล้ว
    if(email_exists($email)){
        $error['email_already'] = "มีอีเมล์นี้ในระบบแล้ว";
    }

    // เช็คกรอกอายุ
    if(empty($age)){
        $error['age'] = "กรุณากรอกอายุ";
    }

    // เช็คกรอกการศึกษา
    if(empty($educate)){
        $error['educate'] = "กรุณาเลือกระดับการศึกษา";
    }

    // เช็ค error ทั้งหมด
    if(count($error) == 0){
        wp_create_user($username,$password,$email);
        $id_username = get_user_by('login',$username); // ดึง ID ของuserที่พึ่งสมัครไป
        update_user_meta($id_username->ID,'age',$age); // เพิ่มอายุเข้า DB
        update_user_meta($id_username->ID,'educate',$educate); // เพิ่มการศึกษาเข้า DB
        $success = array("success"); // ส่งค่ากลับเมื่อสมัครสมบูรณ์
        echo json_encode($success);
    }
    else{
        echo json_encode($error); // ส่งค่ากลับเมื่อมีข้อผิดพลาด
    }
}
else{
    echo "nodata";
}
?>