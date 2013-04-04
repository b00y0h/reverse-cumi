<?php
/**
 * The Template for displaying product single posts.
 */

get_header(); ?>

<div class="container">

<?php 
st_before_content($columns='twelve');
do_action('woocommerce_before_main_content'); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		
<?php woocommerce_get_template_part( 'content', 'single-product' ); ?>

<?php endwhile; ?>

<?php
do_action('woocommerce_after_main_content');
st_after_content();
?>

</div><!--Close container-->

<?php get_footer(); ?>
