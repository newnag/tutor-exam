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
            <figure><img src="<?php bloginfo('template_url') ?>/img/logo/logo.png" alt=""></figure>
        </div>

        <div class="text-head">
            <h1>Monkey Island</h1>
        </div>
    </div>
</header>

<nav>
    <!-- <ul class="nav-menu">
        <li class="menu"><a href="">หน้าแรก</a></li>
        <li class="menu"><a href="">ประถมต้น</a></li>
        <li class="menu"><a href="">ประถมปลาย</a></li>
        <li class="menu"><a href="">มัถยมต้น</a></li>
        <li class="menu"><a href="">มัถยมปลาย</a></li>
        <li class="menu"><a href="">ความรู้ทั่วไป</a></li>
    </ul> -->
    <?php 
        wp_nav_menu( array(
            'menu' => 'mainmenu',
            'menu_class' => 'nav-menu',
        ) );
    ?>

    <!-- <div class="mobile-menu">
        <span id="menu-mobile">Menu</span>

        <?php 
            wp_nav_menu( array(
                'menu' => 'mainmenu-mobile',
                'menu_class' => 'nav-menu-mobile',
            ) );
        ?>

        <div class="close-button"><i class="fas fa-times"></i></div>
    </div> -->
</nav>
