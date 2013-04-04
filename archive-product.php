<?php
/**
 * Product Archive template
 */

get_header(); ?>
<?php
$shop_layout = of_get_option('shop_layout');
$shop_sidebar = of_get_option('shop_sidebar_select');
$layout_width = of_get_option('layout_width');

if (!is_search()) $shop_page = get_post( woocommerce_get_page_id('shop') );

if (!is_search() && has_post_thumbnail($shop_page->ID)) {
	echo "<div class=\"page-headline-image-wrapper\"><div class=\"page-headline-image\"><div class=\"slideshow-top-shadow\"></div>";
	echo get_the_post_thumbnail($shop_page->ID, 'page-thumbnail'); 
	echo "</div></div>";
}
?>

<div class="container">

<?php 
if (!is_search()) :
	$shop_page_title = apply_filters('the_title', (get_option('woocommerce_shop_page_title')) ? get_option('woocommerce_shop_page_title') : $shop_page->post_title);
	$shop_page_content = $shop_page->post_content;
else :
	$shop_page_title = __('Search Results:', 'okthemes') . ' &ldquo;' . get_search_query() . '&rdquo;'; 
	if (get_query_var('paged')) $shop_page_title .= ' &mdash; ' . __('Page', 'okthemes') . ' ' . get_query_var('paged');
	$shop_page_content = '';
endif;

if ($shop_layout == 'with_sidebar') st_before_content($columns='');
else st_before_content($columns='twelve');

do_action('woocommerce_before_main_content'); ?>
  
  <h1 class="entry-title"><?php echo $shop_page_title ?></h1>
  
  <?php echo apply_filters('the_content', $shop_page_content); ?>

  <?php if ( have_posts() ) : ?>
  	  
      <?php if (of_get_option('shop_grid_list_view')) { ?>
      <div class="grid-switch">
         <a href="#" id="grid" title="<?php _e('Grid view', 'okthemes'); ?>">&#8862; </a>
         <a href="#" id="list" title="<?php _e('List view', 'okthemes'); ?>">&#8863; </a>
      </div>
      <?php } ?>
      
	  <?php do_action('woocommerce_before_shop_loop'); ?>
  
	  <?php
	  global $woocommerce_loop;
	  
	  if (!isset($woocommerce_loop['columns']) || !$woocommerce_loop['columns']) 
		  $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 3);
		  
	  if ( ($shop_layout == 'without_sidebar') || (($layout_width == 'layout_width_1140') && ($shop_layout == 'with_sidebar')) )
	      $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 4);
		  
	  if (($layout_width == 'layout_width_1140') && ($shop_layout == 'without_sidebar'))
	      $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 5);	  
		    	  
	  ?>
	  
	  <ul class="products woo-specific shop-page products-col-<?php echo $woocommerce_loop['columns'] ?>">
	  
		  <?php woocommerce_product_subcategories(); ?>
  
		  <?php while ( have_posts() ) : the_post(); ?>
  
			  <?php woocommerce_get_template_part( 'content', 'product' ); ?>
  
		  <?php endwhile; // end of the loop. ?>
		  
	  </ul>

	  <?php do_action('woocommerce_after_shop_loop'); ?>
  
  <?php else : ?>
  
	  <?php if ( ! woocommerce_product_subcategories( array( 'before' => '<ul class="products">', 'after' => '</ul>' ) ) ) : ?>
			  
		  <?php echo '<p class="info">'.__('No products found which match your selection.', 'okthemes').'</p>'; ?>
			  
	  <?php endif; ?>
  
  <?php endif; ?>
  
<?php 
do_action('woocommerce_pagination');
do_action('woocommerce_after_main_content');
st_after_content();
if ($shop_layout == 'with_sidebar') get_sidebar("shop");
?>

</div><!--Close container-->

<?php get_footer(); ?>