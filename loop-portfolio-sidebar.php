<?php
/**
 * The loop that displays the portfolio posts.
 */
?>
<?php
	//Get page columns
	$page_columns = rwmb_meta('gg_portfolio_page_columns');
	$layout_width = of_get_option('layout_width');
	if ($page_columns) {
		if ($page_columns == 'one-col') {
			$portfolio_col_class="nine";
			$portfolio_img_dim = "portfolio-thumbnail-1-col";
			$portfolio_col_no = "1";
		} elseif ($page_columns == 'two-col') {
			$portfolio_col_class="four";
			$portfolio_img_dim = "portfolio-thumbnail-2-col";
			$portfolio_col_no = "2";
		} elseif ($page_columns == 'three-col') {
			$portfolio_col_class="three";
			$portfolio_img_dim = "portfolio-thumbnail-3-col";
			$portfolio_col_no = "3";
		} elseif ($page_columns == 'four-col') {
			$portfolio_col_class="two";
			$portfolio_img_dim = "portfolio-thumbnail-4-col";
			$portfolio_col_no = "4";		
		}
	if ($layout_width == 'layout_width_1140') $portfolio_col_no = $portfolio_col_no + 1;	
	} else {
		$portfolio_col_class="four";
		$portfolio_img_dim = "portfolio-thumbnail-3-col";
		$portfolio_col_no = "3";
		if ($layout_width == 'layout_width_1140') $portfolio_col_no = $portfolio_col_no + 1;
	}
	//Get hover effect
	$hover_effect = rwmb_meta('gg_portfolio_hover_effect');
	if (empty($hover_effect)) { $hover_effect = "first";}
	//Get portfolio no. of posts
	$portfolio_page_nr_posts = get_post_meta( get_the_ID(), 'gg_portfolio_page_nr_posts', true );
	//Get portfolio category
	$terms = rwmb_meta( 'gg_portfolio_page_categories', 'type=taxonomy&taxonomy=portfolio_category' );
	foreach ( $terms as $term ){$portfolio_category = $term->name;}
?>
<div class="custom-wrapper master-sidebar">
<ul>
<?php
//Verify if category is set (All posts)	
if(isset($portfolio_category)){
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts( array( 
						 'post_type' => 'portfolio_pt', 
						 'paged' => $paged, 
						 'posts_per_page' => $portfolio_page_nr_posts,
						 'ignore_sticky_posts' => 1,
						 'portfolio_category' => $portfolio_category
						 )
				  );
} else {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	query_posts( array( 
						 'post_type' => 'portfolio_pt', 
						 'paged' => $paged, 
						 'posts_per_page' => $portfolio_page_nr_posts,
						 'ignore_sticky_posts' => 1
						 )
				  );
}
$iterate = 0;
if ( have_posts() ) : while ( have_posts() ) : the_post(); $iterate++;?>

<li class="<?php 
	echo $portfolio_col_class;
	if ( $iterate % $portfolio_col_no == 0 )
	echo ' last';
	elseif ( ( $iterate - 1 ) % $portfolio_col_no == 0 )
	echo ' first';
	?>">
    <?php the_post_thumbnail( $portfolio_img_dim );	?>
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
				  $portfolio_video_link = htmlspecialchars($portfolio_video_link, ENT_QUOTES);
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

<?php wp_reset_query(); ?>