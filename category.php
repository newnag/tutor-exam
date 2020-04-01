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


//$cat = get_the_category();
//print_r($cat);

//$parentCatName = get_cat_name($cat[0]->term_id);

//print_r($parentCatName);
//echo $parentCatName;

get_header(); ?>

<section>
    <div class="subject">
        <button class="next-button" data-cat=""></button>
    </div>
</section>

<?php
    // คิวรี่โพส
    $query = new WP_Query(array(
        'orderby'           =>  'rand',
        'posts_per_page'    =>  8,
        'category_name '    =>  $cate,
    ));
?>

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
        <h2>0</h2>
    </div>
</section>

<?php get_footer() ?>