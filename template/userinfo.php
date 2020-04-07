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
    $time_min = get_user_meta($current_user->ID,'time_min',true); // ดึงค่านาที
    $time_sec = get_user_meta($current_user->ID,'time_sec',true); // ดึงค่าวินาที

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
            <div class="time-use">
                <h2>เวลาที่น้อยที่สุดในการทำข้อสอบ</h2>
                <h2>
                    <?php 
                        if($time_min != null && $time_sec != null){
                            echo $time_min." : ".$time_sec ;
                        }
                        else{
                            echo "คุณยังไม่มีเวลาบันทึก" ;
                        }
                    ?>
                </h2>
            </div>
        </div>

        <!-- <div class="button-share" id="fb-share" onclick="sharefacebook()"><button>แชร์</button></div> -->
        
    </div>
</section>

<script>
function sharefacebook(){ 
    FB.ui({
        method: 'feed',
        link: 'https://optimumpeptides.com/',
        name: "ShowTest",
        message: "Posted using FB.ui and picture.",
        display: 'iframe',
        caption: "Caption",
        description: "Description field",
        actions:{name:"Test Post"},

    }, function(response){
        if (response && !response.error_message) {
            alert('Posting completed.');
        } else {
            alert('Error while posting.');
        }
    });
}

  window.fbAsyncInit = function() {
    FB.init({
      appId            : '572717636677186',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v6.0'
    });
  };
</script>
<script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>



<?php get_footer(); ?>