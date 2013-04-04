<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
 */
// You can override via functions.php conditionals or define:
// $columns = 'four';

get_header(); ?>

<div class="container">

<?php
//Retrieve and verify sidebars 
$pages_sidebar = rwmb_meta('gg_secondary-widget-area');
$footer_sidebar_1 = rwmb_meta('gg_first-footer-widget-area');
$footer_sidebar_2 = rwmb_meta('gg_second-footer-widget-area');
$footer_sidebar_3 = rwmb_meta('gg_third-footer-widget-area');
$footer_sidebar_4 = rwmb_meta('gg_fourth-footer-widget-area');
$sidebar_list = of_get_option('sidebar_list');
if ($sidebar_list) : $sidebar_footer1_exists = in_array_r($footer_sidebar_1, $sidebar_list); else : $sidebar_footer1_exists = false; endif;
if ($sidebar_list) : $sidebar_footer2_exists = in_array_r($footer_sidebar_2, $sidebar_list); else : $sidebar_footer2_exists = false; endif;
if ($sidebar_list) : $sidebar_footer3_exists = in_array_r($footer_sidebar_3, $sidebar_list); else : $sidebar_footer3_exists = false; endif;
if ($sidebar_list) : $sidebar_footer4_exists = in_array_r($footer_sidebar_4, $sidebar_list); else : $sidebar_footer4_exists = false; endif;
if ($sidebar_list) : $pages_sidebar_exists = in_array_r($pages_sidebar, $sidebar_list); else : $pages_sidebar_exists = false; endif;

st_before_content($columns='');
if (rwmb_meta('gg_page_breadcrumbs')){ if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();}
if (rwmb_meta('gg_page_title')){ echo '<h1 class="entry-title">'.get_the_title().'</h1>'; }     
get_template_part( 'loop', 'page' );
st_after_content();
get_sidebar("page");
?>

</div><!--Close container-->

<?php  get_footer(); ?>