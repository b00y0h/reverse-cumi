<?php
/**
 * The loop that displays the Paralax slideshow posts.
 */
?>
<div id="slider" class="sl-slider-wrapper">
<div class="slideshow-top-shadow"></div>
<div class="sl-slider">
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

<?php 
$slitID = rand();
$imageArray = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slideshow-thumbnail' );
$imageURL = $imageArray[0]; // image url
?>
<style type="text/css">.bg-img-<?php echo $slitID; ?> {background-image: url(<?php echo $imageURL; ?>);}</style>
<div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
    <div class="sl-slide-inner">
        <div class="bg-img bg-img-<?php echo $slitID; ?>"></div>
        <?php if ($slideshow_caption_title || $slideshow_caption_subtitle) {
            //subtitle
            if ($slideshow_caption_subtitle) {
                if ($slideshow_caption_subtitle_color !== '#ffffff')  
                    echo '<h2 style="color:'.$slideshow_caption_subtitle_color.'">';
                else
                    echo '<h2>';
                echo $slideshow_caption_subtitle.'</h2>';
            }
            //title
            if ($slideshow_caption_title) {
                if ($slideshow_caption_title_color !== '#ffffff')  
                    echo '<blockquote><p style="color:'.$slideshow_caption_title_color.'">';
                else
                    echo '<blockquote><p>';
                echo $slideshow_caption_title.'</p></blockquote>';
            }
        } ?>
    </div>
</div>

<?php endwhile; endif; ?>
</div>

<?php rewind_posts(); ?>

<nav id="nav-dots" class="nav-dots">
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
				speed : <?php echo of_get_option('slit_transition_speed'); ?>,
				optOpacity : false,
				autoplay : <?php echo of_get_option('slit_auto_animate'); ?>,
				interval : <?php echo of_get_option('slit_auto_animate_speed'); ?>,
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
});
</script>