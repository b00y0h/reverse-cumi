<?php

/**
 * Template Name: Portfolio page
 */

get_header(); ?>

<div class="container">

<?php
//Retrieve and verify sidebars 
$portfolio_sidebar = rwmb_meta('gg_portfolio-widget-area');
$portfolio_style = rwmb_meta('gg_portfolio_page_style');
$sidebar_list = of_get_option('sidebar_list');
if ($sidebar_list) : $portfolio_sidebar_exists = in_array_r($portfolio_sidebar, $sidebar_list); else : $portfolio_sidebar_exists = false; endif;


if ($portfolio_style == 'sidebar') { st_before_content($columns=''); } else { st_before_content($columns='twelve'); }

if (rwmb_meta('gg_page_breadcrumbs')){ if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();}
if (rwmb_meta('gg_page_title')){ echo '<h1 class="entry-title">'.get_the_title().'</h1>'; }  

if ($portfolio_style == 'classic') {
	get_template_part( 'loop', 'portfolio' );
} elseif ($portfolio_style == 'sidebar') {
	get_template_part( 'loop', 'portfolio-sidebar' );
} elseif ($portfolio_style == 'filterable') {
	get_template_part( 'loop', 'portfolio-filterable' );
} else {
	get_template_part( 'loop', 'portfolio' );
}
st_after_content();

if ($portfolio_style == 'sidebar') {get_sidebar('portfolio');}
?>

</div><!--Close container-->

<?php get_footer(); ?>