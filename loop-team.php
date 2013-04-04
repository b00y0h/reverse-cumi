<?php
/**
 * The loop that displays the team posts.
 */
?>
<?php
//Get team no. of posts
$team_page_nr_posts = rwmb_meta('gg_team_page_nr_posts');
$team_style = rwmb_meta('gg_team_page_style');
$layout_width = of_get_option('layout_width');

$team_col_no = '4';
if ($team_style == 'sidebar') {$team_col_no = '3';} else { $team_col_no = '4';}
if ($layout_width == 'layout_width_1140') $team_col_no = $team_col_no + 1;
?>
<div class="custom-wrapper team-wrapper">
<ul>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts( array( 
					 'post_type' => 'team_pt', 
					 'paged' => $paged, 
					 'posts_per_page' => $team_page_nr_posts,
					 'ignore_sticky_posts' => 1
					 )
			  );
$iterate = 0;
if ( have_posts() ) : while ( have_posts() ) : the_post(); $iterate++;?>

<?php
$team_member_position = rwmb_meta('gg_team_member_position');
$team_member_desc = rwmb_meta('gg_team_member_desc');
$team_member_twitter = rwmb_meta('gg_team_member_twitter');
$team_member_facebook = rwmb_meta('gg_team_member_facebook');
$team_member_flickr = rwmb_meta('gg_team_member_flickr');
$team_member_linkedin = rwmb_meta('gg_team_member_linkedin');
$team_member_youtube = rwmb_meta('gg_team_member_youtube');
$team_member_website = rwmb_meta('gg_team_member_website');
?>

<li class="three <?php 
	if ( $iterate % $team_col_no == 0 )
	echo ' last';
	elseif ( ( $iterate - 1 ) % $team_col_no == 0 )
	echo ' first';
	?>">
	<?php the_post_thumbnail( "team-thumbnail" );?>
    
    <div class="entry-summary">
    
    	<h2 class="entry-title portfolio"><?php the_title(); ?></h2>
        
        <?php if ($team_member_position) { ?>
		<p class="member-position"><?php echo $team_member_position; ?></p>
        <?php } ?>
        
        <?php if ($team_member_desc) { ?>
        <p><?php echo $team_member_desc; ?></p>
        <?php } ?>
        
        <ul class="member-social">
        	<?php if ($team_member_twitter) { ?>
        	<li><a class="member-twitter" href="<?php echo $team_member_twitter; ?>">Twitter</a></li>
            <?php } ?>
            <?php if ($team_member_facebook) { ?>
        	<li><a class="member-facebook" href="<?php echo $team_member_facebook; ?>">Facebook</a></li>
            <?php } ?>
            <?php if ($team_member_flickr) { ?>
        	<li><a class="member-flickr" href="<?php echo $team_member_flickr; ?>">Flickr</a></li>
            <?php } ?>
            <?php if ($team_member_linkedin) { ?>
        	<li><a class="member-linkedin" href="<?php echo $team_member_linkedin; ?>">Linkedin</a></li>
            <?php } ?>
            <?php if ($team_member_youtube) { ?>
        	<li><a class="member-youtube" href="<?php echo $team_member_youtube; ?>">Youtube</a></li>
            <?php } ?>
            <?php if ($team_member_website) { ?>
        	<li><a class="member-website" href="<?php echo $team_member_website; ?>">Personal website</a></li>
            <?php } ?>
        </ul>
        
    </div><!-- .entry-summary -->
</li>
<?php endwhile; endif; ?>
</ul>

<?php if (function_exists("pagination")) {pagination($wp_query->max_num_pages);} ?>

</div>
<?php wp_reset_query(); ?>