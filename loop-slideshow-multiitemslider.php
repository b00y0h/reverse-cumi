<?php
/**
 * The loop that displays the Product Category Slider
 */
?>

<div class="clear"></div>

<div id="mi-slider" class="mi-slider">
<?php 
$product_cats = of_get_option('product_cats', 'none' ); 
?>

<?php
if ( is_array($product_cats) ) {
	$product_cats_output = array();
	foreach ($product_cats as $key => $value) {
		if ($value =='1') {$product_cats_output[] = $key;}
	}
}

$args = array(
		'orderby'       => 'include', 
		'order'         => 'ASC',
		'hide_empty'    => false, 
		'include'       => implode(', ', $product_cats_output),
		'fields'        => 'all', 
		'pad_counts'    => false, 
	); 
$product_cat_terms = get_terms( 'product_cat', $args );
foreach ($product_cat_terms as $product_cat_term) {
echo "<ul>";
$args = array(
        'post_type' => 'product',
        'posts_per_page' => 4,
        'tax_query' => array(
                array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => $product_cat_term->slug
                )
        )
);
$new = new WP_Query($args);
while ($new->have_posts()) {
$new->the_post();
echo '<li><a href="'. get_permalink() . '">';
if ( has_post_thumbnail() ) { the_post_thumbnail( 'slideshow-thumbnail' ); }
echo '<h4>'.get_the_title().'</h4></a></li>';
}
echo "</ul>";
} 
?>



<nav>
<?php
foreach ($product_cat_terms as $product_cat_term) {
	echo "<a href='#'>".$product_cat_term->name."</a>";
}
?>
</nav>
</div>

<script type="text/javascript">
  jQuery(function() {
	  jQuery( '#mi-slider' ).catslider();
  });
</script>
<?php wp_reset_query(); ?>