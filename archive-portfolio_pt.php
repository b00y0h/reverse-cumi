<?php
/**
 * The template for displaying Archive Portfolio pages.
 */

get_header(); ?>

<div class="container">

<?php 
/* Queue the first post, that way we know
 * what date we're dealing with (if that is the case).
 *
 * We reset this later so we can run the loop
 * properly with a call to rewind_posts().
 */
if ( have_posts() )
	the_post();
	st_before_content($columns='twelve');
	if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();
?>

<h1 class="entry-title"><?php _e( 'Portfolio Archives', 'okthemes' ); ?></h1>

<?php
/* Since we called the_post() above, we need to
 * rewind the loop back to the beginning that way
 * we can run the loop properly, in full.
 */
rewind_posts();

?>
<div class="custom-wrapper">
<ul>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts( array( 
						 'post_type' => 'portfolio_pt', 
						 'paged' => $paged, 
						 'posts_per_page' => 12,
						 'ignore_sticky_posts' => 1
						 )
				  );

if ( have_posts() ) : while ( have_posts() ) : the_post(); $iterate++; ?>


<li class="three <?php 
	if ( $iterate % 4 == 0 )
	echo ' last';
	elseif ( ( $iterate - 1 ) % 4 == 0 )
	echo ' first';
	?>">
    <?php the_post_thumbnail( 'portfolio-thumbnail-4-col' );	?>
        <div class="entry-summary">
        	<h2 class="entry-title portfolio"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'okthemes' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <div class="short-description">
				<?php the_excerpt(); ?>
            </div>
        </div><!-- .entry-summary -->
        
        <div class="entry-lightbox">
        <?php 
		$portfolio_lightbox_images = rwmb_meta( 'gg_portfolio_lightbox_image', 'type=thickbox_image' );
		$portfolio_video_link = rwmb_meta( 'gg_portfolio_post_video_link' );
		$portfolio_external_link = rwmb_meta( 'gg_portfolio_post_external_link' );
		
		$videos = array( '.mp4', '.MP4', '.flv', '.FLV', '.swf', '.SWF', '.mov', '.MOV', 'youtube.com', 'vimeo.com' );
		$videos_found = false;
		
		foreach ($videos as $video_ext) {
		  if (strrpos($portfolio_video_link, $video_ext)) {
			$videos_found = true;
			break;
		  }
		}
		
		if (!empty($portfolio_lightbox_images)) { //check if array is empty
			  $i = 1; //display only the first image		
			  foreach ( $portfolio_lightbox_images as $portfolio_lightbox_image )
			  {
				  echo "<a class='image-lightbox' href='{$portfolio_lightbox_image['full_url']}' data-rel='prettyPhoto[mixed]'>View image in lightbox</a>";
				  if($i == 1) break; //display only the first image
			  }
		} 
		if ( $portfolio_video_link) {
			
			  if ($videos_found) {
				  echo "<a class='video-lightbox' href='{$portfolio_video_link}' data-rel='prettyPhoto[mixed]'>View video in lightbox</a>";
			  }
			  
		 } 
		 
		 if ( $portfolio_external_link) {
				  echo "<a class='external-link' href='{$portfolio_external_link}'>Go to link</a>";
		 } 
		 
		 ?>
         </div><!-- .entry-lightbox -->
</li>
<?php endwhile; endif; ?>
</ul>

<?php if (function_exists("pagination")) {pagination($wp_query->max_num_pages);} ?>

</div>
<?php st_after_content(); ?>

</div><!--Close container-->

<?php get_footer(); ?>