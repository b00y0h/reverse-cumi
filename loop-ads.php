<?php
/**
 * The loop that displays the ads posts.
 */
?>
<?php
//Get sponsors no. of posts
$ads_page_nr_posts = rwmb_meta('gg_ads_page_nr_posts');
$ads_style = rwmb_meta('gg_ads_page_style');
$layout_width = of_get_option('layout_width');

$ads_col_no = '4';
if ($ads_style == 'sidebar') {$ads_col_no = '3';} else { $ads_col_no = '4';}
if ($layout_width == 'layout_width_1140') $ads_col_no = $ads_col_no + 1;
?>
<div class="custom-wrapper master ads-wrapper">
<ul>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts( array( 
					 'post_type' => 'ads_pt', 
					 'paged' => $paged, 
					 'posts_per_page' => $ads_page_nr_posts,
					 'ignore_sticky_posts' => 1
					 )
			  );
$iterate = 0;
if ( have_posts() ) : while ( have_posts() ) : the_post(); $iterate++;?>

<?php
$ads_upload = rwmb_meta( 'gg_ads_upload', 'type=plupload_image&size=full'); 
$ads_link = rwmb_meta( 'gg_ads_link' ); 
?>

<li class="three <?php 
	if ( $iterate % $ads_col_no == 0 )
	echo ' last';
	elseif ( ( $iterate - 1 ) % $ads_col_no == 0 )
	echo ' first';
	?>">

<?php if ($ads_upload) { ?>

<div class="ads-holder">
<?php   foreach ( $ads_upload as $ad_upload ) {
        echo "<div>";
		if ($ads_link) { echo "<a href='{$ads_link}' title='{$ad_upload['title']}'>"; }
		echo "<img src='{$ad_upload['url']}' width='{$ad_upload['width']}' height='{$ad_upload['height']}' alt='{$ad_upload['alt']}' />";
		if ($ads_link) { echo "</a>"; }
        echo "</div>";
    }	
?>
</div>
<?php } ?>
    
    
</li>
<?php endwhile; endif; ?>
</ul>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".ads-holder").hover( function() {jQuery(this).stop(true).delay(200).animate({left: -1*jQuery(".ads-holder div:first-child").width()}, 800);}, function(){jQuery(this).stop(true).animate({left: "0px"}, 800);});
});
</script>

<?php if (function_exists("pagination")) {pagination($wp_query->max_num_pages);} ?>

</div>
<?php wp_reset_query(); ?>