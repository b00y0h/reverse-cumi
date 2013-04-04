<?php

/**
 * Template Name: Homepage Style 4
 */

get_header(); ?>

<div id="slider" class="sl-slider-wrapper">
<div class="slideshow-top-shadow"></div>
<div class="sl-slider">
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	query_posts( array( 
						 'post_type' => 'slideshow', 
						 'paged' => $paged, 
						 'posts_per_page' => of_get_option('slideshow_nr_posts'),
						 'ignore_sticky_posts' => 1,
						 'slideshow_category' => 'slit'
						 )
				  );

if ( have_posts() ) : while ( have_posts() ) : the_post(); 

$slideshow_video_link = rwmb_meta( 'gg_slideshow_video_link' );
$slideshow_external_link = rwmb_meta( 'gg_slideshow_external_link' );
$slideshow_caption_title = rwmb_meta( 'gg_slideshow_caption_title' );
$slideshow_caption_subtitle = rwmb_meta( 'gg_slideshow_caption_subtitle' );
?>

<?php 
$slitID = rand();
$imageArray = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slideshow-thumbnail' );
$imageURL = $imageArray[0]; // image url
?>
<style type="text/css">.bg-img-<?php echo $slitID; ?> {background-image: url(<?php echo $imageURL; ?>);}</style>
<div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
    <div class="sl-slide-inner">
        <div class="bg-img bg-img-<?php echo $slitID; ?>"></div>
        <h2><?php echo $slideshow_caption_title; ?></h2>
        <blockquote><p><?php echo $slideshow_caption_subtitle; ?></p></blockquote>
    </div>
</div>

<?php endwhile; endif; ?>
</div>

<?php rewind_posts(); ?>

<nav id="nav-dots" class="nav-dots">
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	query_posts( array( 
						 'post_type' => 'slideshow', 
						 'paged' => $paged, 
						 'posts_per_page' => of_get_option('slideshow_nr_posts'),
						 'ignore_sticky_posts' => 1,
						 'slideshow_category' => 'slit'
						 )
				  );
$iterate = 0;
if ( have_posts() ) : while ( have_posts() ) : the_post(); $iterate++; ?>

<span class="<?php if ($iterate == 1) echo 'nav-dot-current'; ?>"></span>

<?php endwhile; endif; ?>
</nav>

</div>

<script type="text/javascript">	
jQuery(function() {

	var Page = (function() {

		var jQuerynav = jQuery( '#nav-dots > span' ),
			slitslider = jQuery( '#slider' ).slitslider( {
				onBeforeChange : function( slide, pos ) {

					jQuerynav.removeClass( 'nav-dot-current' );
					jQuerynav.eq( pos ).addClass( 'nav-dot-current' );

				}
			} ),

			init = function() {

				initEvents();
				
			},
			initEvents = function() {

				jQuerynav.each( function( i ) {
				
					jQuery( this ).on( 'click', function( event ) {
						
						var jQuerydot = jQuery( this );
						
						if( !slitslider.isActive() ) {

							jQuerynav.removeClass( 'nav-dot-current' );
							jQuerydot.addClass( 'nav-dot-current' );
						
						}
						
						slitslider.jump( i + 1 );
						return false;
					
					} );
					
				} );

			};

			return { init : init };

	})();

	Page.init();

	/**
	 * Notes: 
	 * 
	 * example how to add items:
	 */

	/*
	
	var $items  = $('<div class="sl-slide sl-slide-color-2" data-orientation="horizontal" data-slice1-rotation="-5" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1"><div class="sl-slide-inner bg-1"><div class="sl-deco" data-icon="t"></div><h2>some text</h2><blockquote><p>bla bla</p><cite>Margi Clarke</cite></blockquote></div></div>');
	
	// call the plugin's add method
	ss.add($items);

	*/

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
		
		echo do_shortcode('[headline title="Browse our promotions" border_bottom="no" border_top="yes"]'.$headline_desc.'[/headline]');
		
		$ads_title = of_get_option('ads_title');
		$ads_carousel = of_get_option('ads_carousel');
		$ads_carousel_autoplay = of_get_option('ads_carousel_autoplay');
		$ads_orderby = of_get_option('ads_orderby');
		$ads_order = of_get_option('ads_order');
		$ads_posts = of_get_option('ads_posts');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[ads_posts columns="'.$sh_columns.'" title="'.$ads_title.'" limit="'.$ads_posts.'" orderby="'.$ads_orderby.'" order="'.$ads_order.'" carousel_mode="yes" slideshow="false"]');


?>

</div><!-- /#homepage -->

<?php 
st_after_content();
?>

</div><!--Close container-->

<?php get_footer(); ?>