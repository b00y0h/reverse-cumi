<?php
/**
 * Product Taxonomy Archive template
 */

get_header(); ?>

<div class="container">

<?php
$catalog_layout = of_get_option('catalog_layout');
$catalog_sidebar = of_get_option('catalog_sidebar_select');
$layout_width = of_get_option('layout_width');

if ($catalog_layout == 'with_sidebar') st_before_content($columns=''); else st_before_content($columns='twelve');

do_action('woocommerce_before_main_content');

$term = $wp_query->get_queried_object(); $pagetitle = $term->name; 
?> 

<h1 class="entry-title"><?php echo $pagetitle ?></h1>

<?php
if (of_get_option('catalog_category_img')) {
	// verify that this is a product category page
	if (is_product_category()){
		global $wp_query;
		// get the query object
		$cat = $wp_query->get_queried_object();
		// get the thumbnail id user the term_id
		$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); 
		// get the image URL
		$image = wp_get_attachment_url( $thumbnail_id ); 
		// print the IMG HTML
		if ($image)
		echo '<img class="category-img" src="'.$image.'" alt="" width="180" height="180" />';
	}
}
if (of_get_option('catalog_category_desc')) {
	$cat_description = term_description( '', get_query_var( 'taxonomy' ) );
	echo $cat_description;
}
?>
		
<?php if ( have_posts() ) : ?>
	
    <?php if (of_get_option('catalog_grid_list_view')) { ?>
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
		  
	  if ( ($catalog_layout == 'without_sidebar') || (($layout_width == 'layout_width_1140') && ($catalog_layout == 'with_sidebar')) )
	      $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 4);
		  
	  if (($layout_width == 'layout_width_1140') && ($catalog_layout == 'without_sidebar'))
	      $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 5);  	  
	  ?>
	
	<ul class="products woo-specific catalog-page products-col-<?php echo $woocommerce_loop['columns'] ?>">
	
		<?php woocommerce_product_subcategories(); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php woocommerce_get_template_part( 'content', 'product' );  ?>

		<?php endwhile; // end of the loop. ?>
		
	</ul>

	<?php do_action('woocommerce_after_shop_loop'); ?>

<?php else : ?>

	<?php if ( ! woocommerce_product_subcategories( array( 'before' => '<ul class="products">', 'after' => '</ul>' ) ) ) : ?>
			
		<?php echo '<p class="info">'.__('No products found which match your selection.', 'okthemes').'</p>'; ?>
			
	<?php endif; ?>

<?php endif; ?>

<?php do_action('woocommerce_pagination'); ?>

<?php
do_action('woocommerce_after_main_content');
st_after_content();
if ($catalog_layout == 'with_sidebar') get_sidebar("catalog");
?>

</div><!--Close container-->

<?php get_footer(); ?>