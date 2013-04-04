<?php
/**
 * The loop that displays posts for blog page
 */
?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><?php _e( 'Not Found', 'okthemes' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'okthemes' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif; ?>

<?php
$blog_page_nr_posts = get_post_meta( get_the_ID(), 'gg_blog_page_nr_posts', true );
global $more;
$temp = $wp_query;
$limit = $blog_page_nr_posts; //number of posts to display
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=' . $limit . '&paged=' . $paged);

while ($wp_query->have_posts()) : $wp_query->the_post();$more = 0; ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        	
            <div class="entry-meta">
            <?php the_post_thumbnail('blog-single'); ?>
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'okthemes' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <div class="entry-utility half-bottom">
            	<?php cumico_posted_on(); ?>
            </div>
			</div><!-- .entry-meta -->

	<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
	<?php else : ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&#187;</span>', 'okthemes' ) ); ?>
				<div class="clear"></div>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'okthemes' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
	<?php endif; ?>

			<div class="entry-utility remove-bottom">
				<?php cumico_posted_in(); ?>
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->

<?php endwhile; // End the loop. Whew. ?>

<?php if (function_exists("pagination")) {pagination($wp_query->max_num_pages);} ?>

<?php $wp_query = null; $wp_query = $temp;?>