<?php

/**
 * Template Name: Homepage Style 3
 */

get_header(); ?>

<div class="iview-wrapper">
<div class="slideshow-top-shadow"></div>
<div id="iview">
<?php

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	query_posts( array( 
						 'post_type' => 'slideshow', 
						 'paged' => $paged, 
						 'posts_per_page' => of_get_option('slideshow_nr_posts'),
						 'ignore_sticky_posts' => 1,
						 'slideshow_category' => 'iview'
						 )
				  );

if ( have_posts() ) : while ( have_posts() ) : the_post(); 

$slideshow_video_link = rwmb_meta( 'gg_slideshow_video_link' );
$slideshow_external_link = rwmb_meta( 'gg_slideshow_external_link' );
$slideshow_caption_title = rwmb_meta( 'gg_slideshow_caption_title' );
$slideshow_caption_subtitle = rwmb_meta( 'gg_slideshow_caption_subtitle' );
$imageArray = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slideshow-thumbnail' );
$imageURL = $imageArray[0]; // image url
?>

<div data-iview:image="<?php echo $imageURL; ?>" data-iview:transition="zigzag-drop-top,zigzag-drop-bottom" data-iview:pausetime="3000">
    <div class="iview-caption caption5" data-x="160" data-y="180" data-transition="wipeDown"><?php echo $slideshow_caption_title; ?></div>
    <div class="iview-caption caption6" data-x="160" data-y="250" data-transition="wipeUp"><?php echo $slideshow_caption_subtitle; ?></div>
</div>


<?php endwhile; endif; ?>
</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#iview').iView({
		pauseTime: 8000000000,
		directionNav: false,
		controlNav: true,
		tooltipY: -15,
		pauseOnHover: true
	});
});
</script>

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
		
		echo do_shortcode('[headline title="Browse our categories" border_bottom="no" border_top="yes"]'.$headline_desc.'[/headline]');
		
		//Categories
		$products_category_title = of_get_option('products_category_title');
		$products_category_carousel = of_get_option('products_category_carousel');
		$products_category_carousel_autoplay = of_get_option('products_category_carousel_autoplay');
		$products_category_orderby = of_get_option('products_category_orderby');
		$products_category_order = of_get_option('products_category_order');
		$products_category_posts = of_get_option('products_category_posts');
		echo '<div class="hr-bullet"></div>';	
		echo '<div class="products-wrapper">';

        echo do_shortcode('[product_categories columns="'.$sh_columns.'" number="20" orderby="'.$products_category_orderby.'" order="'.$products_category_order.'" parent="0"]');
		
		echo '</div>';

?>

</div><!-- /#homepage -->

<?php 
st_after_content();
?>

</div><!--Close container-->

<?php get_footer(); ?>