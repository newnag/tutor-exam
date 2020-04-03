<?php /* Template Name: complate */ ?>
<?php 

$current_user = wp_get_current_user();
if ( 0 == $current_user->ID ) {
    echo 'Not Login';
} else {
    echo 'Login';
}

$score = $_REQUEST["score"];

get_header(); ?>

<div class="container">
    <div class="result-zone">
        <div class="result">
            <h1>Score = <?php echo $score ?></h1>
        </div>
    </div>
</div>

<?php get_footer(); ?>