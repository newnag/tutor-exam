<?php /* Template Name: complate */ ?>
<?php 

$current_user = wp_get_current_user();
if ( 0 == $current_user->ID ) {
    echo 'Dont Login';
} else {
   // echo 'Login Success <br>';
    //echo "ID Login is ".$current_user->ID." ";

    $score = $_REQUEST["score"];
    $time_min = $_REQUEST["min"]; // ค่านาที
    $time_sec = $_REQUEST["sec"]; // ค่าวินาที


    $userid = $current_user->ID; // User ID ของผู้ใช้ปัจจุบัน
    $insert = get_user_meta($userid,'score',true); // เรียกค่าscoreจาก DB ออกมา
    //echo $insert;
    
    $updated = update_user_meta( $userid, 'score', $score+$insert); // เซฟข้อมูลลง DB

    // เช็คค่าเวลา ถ้าทำได้ต่ำกว่าจะเซฟ หากเป็นครั้งแรกจะเซฟค่าทันที
    $get_min = get_user_meta($userid,'time_min',true); // ดึงค่านาที
    $get_sec = get_user_meta($userid,'time_sec',true); // ดึงค่าวินาที
    if($time_min < $get_min){
        $time_update_min = update_user_meta( $userid, 'time_min', $time_min);
        $time_update_sec = update_user_meta( $userid, 'time_sec', $time_sec);
    }
    elseif($time_min == $get_min){
        if($time_sec < $get_sec){
            $time_update_min = update_user_meta( $userid, 'time_min', $time_min);
            $time_update_sec = update_user_meta( $userid, 'time_sec', $time_sec);
        }
    }
    elseif($get_min == null && $get_sec == null){
        $time_update_min = update_user_meta( $userid, 'time_min', $time_min);
        $time_update_sec = update_user_meta( $userid, 'time_sec', $time_sec);
    }

    // เช็คสถานะและส่งค่ากลับ ajax
    if($updated === false && $time_update_min == false && $time_update_sec == false){
        echo 'Database Update False';
    }
    else{
        $rank_count = get_user_meta($userid,'rank_count',true);
        $rank_count -= 1;
        update_user_meta( $userid, 'rank_count',$rank_count);
        echo 'Update Success';       
    }
}

