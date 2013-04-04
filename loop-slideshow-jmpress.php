<?php
/**
 * The loop that displays the Paralax slideshow posts.
 */
?>
<div id="jms-slideshow" class="jms-slideshow">
<div class="slideshow-top-shadow"></div>
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

$k=0;
if ( have_posts() ) : while ( have_posts() ) : the_post(); 

$slideshow_video_link = rwmb_meta( 'gg_slideshow_video_link' );
$slideshow_external_link = rwmb_meta( 'gg_slideshow_external_link' );
$slideshow_external_link_name = rwmb_meta( 'gg_slideshow_external_link_name' );
$slideshow_caption_title = rwmb_meta( 'gg_slideshow_caption_title' );
$slideshow_caption_subtitle = rwmb_meta( 'gg_slideshow_caption_subtitle' );
$slideshow_caption_title_color = rwmb_meta( 'gg_slideshow_caption_title_color' );
$slideshow_caption_subtitle_color = rwmb_meta( 'gg_slideshow_caption_subtitle_color' );
$slideshow_background_color = rwmb_meta( 'gg_slideshow_background_color' );

$slitjm = rand();
?>

<?php if ($slideshow_background_color !== '#eeeeee') { ?>
	<style type="text/css">.background-color<?php echo $slitjm; ?> {background: <?php echo $slideshow_background_color; ?>;}</style>
<?php } ?>

<div class="step" data-color="background-color<?php if ($slideshow_background_color !== '#eeeeee') { echo $slitjm; } ?>" <?php if($k%2 == 0) echo 'data-y="500" data-scale="0.4" data-rotate-x="30"'; ?>>

	<?php
	
	if ($slideshow_caption_title || $slideshow_caption_subtitle) {
		echo "<div class='jms-content'>";
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
				echo '<p style="color:'.$slideshow_caption_title_color.'">';
			else
				echo '<p>';
			echo $slideshow_caption_title.'</p>';
		}
		//link
		if ($slideshow_external_link) {
			echo '<a class="jms-link" href="'.$slideshow_external_link.'"> '.$slideshow_external_link_name.' </a>';
		}
		echo "</div>";
	}
	
	if ($slideshow_external_link) { echo "<a href='$slideshow_external_link'>";}
		the_post_thumbnail( 'jmpress-thumbnail' );
	if ($slideshow_external_link) { echo "</a>";}
	
	?>
</div>


<?php $k++; endwhile; endif; ?>
</div>

<script type="text/javascript">
	jQuery(function() {
		
		var jmpressOpts	= {
			animation		: { transitionDuration : '0.8s' }
		};
		
		jQuery( '#jms-slideshow' ).jmslideshow( jQuery.extend( true, { jmpressOpts : jmpressOpts }, {
			autoplay	: <?php echo of_get_option('jmpress_auto_animate'); ?>,
			interval    : <?php echo of_get_option('jmpress_auto_animate_speed'); ?>,
			bgColorSpeed: '0.8s',
			arrows		: <?php echo of_get_option('jmpress_arrows_animation'); ?>,
			dots        : <?php echo of_get_option('jmpress_bullet_animation'); ?>
		}));
		
	});
</script>