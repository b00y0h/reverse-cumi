<?php

/**
 * Template Name: Homepage Style 5
 */

get_header(); ?>

<div id="jms-slideshow" class="jms-slideshow">
<div class="slideshow-top-shadow"></div>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	query_posts( array( 
						 'post_type' => 'slideshow', 
						 'paged' => $paged, 
						 'posts_per_page' => of_get_option('slideshow_nr_posts'),
						 'ignore_sticky_posts' => 1,
						 'slideshow_category' => 'jmpress'
						 )
				  );
$k = 1;				  
if ( have_posts() ) : while ( have_posts() ) : the_post(); 

$slideshow_video_link = rwmb_meta( 'gg_slideshow_video_link' );
$slideshow_external_link = rwmb_meta( 'gg_slideshow_external_link' );
$slideshow_caption_title = rwmb_meta( 'gg_slideshow_caption_title' );
$slideshow_caption_subtitle = rwmb_meta( 'gg_slideshow_caption_subtitle' );
?>

<div class="step" data-color="color-1"  <?php if($k%2 == 0) echo 'data-y="500" data-scale="0.4" data-rotate-x="30"'; ?>>
    <div class="jms-content">
        <h3><?php echo $slideshow_caption_title; ?></h3>
        <p><?php echo $slideshow_caption_subtitle; ?></p>
        <a class="jms-link" href="#">Read more</a>
    </div>
    <?php the_post_thumbnail( 'jmpress-thumbnail' ); ?>
</div>


<?php $k++; endwhile; endif; ?>
</div>

<script type="text/javascript">
	jQuery(function() {
		
		var jmpressOpts	= {
			animation		: { transitionDuration : '0.8s' }
		};
		
		jQuery( '#jms-slideshow' ).jmslideshow( jQuery.extend( true, { jmpressOpts : jmpressOpts }, {
			autoplay	: true,
			interval    : 3500,
			bgColorSpeed: '0.8s',
			arrows		: false,
			dots        : true
		}));
		
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
		
		echo do_shortcode('[headline title="Browse our best selling products" border_bottom="no" border_top="yes"]'.$headline_desc.'[/headline]');
		
		//Best selling
		$best_selling_products_title = of_get_option('best_selling_products_title');
		$best_selling_products_carousel = of_get_option('best_selling_products_carousel');
		$best_selling_products_carousel_autoplay = of_get_option('best_selling_products_carousel_autoplay');
		$best_selling_products_posts = of_get_option('best_selling_products_posts');
		$best_selling_products_orderby = of_get_option('best_selling_products_orderby');
		$best_selling_products_order = of_get_option('best_selling_products_order');
		//echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[best_selling_products per_page="50" orderby="'.$best_selling_products_orderby.'" order="'.$best_selling_products_order.'" carousel_mode="yes" slideshow="true"]');
		

?>

</div><!-- /#homepage -->

<?php 
st_after_content();
?>

</div><!--Close container-->

<?php get_footer(); ?>