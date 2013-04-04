<?php
/**
 * The loop that displays the Paralax slideshow posts.
 */
?>
<div class="iview-wrapper">
<div class="slideshow-top-shadow"></div>
<div id="iview">
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
$imageArray = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slideshow-thumbnail' );
$imageURL = $imageArray[0]; // image url
?>

<div data-iview:image="<?php echo $imageURL; ?>">
    <div class="iview-caption caption5" data-x="160" data-y="180" data-transition="wipeDown">
	<?php
	if ($slideshow_caption_title) {
		if ($slideshow_caption_title && $slideshow_external_link)
			echo '<a href='.$slideshow_external_link.'>'.$slideshow_caption_title.'</a>';
		else
			echo $slideshow_caption_title; 
	} 
	?>
    </div>
    <div class="iview-caption caption6" data-x="160" data-y="250" data-transition="wipeUp"><?php echo $slideshow_caption_subtitle; ?></div>
</div>


<?php endwhile; endif; ?>
</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#iview').iView({
		fx: '<?php echo of_get_option('iview_slide_effect'); ?>', // Specify sets like: 'left-curtain,fade,zigzag-top,strip-left-fade, random'
		animationSpeed: <?php echo of_get_option('iview_auto_animate_speed'); ?>, // Slide transition speed
		captionSpeed: <?php echo of_get_option('iview_caption_speed'); ?>, // Caption transition speed
		pauseTime: <?php echo of_get_option('iview_pause_time'); ?>,
		directionNav: false,
		controlNav: true,
		tooltipY: -15,
		pauseOnHover: <?php echo of_get_option('iview_pause_hover'); ?>
	});
});
</script>