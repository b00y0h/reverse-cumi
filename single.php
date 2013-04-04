<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

<div class="container">

<?php

//Retrieve and verify sidebars 
$posts_sidebar = rwmb_meta('gg_primary-widget-area');
$footer_sidebar_1 = rwmb_meta('gg_first-footer-widget-area');
$footer_sidebar_2 = rwmb_meta('gg_second-footer-widget-area');
$footer_sidebar_3 = rwmb_meta('gg_third-footer-widget-area');
$footer_sidebar_4 = rwmb_meta('gg_fourth-footer-widget-area');
$sidebar_list = of_get_option('sidebar_list');
if ($sidebar_list) : $sidebar_footer1_exists = in_array_r($footer_sidebar_1, $sidebar_list); else : $sidebar_footer1_exists = false; endif;
if ($sidebar_list) : $sidebar_footer2_exists = in_array_r($footer_sidebar_2, $sidebar_list); else : $sidebar_footer2_exists = false; endif;
if ($sidebar_list) : $sidebar_footer3_exists = in_array_r($footer_sidebar_3, $sidebar_list); else : $sidebar_footer3_exists = false; endif;
if ($sidebar_list) : $sidebar_footer4_exists = in_array_r($footer_sidebar_4, $sidebar_list); else : $sidebar_footer4_exists = false; endif;
if ($sidebar_list) : $posts_sidebar_exists = in_array_r($posts_sidebar, $sidebar_list); else : $posts_sidebar_exists = false; endif;

st_before_content($columns='');
if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();
get_template_part( 'loop', 'single' );
st_after_content();
get_sidebar();
?>

</div><!--Close container-->

<?php get_footer(); ?>