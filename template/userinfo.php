<?php /* Template Name: userinfo */ ?>
<?php 
    $current_user = wp_get_current_user();
    /*
        ID : ไอดีสมาชิก
        user_login : ชื่อสมาชิก
        roles[0] : สถานะของสมาชิก
        user_registered : วันที่สมัคร
    */

    $score = get_user_meta($current_user->ID,'score',true);

    get_header();
?>

<section>
    <div class="user-box">
        <div class="user-info">
            <div class="user-name"><h1>ชื่อผู้ใช้งาน : <?php echo $current_user->user_login ?></h1></div>
            <div class="user-role"><h2>ระดับของผู้ใช้งาน : <?php echo $current_user->roles[0] ?></h2></div>
            <div class="user-date"><h2>สมัครใช้งานเมื่อวันที่ : <?php echo $current_user->user_registered ?></h2></div>
            <div class="user-score">
                <h2>คะแนนรวมของคุณ : 
                <?php 
                    if($score){
                        echo $score;
                    } 
                    else{
                        echo 'ยังไม่มีคะแนน';
                    }
                ?>
                </h2>
            </div>
        </div>

        <div class="button-share">
            <a href="https://www.facebook.com/dialog/feed?
                    app_id=572717636677186&
                    display=popup&
                    link=https://optimumpeptides.com/&
                    name=monkey-island&
                    caption=เว็บติวเตอร์ฟรีข้อสอบ&
                    description=เว็บฟรีข้อสอบ ทำติวเตอร์ฟรี ทดสอบระบบเว็บข้อสอบ&
                    message=เพื่อนคุณทำได้รึป่าว คะแนนคุณคือ<?php echo $score; ?>&redirect_uri=https://optimumpeptides.com/" target="_blank">
                <button>แชร์</button>
            </a>
        </div>
    </div>
</section>


<?php get_footer(); ?>