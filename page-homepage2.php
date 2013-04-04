<?php

/**
 * Template Name: Homepage Style 2
 */

get_header(); ?>

<div id="ei-slider" class="ei-slider">
<div class="slideshow-top-shadow"></div>
<ul class="ei-slider-large">

<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	query_posts( array( 
						 'post_type' => 'slideshow', 
						 'paged' => $paged, 
						 'posts_per_page' => of_get_option('slideshow_nr_posts'),
						 'ignore_sticky_posts' => 1,
						 'slideshow_category' => 'elastic'
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
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( 'slideshow-thumbnail' );
	}
	
	if ($slideshow_caption_title || $slideshow_caption_subtitle || $slideshow_external_link) {
		echo '<div class="ei-title">';
		if ($slideshow_caption_title) echo '<h2>'.$slideshow_caption_title.'</h2>';
		if ($slideshow_caption_subtitle) echo '<h3>'.$slideshow_caption_subtitle.'</h3>';
		echo '</div>';
	}
	
	?>
    
</li>

<?php endwhile; endif; ?>

</ul>

<?php rewind_posts(); ?>

<ul class="ei-slider-thumbs">
    <li class="ei-slider-element">Current</li>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	query_posts( array( 
						 'post_type' => 'slideshow', 
						 'paged' => $paged, 
						 'posts_per_page' => of_get_option('slideshow_nr_posts'),
						 'ignore_sticky_posts' => 1,
						 'slideshow_category' => 'elastic'
						 )
				  );

if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<li>
<a href="#"><?php the_title(); ?></a>
<?php the_post_thumbnail( 'slideshow-thumbnail'); ?>
</li>

<?php endwhile; endif; ?>
</ul><!-- ei-slider-thumbs -->

</div>

<script type="text/javascript">
  jQuery(function() {
	  jQuery('#ei-slider').eislideshow({
		  easing		: 'easeOutExpo',
		  titleeasing	: 'easeOutExpo',
		  titlespeed	: 1200
	  });
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
		//headline
		$headline_title = of_get_option('headline_title');
		$headline_title_link = of_get_option('headline_title_link');
		$headline_desc = of_get_option('headline_desc');
		
		echo do_shortcode('[headline title="Homepage Corporate style" border_bottom="no" border_top="yes"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sed vulputate leo. Quisque neque tellus, ultrices quis luctus [/headline]');
		
		//portfolio
        $portfolio_title = of_get_option('portfolio_title');
		$portfolio_carousel = of_get_option('portfolio_carousel');
		$portfolio_carousel_autoplay = of_get_option('portfolio_carousel_autoplay');
		$portfolio_orderby = of_get_option('portfolio_orderby');
		$portfolio_order = of_get_option('portfolio_order');
		$portfolio_posts = of_get_option('portfolio_posts');
		$portfolio_categories = of_get_option('portfolio_categories');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[portfolio_posts columns="'.$sh_columns.'" title="'.$portfolio_title.'" carousel_mode="yes" limit="'.$portfolio_posts.'" cats="'.$portfolio_categories.'" orderby="'.$portfolio_orderby.'" order="'.$portfolio_order.'" slideshow="false"]');
		
		//Team
		$team_title = of_get_option('team_title');
		$team_carousel = of_get_option('team_carousel');
		$team_carousel_autoplay = of_get_option('team_carousel_autoplay');
		$team_orderby = of_get_option('team_orderby');
		$team_order = of_get_option('team_order');
		$team_posts = of_get_option('team_posts');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[team_posts columns="'.$sh_columns.'" title="'.$team_title.'" limit="'.$team_posts.'" orderby="'.$team_orderby.'" order="'.$team_order.'" carousel_mode="yes" slideshow="false"]');
		
		//Testimonials
		$testimonials_title = of_get_option('testimonials_title');
		$testimonials_carousel = of_get_option('testimonials_carousel');
		$testimonials_carousel_autoplay = of_get_option('testimonials_carousel_autoplay');
		$testimonials_orderby = of_get_option('testimonials_orderby');
		$testimonials_order = of_get_option('testimonials_order');
		$testimonials_posts = of_get_option('testimonials_posts');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[testimonials_posts columns="'.$sh_columns.'" title="'.$testimonials_title.'" limit="'.$testimonials_posts.'" orderby="'.$testimonials_orderby.'" order="'.$testimonials_order.'" carousel_mode="yes" slideshow="false"]');
		
		//Sponsors
		$sponsors_title = of_get_option('sponsors_title');
		$sponsors_carousel = of_get_option('sponsors_carousel');
		$sponsors_carousel_autoplay = of_get_option('sponsors_carousel_autoplay');
		$sponsors_orderby = of_get_option('sponsors_orderby');
		$sponsors_order = of_get_option('sponsors_order');
		$sponsors_posts = of_get_option('sponsors_posts');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[sponsors_posts columns="'.$sh_columns.'" title="'.$sponsors_title.'" limit="'.$sponsors_posts.'" orderby="'.$sponsors_orderby.'" order="'.$sponsors_order.' carousel_mode="yes" slideshow="false"]');

?>

</div><!-- /#homepage -->

<?php 
st_after_content();
?>

</div><!--Close container-->

<?php get_footer(); ?>