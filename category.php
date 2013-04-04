<?php
/**
 * The template for displaying Category Archive pages.
 */

get_header(); ?>

<div class="container">

<?php
st_before_content($columns='');
if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();

?>
<h1 class="entry-title"><?php
	printf( __( 'Category Archives: %s', 'okthemes' ), single_cat_title( '', false ) );
?></h1>
<?php
	$category_description = category_description();
	if ( ! empty( $category_description ) )
		echo '' . $category_description . '';

/* Run the loop for the category page to output the posts.
 * If you want to overload this in a child theme then include a file
 * called loop-category.php and that will be used instead.
 */
get_template_part( 'loop', 'category' );
st_after_content();
get_sidebar();
?>

</div><!--Close container-->

<?php get_footer(); ?>
