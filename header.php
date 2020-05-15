<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/style.css">
    <script src="https://kit.fontawesome.com/37e3c13129.js" crossorigin="anonymous"></script>
    <?php wp_head(); ?>
</head>
<body>
    
<header>
    <div class="header">
        <div class="logo">
            <a href="/"><figure><img src="<?php bloginfo('template_url') ?>/img/logo/logo.png" alt=""></figure></a>
        </div>

        <div class="text-head">
            <h1>Monkey Island</h1>
        </div>
    </div>
</header>

<div class="register-login">
    <?php 
        $current_user = wp_get_current_user();
        if( 0 == $current_user->ID ){
            echo '<a href="'.site_url().'/login"><i class="fas fa-user-circle"></i></a>';
        }
        else{
            echo '<a href="'.site_url().'/userinfo"><i class="fas fa-user-circle"></i></a>';
        }
    ?>
</div>
