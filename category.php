<?php 
global $post;

$current_user = wp_get_current_user();
$cur_date = date("Y/m/d");
$userid = $current_user->ID; // User ID ของผู้ใช้ปัจจุบัน
$date = get_user_meta($userid,'datetime',true); // เรียกค่าscoreจาก DB ออกมา
$rank_count = get_user_meta($userid,'rank_count',true);

if( 0 != $current_user->ID ){
    if($date == null){
        update_user_meta( $userid, 'datetime', $cur_date);
        update_user_meta( $userid, 'rank_count',5);
    }
    elseif($date < $cur_date){
        update_user_meta( $userid, 'datetime', $cur_date);
        update_user_meta( $userid, 'rank_count',5);
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$link = urldecode($_SERVER['REQUEST_URI']);
$path = explode('/',$link);
// $path[3] ตือตำแหน่งที่ใช้อ้างอิงหมวดหมู่ย่อย
//print_r($path);
$cate = $path[3];

// เช็คชื่อหมวดหมู่
$category = get_queried_object();
//print_r($category);
//echo $category->name;

// หมวดหมู่ย่อย
$args = array(
    'parent' => get_queried_object_id(),
); 
$terms = get_terms( 'category', $args );
$term_name = wp_list_pluck( $terms, 'slug');
//print_r($term_name) ;

get_header(); ?>

<section>
    <?php if($_REQUEST['mode'] == ""): // เลือกโหมดการเล่น หากเลือกแล้วจะมีparamขึ้น และelementนี้จะไม่แสดง ?>
        <div class="mode-game">
            <button data-mode="easy">ธรรมดา</button>
            <button data-mode="sp">พิเศษ</button>
            <button data-mode="rank">แรงค์กิ้ง</button>
        </div>
    <?php endif; ?>

    <div class="subject">
        <?php
            if($term_name != null){
                foreach($term_name as $value) {
                    echo '<button class="next-button" data-cat="'.urldecode($value).'">'.urldecode($value).'</button>';
                }
            }
            else{
                echo '<h2>ยังไม่มีข้อสอบในขณะนี้ แจ้งผู้ดูแลเพื่อให้ทำการเพิ่มข้อสอบในส่วนนี้</h2>';
            }
        ?>
    </div>
</section>

<?php
    // เช็คสถานะการเลือกหมวดหมู่ย่อย หากยังไม่เลือกจะไม่แสดงคำถาม
    if($cate === ''){
        $look = false; 
    }
    else{
        $look = true;
    }

    // คิวรี่โพส
    $queryez = new WP_Query(array(
        'orderby'           =>  'rand',
        'posts_per_page'    =>  15,
        'category_name'    =>  $cate,
    ));
    $querysp = new WP_Query(array(
        'orderby'           =>  'rand',
        'posts_per_page'    =>  100,
    ));
    $queryrank = new WP_Query(array(
        'orderby'           =>  'rand',
        'posts_per_page'    =>  20,
    ));
?>



<!-- ส่วนคำถาม -->
<?php if($look == true): ?>
    <section>
        <div class="detail-game">
            <div class="game-score">
                <div class="total-game">จำนวนข้อ <span id="min-game">0</span>/<span id="max-game"></span></div>
                <div class="score">
                    <h1>คะแนนที่ได้</h1>
                    <h2>0</h2>
                </div>
            </div>

            <div class="timer">
                <label id="time-min">00</label>:<label id="time-sec">00</label>
            </div>
        </div>
    </section>

    <?php if(have_posts()): ?>
        <section id="gamezone" data-gamemode="<?php echo $_REQUEST['mode'] ?>">
            <?php if($_REQUEST['mode'] === "easy"): ?>
                <div class="game-zone game-zone-ez">
                    <?php while($queryez->have_posts()) : $queryez->the_post() ?>
                        <div class="box" id="<?php echo $post->ID ?>" data-ans="<?php echo get_post_meta(get_the_ID(),'correct_anw',true) ?>">
                            <h2><?php the_title() ?></h2>
                            <p class="question-box"><?php echo get_post_meta(get_the_ID(),'question',true) ?></p>
                            <div class="button-group">
                                <?php
                                    $ans1 = '<button class="next-button">'.get_post_meta(get_the_ID(),'normal_anw1',true).'</button>';
                                    $ans2 = '<button class="next-button">'.get_post_meta(get_the_ID(),'normal_anw2',true).'</button>';
                                    $ans3 = '<button class="next-button">'.get_post_meta(get_the_ID(),'normal_anw3',true).'</button>';
                                    $ans4 = '<button class="next-button">'.get_post_meta(get_the_ID(),'correct_anw',true).'</button>';

                                    $anw_array = array($ans1,$ans2,$ans3,$ans4);
                                    $random = range(0,3);
                                    shuffle($random);
                                    for($a=0;$a<=count($anw_array);$a++){
                                        //print_r($random) ;
                                        echo $anw_array[$random[$a]];
                                    }
                                ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php elseif($_REQUEST['mode'] === "sp"): ?>
                <div class="game-zone game-zone-sp">
                    <?php while($querysp->have_posts()) : $querysp->the_post() ?>
                        <div class="box" id="<?php echo $post->ID ?>" data-ans="<?php echo get_post_meta(get_the_ID(),'correct_anw',true) ?>">
                            <h2><?php the_title() ?></h2>
                            <p class="question-box"><?php echo get_post_meta(get_the_ID(),'question',true) ?></p>
                            <div class="button-group">
                                <?php
                                    $ans1 = '<button class="next-button">'.get_post_meta(get_the_ID(),'normal_anw1',true).'</button>';
                                    $ans2 = '<button class="next-button">'.get_post_meta(get_the_ID(),'normal_anw2',true).'</button>';
                                    $ans3 = '<button class="next-button">'.get_post_meta(get_the_ID(),'normal_anw3',true).'</button>';
                                    $ans4 = '<button class="next-button">'.get_post_meta(get_the_ID(),'correct_anw',true).'</button>';

                                    $anw_array = array($ans1,$ans2,$ans3,$ans4);
                                    $random = range(0,3);
                                    shuffle($random);
                                    for($a=0;$a<=count($anw_array);$a++){
                                        //print_r($random) ;
                                        echo $anw_array[$random[$a]];
                                    }
                                ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php elseif($_REQUEST['mode'] === "rank"): ?>
                <?php if( 0 == $current_user->ID ): ?>
                    <div id="notlogin"></div>
                <?php else: ?>
                    <?php if($rank_count > 0): ?>
                        <div class="game-zone game-zone-rank">
                            <?php while($queryrank->have_posts()) : $queryrank->the_post() ?>
                                <div class="box" id="<?php echo $post->ID ?>" data-ans="<?php echo get_post_meta(get_the_ID(),'correct_anw',true) ?>">
                                    <h2><?php the_title() ?></h2>
                                    <p class="question-box"><?php echo get_post_meta(get_the_ID(),'question',true) ?></p>
                                    <div class="button-group">
                                        <?php
                                            $ans1 = '<button class="next-button">'.get_post_meta(get_the_ID(),'normal_anw1',true).'</button>';
                                            $ans2 = '<button class="next-button">'.get_post_meta(get_the_ID(),'normal_anw2',true).'</button>';
                                            $ans3 = '<button class="next-button">'.get_post_meta(get_the_ID(),'normal_anw3',true).'</button>';
                                            $ans4 = '<button class="next-button">'.get_post_meta(get_the_ID(),'correct_anw',true).'</button>';

                                            $anw_array = array($ans1,$ans2,$ans3,$ans4);
                                            $random = range(0,3);
                                            shuffle($random);
                                            for($a=0;$a<=count($anw_array);$a++){
                                                //print_r($random) ;
                                                echo $anw_array[$random[$a]];
                                            }
                                        ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div id="rankpoint0"></div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </section>

        <!-- ส่วนตัวช่วย -->
        <div class="helper">
            <h2>ตัวช่วย</h2>
            <div class="button-group">
                <button class="help" id="cheat-ans"><i class="fab fa-hire-a-helper"></i>เฉลยคำตอบ</button>
                <button class="help" id="cut-ans"><i class="fab fa-hire-a-helper"></i>ตัดข้อทิ้ง</button>
            </div>
        </div>
    <?php else: ?>
        <h2>ยังไม่มีคำถามในวิชานี้ โปรดติดต่อผู้ดูแลระบบ</h2>
    <?php endif; ?>

<?php endif; ?>



<?php get_footer() ?>