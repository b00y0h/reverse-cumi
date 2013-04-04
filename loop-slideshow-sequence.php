<?php
/**
 * The loop that displays the Paralax slideshow posts.
 */
?>

<div id="sequence-theme">
<div class="slideshow-top-shadow"></div>
<div id="sequence">
<img class="prev" src="<?php echo get_stylesheet_directory_uri();?>/images/bt-prev.png" alt="Previous Frame" />
<img class="next" src="<?php echo get_stylesheet_directory_uri();?>/images/bt-next.png" alt="Next Frame" />
<ul>

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
?>

<li>
	<?php
	
	if ($slideshow_caption_title) {
		if ($slideshow_caption_title && $slideshow_external_link)
			echo '<h2 class="title animate-in"><a href='.$slideshow_external_link.'>'.$slideshow_caption_title.'</a></h2>';
		else
			echo '<h2 class="title animate-in">'.$slideshow_caption_title.'</h2>';
	}
	if ($slideshow_caption_subtitle) echo '<h3 class="subtitle animate-in">'.$slideshow_caption_subtitle.'</h3>';
	?>
    
	<?php 
	
		the_post_thumbnail( 'sequence-thumbnail' , array('class' => 'model x animate-in')); 
	
	?>
</li>

<?php endwhile; endif; ?>

</ul>
</div>

<ul class="nav">
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
	  animateStartingFrameIn: <?php echo of_get_option('sequence_starting_frame'); ?>,
	  autoPlay: <?php echo of_get_option('sequence_auto_animate'); ?>,
	  autoPlayDelay: <?php echo of_get_option('sequence_auto_animate_speed'); ?>,
	  preloader: true,
	  pauseOnHover: <?php echo of_get_option('sequence_pause_hover'); ?>,
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