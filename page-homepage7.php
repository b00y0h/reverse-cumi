<?php

/**
 * Template Name: Homepage Style 7
 */

get_header(); ?>
<div class="clear"></div>

<div class="container">
<?php 
$homepage_layout = of_get_option('homepage_layout');
$homepage_sidebar = of_get_option('homepage_sidebar_select');
st_before_content($columns=''); ?>

<div id="homepage-style-default" class="with-sidebar">

<?php
$layout_width = of_get_option('layout_width');

if ($layout_width == 'layout_width_1140') {
		$sh_columns = '4';
} else {
		$sh_columns = '3';
}

		//featured products
		$featured_products_title = of_get_option('featured_products_title');
		$featured_products_carousel = of_get_option('featured_products_carousel');
		$featured_products_carousel_autoplay = of_get_option('featured_products_carousel_autoplay');
		$featured_products_posts = of_get_option('featured_products_posts');
		$featured_products_orderby = of_get_option('featured_products_orderby');
		$featured_products_order = of_get_option('featured_products_order'); 
		echo '<div class="products-wrapper">';
        if ($featured_products_title) echo '<h3 class="widget-title">'.$featured_products_title.'</h3>';
        echo do_shortcode('[featured_products columns="'.$sh_columns.'" per_page="'.$featured_products_posts.'" orderby="'.$featured_products_orderby.'" order="'.$featured_products_order.'"]');
		
		echo '</div>';
		
		//Sale products area
		$sale_products_title = of_get_option('sale_products_title');
		$sale_products_carousel = of_get_option('sale_products_carousel');
		$sale_products_carousel_autoplay = of_get_option('sale_products_carousel_autoplay');
		$sale_products_posts = of_get_option('sale_products_posts');
		$sale_products_orderby = of_get_option('sale_products_orderby');
		$sale_products_order = of_get_option('sale_products_order');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[sale_products columns="'.$sh_columns.'" title="'.$sale_products_title.'" per_page="'.$sale_products_posts.'" orderby="'.$sale_products_orderby.'" order="'.$sale_products_order.'" carousel_mode="no" slideshow="false"]');
?>

</div><!-- /#homepage -->

<?php 
st_after_content();
get_sidebar("homepage");
?>

</div><!--Close container-->

<?php get_footer(); ?>