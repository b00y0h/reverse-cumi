<?php
/**
 * The loop that displays the Flexslider slideshow posts.
 */
?>

<div class="flexslider-wrapper">
<div class="flexslider slideshow loading">

<div class="slideshow-top-shadow"></div>

<ul class="slides">

<?php
//Verify if category is set (All posts)	
if((of_get_option('slideshow_select_categories',''))){
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	query_posts( array( 
						 'post_type' => 'slideshow', 
						 'paged' => $paged, 
						 'posts_per_page' => of_get_option('slideshow_nr_posts'),
						 'ignore_sticky_posts' => 1,
						 'slideshow_category' => of_get_option('slideshow_select_categories')
						 )
				  );
} else {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	query_posts( array( 
						 'post_type' => 'slideshow', 
						 'paged' => $paged, 
						 'posts_per_page' => of_get_option('slideshow_nr_posts'),
						 'ignore_sticky_posts' => 1
						 )
				  );
}

if ( have_posts() ) : while ( have_posts() ) : the_post(); 

$slideshow_video_link = rwmb_meta( 'gg_slideshow_video_link' );
$slideshow_external_link = rwmb_meta( 'gg_slideshow_external_link' );
$slideshow_caption_title = rwmb_meta( 'gg_slideshow_caption_title' );
$slideshow_caption_subtitle = rwmb_meta( 'gg_slideshow_caption_subtitle' );
$slideshow_caption_title_color = rwmb_meta( 'gg_slideshow_caption_title_color' );
$slideshow_caption_subtitle_color = rwmb_meta( 'gg_slideshow_caption_subtitle_color' );
?>

<li>
	<?php
	if ($slideshow_external_link) { echo "<a href='$slideshow_external_link'>";}
		the_post_thumbnail( 'slideshow-thumbnail' );
	if ($slideshow_external_link) { echo "</a>";}
	
	if ($slideshow_caption_title || $slideshow_caption_subtitle) {
		echo "<div class='flex-caption'>";
		//subtitle
		if ($slideshow_caption_subtitle) {
			if ($slideshow_caption_subtitle_color !== '#ffffff')  
				echo '<h3 style="color:'.$slideshow_caption_subtitle_color.'">';
			else
				echo '<h3>';
			echo $slideshow_caption_subtitle.'</h3>';
		}
		//title
		if ($slideshow_caption_title) {
			if ($slideshow_caption_title_color !== '#ffffff')  
				echo '<h1 style="color:'.$slideshow_caption_title_color.'">';
			else
				echo '<h1>';
			echo $slideshow_caption_title.'</h1>';
		}
		echo "</div>";
	}
	
	?>
    
</li>

<?php endwhile; endif; ?>

</ul>
</div>
</div>

<?php wp_reset_query(); ?>