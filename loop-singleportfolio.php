<?php
/**
 * The loop that displays a single post.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<?php $portfolio_slideshow_images = rwmb_meta( 'gg_portfolio_slideshow_upload', 'type=plupload_image&size=full'); 
if ($portfolio_slideshow_images) { ?>
<div class="flexslider-wrapper">
<div class="flexslider slideshow loading">

<div class="slideshow-top-shadow"></div>

<ul class="slides">

<?php foreach ( $portfolio_slideshow_images as $portfolio_slideshow_image ) {
	echo "<li id='{$portfolio_slideshow_image['name']}'><img src='{$portfolio_slideshow_image['full_url']}' width='{$portfolio_slideshow_image['width']}' height='{$portfolio_slideshow_image['height']}' alt='{$portfolio_slideshow_image['alt']}' />";
	if ($portfolio_slideshow_image['caption']) {echo "<div class='caption'><h1>{$portfolio_slideshow_image['caption']}</h1></div>";}
	echo "</li>";
} ?>
</ul>
</div>
</div>
<script type="text/javascript">
   jQuery(window).load(function() {
   	jQuery('.flexslider.slideshow').flexslider({
   		directionNav: true,
		controlNav: false,
		animation: "fade",
		start: function(slider) {slider.removeClass('loading');}
   	});
   });
</script>
<?php } ?>

<div class="clear"></div>

<div class="container">

<div id="content" class="twelve columns">

<div id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>

    <div class="entry-content">
    	
		<?php if ( of_get_option('portfolio_project_details') ) echo '<div class="nine columns alpha">';
		else echo '<div class="twelve">'; ?>
        
        <?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
        
        <h1 class="entry-title"><?php the_title(); ?></h1>
        
        <?php the_content(); ?>
        
        <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'okthemes' ), 'after' => '</div>' ) ); ?>
        
        </div>
        
        <?php if ( of_get_option('portfolio_project_details') ) { ?>
        <div class="three columns omega">
            <?php 
			$portfolio_project_date = rwmb_meta( 'gg_portfolio_project_date' );
			$portfolio_project_url = rwmb_meta( 'gg_portfolio_project_url' ); 
			$portfolio_project_details = rwmb_meta( 'gg_portfolio_project_details' );
			$portfolio_project_categories = get_the_term_list( $post->ID, 'portfolio_category', '', ' , ');
            ?>
            <ul class="portfolio-meta">
            	<li class="project-title"><h4><?php _e( ' '.of_get_option('portfolio_project_details_title').' ', 'okthemes' ); ?></h4></li>
                <?php if ($portfolio_project_date) { ?><li class="project-date"><?php echo $portfolio_project_date; ?></li><?php } ?>
                <?php if ($portfolio_project_categories) { ?><li class="project-category"><?php echo $portfolio_project_categories;?></li><?php } ?>
                <?php if ($portfolio_project_url) { ?><li class="project-url"><a href="<?php echo $portfolio_project_url; ?>"><?php echo $portfolio_project_url; ?></a></li><?php } ?>
                <?php if ($portfolio_project_details) { ?><li class="project-details"><?php echo $portfolio_project_details; ?></li><?php } ?>
                <li class="project-details-nav">
                        <div class="psingle-previous"><?php previous_post_link( '%link', '%title' ); ?></div>
                        <div class="psingle-next"><?php next_post_link( '%link', '%title' ); ?></div>
                </li>
            </ul>
        </div>
        <?php } ?>
        
    </div><!-- .entry-content -->
</div><!-- #post-## -->

<?php endwhile; // end of the loop. ?>

<div class="clear"></div>

<?php if ( of_get_option('portfolio_related_posts') ) {
$layout_width = of_get_option('layout_width');
$port_col_no = 4;
if ($layout_width == 'layout_width_1140') $port_col_no = $port_col_no + 1;

if ( 'portfolio_pt' == get_post_type() ) {
$taxs = wp_get_post_terms( $post->ID, 'portfolio_tag' );
if ( $taxs ) {
$tax_ids = array();
foreach( $taxs as $individual_tax ) $tax_ids[] = $individual_tax->term_id;

$args = array(
	'tax_query' => array(
	array(
		'taxonomy'  => 'portfolio_tag',
		'terms'     => $tax_ids,
		'operator'  => 'IN'
		)
	),
	'post__not_in'          => array( $post->ID ),
	'posts_per_page'        => 0,
	'ignore_sticky_posts'   => 1
);

$my_query = new wp_query( $args );

if( $my_query->have_posts() ) {

echo '<div class="portfolio-related-posts"><h3>' . __( ' '.of_get_option('portfolio_related_posts_title').' ', 'okthemes' ) . '</h3><div class="custom-wrapper"><ul>';
$iterate = 0;
while ( $my_query->have_posts() ) : $my_query->the_post(); $iterate++;?>
                 
<li class="three
	<?php 
	if ( $iterate % $port_col_no == 0 )
	echo ' last';
	elseif ( ( $iterate - 1 ) % $port_col_no == 0 )
	echo ' first';
	?>">
    
    <?php the_post_thumbnail('portfolio-thumbnail-4-col');	?>
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
 
            <?php endwhile;
 
            echo '</ul></div></div>';
 
        }
         
        wp_reset_query();
         
    }
}
}
?>