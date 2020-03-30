<?php get_header(); ?>

<?php while(have_posts()) : the_post() ?>
    <main>
        <article>
            <div class="content container">
                <?php the_content(); ?>
            </div>
        </article>
    </main>
<?php endwhile; ?>

<?php get_footer() ?>
