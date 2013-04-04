<?php
/**
 * The template for displaying Archive pages.
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
	st_before_content($columns='');
	if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();
?>

<h1 class="entry-title">
	<?php if ( is_day() ) : ?>
        <?php printf( __( 'Daily Archives: %s', 'okthemes' ), get_the_date() ); ?>
    <?php elseif ( is_month() ) : ?>
        <?php printf( __( 'Monthly Archives: %s', 'okthemes' ), get_the_date('F Y') ); ?>
    <?php elseif ( is_year() ) : ?>
        <?php printf( __( 'Yearly Archives: %s', 'okthemes' ), get_the_date('Y') ); ?>
    <?php else : ?>
        <?php _e( 'Blog Archives', 'okthemes' ); ?>
    <?php endif; ?>
</h1>

<?php
/* Since we called the_post() above, we need to
 * rewind the loop back to the beginning that way
 * we can run the loop properly, in full.
 */
rewind_posts();

/* Run the loop for the archives page to output the posts.
 * If you want to overload this in a child theme then include a file
 * called loop-archives.php and that will be used instead.
 */
get_template_part( 'loop', 'archive' );
st_after_content();
get_sidebar();
?>

</div><!--Close container-->

<?php get_footer(); ?>