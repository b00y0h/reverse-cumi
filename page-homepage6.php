<?php

/**
 * Template Name: Homepage Style 6
 */

get_header(); ?>

<div class="clear"></div>

<div id="mi-slider" class="mi-slider">
<?php 
$product_cats = of_get_option('product_cats', 'none' ); 
?>

<?php
if ( is_array($product_cats) ) {
	$product_cats_output = array();
	foreach ($product_cats as $key => $value) {
		if ($value =='1') {$product_cats_output[] = $key;}
	}
}

$args = array(
		'orderby'       => 'include', 
		'order'         => 'ASC',
		'hide_empty'    => false, 
		'include'       => implode(', ', $product_cats_output),
		'fields'        => 'all', 
		'pad_counts'    => false, 
	); 
$product_cat_terms = get_terms( 'product_cat', $args );
foreach ($product_cat_terms as $product_cat_term) {
echo "<ul>";
$args = array(
        'post_type' => 'product',
        'posts_per_page' => 4,
        'tax_query' => array(
                array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => $product_cat_term->slug
                )
        )
);
$new = new WP_Query($args);
while ($new->have_posts()) {
$new->the_post();
echo '<li><a href="'. get_permalink() . '">';
if ( has_post_thumbnail() ) { the_post_thumbnail( 'slideshow-thumbnail' ); }
echo '<h4>'.get_the_title().'</h4></a></li>';
}
echo "</ul>";
} 
?>



<nav>
<?php
foreach ($product_cat_terms as $product_cat_term) {
	echo "<a href='#'>".$product_cat_term->name."</a>";
}
?>
</nav>
</div>

<script type="text/javascript">
  jQuery(function() {
	  jQuery( '#mi-slider' ).catslider();
  });
</script>
<?php wp_reset_query(); ?>

<div class="clear"></div>

<div class="container">
<?php 
$homepage_layout = of_get_option('homepage_layout');
$homepage_sidebar = of_get_option('homepage_sidebar_select');
st_before_content($columns='twelve'); ?>

<div id="homepage-style-default">

<?php
$layout_width = of_get_option('layout_width');

if ($layout_width == 'layout_width_1140') {
		$sh_columns = '5';
} else {
		$sh_columns = '4';
		
}
		//Headline
		$headline_title = of_get_option('headline_title');
		$headline_title_link = of_get_option('headline_title_link');
		$headline_desc = of_get_option('headline_desc');
		
		echo do_shortcode('[headline title="Browse our best selling products" border_bottom="no" border_top="yes"]'.$headline_desc.'[/headline]');
		
		$ads_title = of_get_option('ads_title');
		$ads_carousel = of_get_option('ads_carousel');
		$ads_carousel_autoplay = of_get_option('ads_carousel_autoplay');
		$ads_orderby = of_get_option('ads_orderby');
		$ads_order = of_get_option('ads_order');
		$ads_posts = of_get_option('ads_posts');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[ads_posts columns="'.$sh_columns.'" title="'.$ads_title.'" limit="'.$ads_posts.'" orderby="'.$ads_orderby.'" order="'.$ads_order.'" carousel_mode="'.$ads_carousel.'" slideshow="'.$ads_carousel_autoplay.'"]');
		

?>

</div><!-- /#homepage -->

<?php 
st_after_content();
?>

</div><!--Close container-->

<?php get_footer(); ?>