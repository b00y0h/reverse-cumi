<?php

/**
 * Template Name: Homepage Style 1
 */

get_header(); ?>

<div id="sequence-theme">
<div class="slideshow-top-shadow"></div>
<div id="sequence">
<img class="prev" src="<?php echo get_stylesheet_directory_uri();?>/images/bt-prev.png" alt="Previous Frame" />
<img class="next" src="<?php echo get_stylesheet_directory_uri();?>/images/bt-next.png" alt="Next Frame" />
<ul>

<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	query_posts( array( 
						 'post_type' => 'slideshow', 
						 'paged' => $paged, 
						 'posts_per_page' => of_get_option('slideshow_nr_posts'),
						 'ignore_sticky_posts' => 1,
						 'slideshow_category' => 'sequence'
						 )
				  );

if ( have_posts() ) : while ( have_posts() ) : the_post(); 

$slideshow_video_link = rwmb_meta( 'gg_slideshow_video_link' );
$slideshow_external_link = rwmb_meta( 'gg_slideshow_external_link' );
$slideshow_caption_title = rwmb_meta( 'gg_slideshow_caption_title' );
$slideshow_caption_subtitle = rwmb_meta( 'gg_slideshow_caption_subtitle' );
?>

<li>
	<?php
	if ($slideshow_caption_title) echo '<h2 class="title animate-in">'.$slideshow_caption_title.'</h2>';
	if ($slideshow_caption_subtitle) echo '<h3 class="subtitle animate-in">'.$slideshow_caption_subtitle.'</h3>';
	?>
    
	<?php the_post_thumbnail( 'sequence-thumbnail' , array('class' => 'model x animate-in')); ?>
</li>

<?php endwhile; endif; ?>

</ul>
</div>

<ul class="nav">
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	query_posts( array( 
						 'post_type' => 'slideshow', 
						 'paged' => $paged, 
						 'posts_per_page' => of_get_option('slideshow_nr_posts'),
						 'ignore_sticky_posts' => 1,
						 'slideshow_category' => 'sequence'
						 )
				  );

if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<li><?php the_post_thumbnail( 'sequence-thumbnail-mini'); ?> </li>

<?php endwhile; endif; ?>    
</ul>
<?php wp_reset_query(); ?>

</div>

<script type="text/javascript">
jQuery(document).ready(function(){
  var options = {
	  nextButton: true,
	  prevButton: true,
	  animateStartingFrameIn: true,
	  autoPlayDelay: 3000,
	  preloader: true,
	  pauseOnHover: false,
	  preloadTheseFrames: [1]
  };
  
  var sequence = jQuery("#sequence").sequence(options).data("sequence");

  sequence.afterLoaded = function() {
	  jQuery("#sequence-theme .nav").fadeIn(100);
	  jQuery("#sequence-theme .nav li:nth-child("+(sequence.settings.startingFrameID)+") img").addClass("active");
  }

  sequence.beforeNextFrameAnimatesIn = function() {
	  jQuery("#sequence-theme .nav li:not(:nth-child("+(sequence.nextFrameID)+")) img").removeClass("active");
	  jQuery("#sequence-theme .nav li:nth-child("+(sequence.nextFrameID)+") img").addClass("active");
  }
  
  jQuery("#sequence-theme").on("click", ".nav li", function() {
	  jQuery(this).children("img").removeClass("active").children("img").addClass("active");
	  sequence.nextFrameID = jQuery(this).index()+1;
	  sequence.goTo(sequence.nextFrameID);
  });
});
</script>

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
        if ($woocommerce_is_active) {
		$featured_products_title = of_get_option('featured_products_title');
		$featured_products_carousel = of_get_option('featured_products_carousel');
		$featured_products_carousel_autoplay = of_get_option('featured_products_carousel_autoplay');
		$featured_products_posts = of_get_option('featured_products_posts');
		$featured_products_orderby = of_get_option('featured_products_orderby');
		$featured_products_order = of_get_option('featured_products_order'); 
		echo '<div class="hr-bullet"></div>';
		if ($featured_products_carousel == "yes") echo '<div class="flexslider carousel products-wrapper uniq-featured-products">';
		else echo '<div class="products-wrapper">';

        if ($featured_products_title) echo '<h3 class="widget-title">'.$featured_products_title.'</h3>';
        echo do_shortcode('[featured_products columns="'.$sh_columns.'" per_page="'.$featured_products_posts.'" orderby="'.$featured_products_orderby.'" order="'.$featured_products_order.'"]');
		
		echo '</div>';
		

		echo '<script type="text/javascript">';
		echo 'jQuery(document).ready(function(){jQuery(".products-wrapper.flexslider.carousel.uniq-featured-products").flexslider({';
		echo 'animation: "slide",move:1, selector: ".products > li", itemWidth: 220,itemMargin: 20,controlNav: false,slideshow: true,fixedHeightMiddleAlign: true';
		echo '});});</script>';
		} else { echo ''; }
		
		//Sale products area
		if ($woocommerce_is_active) {
		$sale_products_title = of_get_option('sale_products_title');
		$sale_products_carousel = of_get_option('sale_products_carousel');
		$sale_products_carousel_autoplay = of_get_option('sale_products_carousel_autoplay');
		$sale_products_posts = of_get_option('sale_products_posts');
		$sale_products_orderby = of_get_option('sale_products_orderby');
		$sale_products_order = of_get_option('sale_products_order');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[sale_products columns="'.$sh_columns.'" title="'.$sale_products_title.'" per_page="'.$sale_products_posts.'" orderby="'.$sale_products_orderby.'" order="'.$sale_products_order.'" carousel_mode="'.$sale_products_carousel.'" slideshow="true"]');
		}

		$testimonials_title = of_get_option('testimonials_title');
		$testimonials_carousel = of_get_option('testimonials_carousel');
		$testimonials_carousel_autoplay = of_get_option('testimonials_carousel_autoplay');
		$testimonials_orderby = of_get_option('testimonials_orderby');
		$testimonials_order = of_get_option('testimonials_order');
		$testimonials_posts = of_get_option('testimonials_posts');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[testimonials_posts columns="'.$sh_columns.'" title="'.$testimonials_title.'" limit="'.$testimonials_posts.'" orderby="'.$testimonials_orderby.'" order="'.$testimonials_order.'" carousel_mode="'.$testimonials_carousel.'" slideshow="'.$testimonials_carousel_autoplay.'"]');

?>

</div><!-- /#homepage -->

<?php 
st_after_content();
get_sidebar("homepage");
?>

</div><!--Close container-->

<?php get_footer(); ?>