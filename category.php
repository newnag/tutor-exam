<?php 
global $post;

$link .= urldecode($_SERVER['REQUEST_URI']);

$path = explode('/',$link);
// $path[3] ตือตำแหน่งที่ใช้อ้างอิงหมวดหมู่ย่อย

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
    <div class="subject">
        <?php
            foreach($term_name as $value) {
                echo '<button class="next-button" data-cat="'.urldecode($value).'">'.urldecode($value).'</button>';
            }
        ?>
    </div>
</section>

<?php
    if($cate === ''){
        $look = false;
    }
    else{
        $look = true;
    }

    // คิวรี่โพส
    $query = new WP_Query(array(
        'orderby'           =>  'rand',
        'posts_per_page'    =>  8,
        'category_name'    =>  $cate,
    ));
?>

<!-- ส่วนคำถาม -->
<?php if($look == true): ?>
    <section>
        <div class="game-zone">
            <?php while($query->have_posts()) : $query->the_post() ?>
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

        <div class="score">
            <h1>คะแนนที่ได้</h1>
            <h2>0</h2>
        </div>
    </section>

    <!-- ส่วนตัวช่วย -->
    <div class="helper">
        <h2>ตัวช่วย</h2>
        <div class="button-group">
            <button class="help" id="cheat-ans"><i class="fab fa-hire-a-helper"></i>เฉลยคำตอบ เหลือ 1</button>
            <button class="help" id="cut-ans"><i class="fab fa-hire-a-helper"></i>ตัดข้อทิ้ง เหลือ 1</button>
        </div>
    </div>

<?php endif; ?>

<?php get_footer() ?>