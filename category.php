<?php 
global $post;
get_header(); ?>

<?php
    // เช็คชื่อหมวดหมู่
    $category = get_queried_object();
    //print_r($category);
    //echo $category->name;

    // คิวรี่โพส
    $query = new WP_Query(array(
        'orderby'           =>  'rand',
        'posts_per_page'    =>  3,
    ));
?>

<section>
    <div class="game-zone">
        <?php while($query->have_posts()) : $query->the_post() ?>
            <div class="box" id="<?php echo $post->ID ?>" data-ans="<?php echo get_the_excerpt() ?>">
                <h2><?php the_title() ?></h2>
                <div class="button-group">
                    <button class="next-button">Click</button>
                    <button class="next-button"><?php echo get_the_excerpt() ?></button>
                    <button class="next-button">Click</button>
                    <button class="next-button">Click</button>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="score">
        <h2>0</h2>
    </div>
</section>

<?php get_footer() ?>