<?php
/**
 * The loop that displays the testimonials posts.
 */
?>
<?php
//Get testimonials no. of posts
$testimonials_page_nr_posts = rwmb_meta('gg_testimonials_page_nr_posts');
$testimonials_style = rwmb_meta('gg_testimonials_page_style');
$layout_width = of_get_option('layout_width');

$testimonials_col_no = '4';
if ($testimonials_style == 'sidebar') {$testimonials_col_no = '3';} else { $testimonials_col_no = '4';}
if ($layout_width == 'layout_width_1140') $testimonials_col_no = $testimonials_col_no + 1;
?>
<div class="custom-wrapper testimonials-wrapper">
<ul>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts( array( 
					 'post_type' => 'testimonials_pt', 
					 'paged' => $paged, 
					 'posts_per_page' => $testimonials_page_nr_posts,
					 'ignore_sticky_posts' => 1
					 )
			  );
$iterate = 0;
if ( have_posts() ) : while ( have_posts() ) : the_post(); $iterate++;?>

<?php
//Get testimonials no. of posts
$testimonials_author_name = rwmb_meta('gg_testimonials_author_name');
$testimonials_author_website = rwmb_meta('gg_testimonials_author_website');
$testimonials_content = rwmb_meta('gg_testimonials_content');
?>

<li class="three <?php 
	if ( $iterate % $testimonials_col_no == 0 )
	echo ' last';
	elseif ( ( $iterate - 1 ) % $testimonials_col_no == 0 )
	echo ' first';
	?>">
	<blockquote><?php echo $testimonials_content; ?></blockquote>
    
    <div class="entry-summary">
    	<?php the_post_thumbnail( "testimonials-thumbnail", array('class' => 'tesimonial-author-img') );?>
        <?php if ($testimonials_author_name) { ?>
		<p class="author-name"><?php echo $testimonials_author_name; ?></p>
        <?php } ?>
        <?php if ($testimonials_author_name) { ?>
        <a class="author-website" href="<?php echo $testimonials_author_website; ?>">Website</a>
        <?php } ?>
    </div><!-- .entry-summary -->
</li>
<?php endwhile; endif; ?>
</ul>

<?php if (function_exists("pagination")) {pagination($wp_query->max_num_pages);} ?>

</div>
<?php wp_reset_query(); ?>