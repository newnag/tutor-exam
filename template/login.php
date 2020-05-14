<?php /* Template Name: login */ ?>
<?php
    get_header();
?>

<section>
    <div class="login-box">
        <div class="login-form">
            <div class="input">
                <input type="text" name="user" placeholder="Username">
                <input type="password" name="pass" placeholder="Password">
            </div>

            <div class="button"><button>เข้าสู่ระบบ</button></div>
        </div>    
    </div>

    <div class="register-line">
        <a href="<?php site_url(); ?>/register">สมัครสมาชิก</a>
    </div>
</section>

<?php get_footer(); ?>