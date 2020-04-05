<?php /* Template Name: verifyLogin */ ?>
<?php
global $wpdb,$user_ID;
    if($_POST){
        $username = $wpdb->escape($_POST['user']);
        $password = $wpdb->escape($_POST['pass']);

        $login_array = array();
        $login_array['user_login'] = $username;
        $login_array['user_password'] = $password;

        $verify_user = wp_signon($login_array,true);
        if(!is_wp_error($verify_user)){
            echo 'login success';
        }
        else{
            echo 'false';
        }
    }
    else{
        echo 'error';
    }
?>