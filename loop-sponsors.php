<?php
/**
 * The loop that displays the sponsors posts.
 */
?>
<?php
//Get sponsors no. of posts
$sponsors_page_nr_posts = rwmb_meta('gg_sponsors_page_nr_posts');
$sponsors_style = rwmb_meta('gg_sponsors_page_style');
$layout_width = of_get_option('layout_width');

$sponsors_col_no = '4';
if ($sponsors_style == 'sidebar') {$sponsors_col_no = '3';} else { $sponsors_col_no = '4';}
if ($layout_width == 'layout_width_1140') $sponsors_col_no = $sponsors_col_no + 1;
?>
<div class="custom-wrapper sponsors-wrapper">
<ul>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts( array( 
					 'post_type' => 'sponsors_pt', 
					 'paged' => $paged, 
					 'posts_per_page' => $sponsors_page_nr_posts,
					 'ignore_sticky_posts' => 1
					 )
			  );
$iterate = 0;
if ( have_posts() ) : while ( have_posts() ) : the_post(); $iterate++; ?>

<?php
//Get sponsors no. of posts
$sponsors_external_link = rwmb_meta('gg_sponsors_external_link');
$sponsors_hide_title = rwmb_meta('gg_sponsors_hide_title');

?>
<li class="three <?php 
	if ( $iterate % $sponsors_col_no == 0 )
	echo ' last';
	elseif ( ( $iterate - 1 ) % $sponsors_col_no == 0 )
	echo ' first';
	?>">
	<?php if ($sponsors_external_link) { ?>
        <a href="<?php echo $sponsors_external_link; ?>">
        <?php the_post_thumbnail( "sponsors-thumbnail" );?>
        </a>
    <?php  } else { 
		the_post_thumbnail( "sponsors-thumbnail" ); 
	}?>
    
    <?php if (!$sponsors_hide_title) { ?>
    <div class="entry-summary">
        <h2 class="entry-title portfolio">
        <?php if ($sponsors_external_link) { ?>
        <a href="<?php echo $sponsors_external_link; ?>"><?php the_title(); ?></a>
         <?php  } else { the_title(); }?>
        </h2>
    </div><!-- .entry-summary -->
    <?php } ?>
</li>
<?php endwhile; endif; ?>
</ul>

<?php if (function_exists("pagination")) {pagination($wp_query->max_num_pages);} ?>

</div>
<?php wp_reset_query(); ?>