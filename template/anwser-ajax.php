

<?php while($query->have_posts()) : $query->the_post() ?>
    <div class="test" id="<?php echo $post->ID ?>"></div>
<?php endwhile; ?>