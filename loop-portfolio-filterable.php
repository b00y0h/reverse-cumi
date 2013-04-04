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
			$portfolio_col_class="twelve";
			$portfolio_img_dim = "portfolio-thumbnail-1-col";
			$portfolio_col_no = "1";
		} elseif ($page_columns == 'two-col') {
			$portfolio_col_class="six";
			$portfolio_img_dim = "portfolio-thumbnail-2-col";
			$portfolio_col_no = "2";
		} elseif ($page_columns == 'three-col') {
			$portfolio_col_class="four";
			$portfolio_img_dim = "portfolio-thumbnail-3-col";
			$portfolio_col_no = "3";
		} elseif ($page_columns == 'four-col') {
			$portfolio_col_class="three";
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
?>

<div class="masonry-navigation">
<ul class="filter option-set" data-filter-group="categories">
	<li><a data-filter-value="" href="#" class="selected">Show all</a></li>
    <?php
    $categories=  get_categories('taxonomy=portfolio_category&title_li='); 
    foreach ($categories as $category){ ?>
    <li><a href="#" data-filter-value=".<?php echo $category->slug;?>" title="Filter by <?php echo $category->name;?>"><?php echo $category->name;?></a></li>
    <?php }?> 
</ul>
</div>

<div class="clear"></div>

<div class="custom-wrapper filterable">

<ul>
<?php
query_posts( array( 
					 'post_type' => 'portfolio_pt', 
					 'posts_per_page' => $portfolio_page_nr_posts,
					 'ignore_sticky_posts' => 1
					 )
			  );
$iterate = 0;			  
if ( have_posts() ) : while ( have_posts() ) : the_post(); $iterate++;?>

<li class="element <?php 
	echo $portfolio_col_class; 
	$terms = wp_get_post_terms($post->ID,'portfolio_category'); foreach ($terms as $term) {  echo ' ' .$term->slug. ' '; } 
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

<?php endwhile; ?>
<?php endif; ?>

</ul>
</div>

<script type="text/javascript">
/* Porfolio isotope init
================================================== */
jQuery(window).load(function(){

var $container = jQuery('.custom-wrapper.filterable ul'),
	filters = {};

$container.imagesLoaded( function(){	
	$container.isotope({
	  itemSelector : '.element',
	  transformsEnabled: true
	});
});

// filter buttons
jQuery('.filter a').click(function(){
  var $this = jQuery(this);
  // don't proceed if already selected
  if ( $this.hasClass('selected') ) {
	return;
  }
  
  var $optionSet = $this.parents('.option-set');
  // change selected class
  $optionSet.find('.selected').removeClass('selected');
  $this.addClass('selected');
  
  // store filter value in object
  // i.e. filters.color = 'red'
  var group = $optionSet.attr('data-filter-group');
  filters[ group ] = $this.attr('data-filter-value');
  // convert object into array
  var isoFilters = [];
  for ( var prop in filters ) {
	isoFilters.push( filters[ prop ] )
  }
  var selector = isoFilters.join('');
  $container.isotope({ filter: selector });

  return false;
});

});
</script>

<?php wp_reset_query(); ?>