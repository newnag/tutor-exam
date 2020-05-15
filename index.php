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
                    <a href="<?php echo site_url().'/category/'.$categories[2]->name ?>"><button><?php echo $categories[2]->name ?></button></a>
                    <a href="<?php echo site_url().'/category/'.$categories[3]->name ?>"><button><?php echo $categories[3]->name ?></button></a>
                </div>
            </div>
        </section>
    </main>
<?php endwhile; ?>

<?php get_footer() ?>
