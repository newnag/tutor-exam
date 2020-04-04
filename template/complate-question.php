<?php /* Template Name: complate */ ?>
<?php 

$current_user = wp_get_current_user();
if ( 0 == $current_user->ID ) {
    echo 'Dont Login';
} else {
   // echo 'Login Success <br>';
    //echo "ID Login is ".$current_user->ID." ";

    $score = $_REQUEST["score"];


    $userid = $current_user->ID; // User ID ของผู้ใช้ปัจจุบัน
    $insert = get_user_meta($userid,'score',true); // เรียกค่าscoreจาก DB ออกมา
    //echo $insert;
    
    $updated = update_user_meta( $userid, 'score', $score+$insert); // เซฟข้อมูลลง DB
    
    // เช็คสถานะและส่งค่ากลับ ajax
    if($updated === false){
        echo 'Database Update False';
    }
    else{
        echo 'Update Success';
    }
}

