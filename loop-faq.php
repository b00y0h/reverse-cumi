<?php
/**
 * The loop that displays the faq posts.
 */
?>
<?php
//Get faq no. of posts
$faq_page_nr_posts = rwmb_meta('gg_faq_page_nr_posts');
?>
<?php
query_posts( array( 
					 'post_type' => 'faq_pt', 
					 'posts_per_page' => -1,
					 'order' => 'ASC',
					 'ignore_sticky_posts' => 1
					 )
			  );
?>

<?php if (have_posts()) : ?>  
<div id="questions">  
    <ol>  
        <?php while (have_posts()) : the_post(); ?>  
        <li><a href="#answer<?php the_id() ?>"><?php the_title(); ?></a></li>  
        <?php endwhile; ?>  
    </ol>  
</div>  
<?php else : ?>  
    <h3>Not Found</h3>  
    <p>Sorry, No FAQs created yet.</p>  
<?php endif; ?> 

<?php rewind_posts(); ?> 

<?php if (have_posts()) : ?>
<div id="answers">
    <ul>
        <?php while (have_posts()) : the_post(); ?>
            <li id="answer<?php the_id(); ?>">
                <h4><?php the_title(); ?></h4>
                <?php the_content(); ?>
            </li>
        <?php endwhile; ?>
    </ul>
</div>
<?php endif; ?>

<?php wp_reset_query(); ?>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("div#questions ol a").click(function(){
		var selected = jQuery(this).attr('href');
		/*--Removing the Current class and the top button from previous current FAQs---*/
		jQuery('.top-button').remove();
		jQuery('.current-faq').removeClass();
		jQuery.scrollTo(selected, 400 ,function(){
			jQuery(selected).addClass('current-faq', 400, function(){
				jQuery(this).append('<a href="#" class="top-button">TOP</a>');
			});
		});
		return false;
	});
	
	jQuery('.top-button').live('click',function(){
		jQuery(this).remove();
		jQuery('.current-faq').removeClass('current-faq',400,function(){
			jQuery.scrollTo('0px', 800);
		});
		return false;
	})

});
</script>