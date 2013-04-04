<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

<?php 
//st_before_content($columns='sixteen');
get_template_part( 'loop', 'singleportfolio' );
st_after_content();
?>

</div><!--Close container-->

<?php get_footer(); ?>