<?php
/**
 * Template Name: One column page
*/

get_header(); ?>

<div class="container">

<?php 
st_before_content($columns='');
if (rwmb_meta('gg_page_breadcrumbs')){ if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();}
if (rwmb_meta('gg_page_title')){ echo '<h1 class="entry-title">'.get_the_title().'</h1>'; }  

get_template_part( 'loop', 'page' );
st_after_content();
?>

</div><!--Close container-->

<?php get_footer(); ?>
