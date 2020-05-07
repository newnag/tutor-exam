<?php 
$categories = get_categories();
//print_r($categories);

get_header(); ?>

<?php while(have_posts()) : the_post() ?>
    <main>
        <article>
            <div class="content container">
                <?php the_content(); ?>
            </div>
        </article>

        <section>
            <div class="game-start">
                <button id="gamestart">เริ่มเกม</button>
            </div>

            <div class="edu-level">
                <div class="list-level">
                    <button data-cat="<?php echo $categories[2]->name ?>"><?php echo $categories[2]->name ?></button>
                    <button data-cat="<?php echo $categories[3]->name ?>"><?php echo $categories[3]->name ?></button>
                </div>
            </div>
        </section>
    </main>
<?php endwhile; ?>

<?php get_footer() ?>
