<?php
/**
 * The loop that displays a single post.
 */
?>

<h1 class="entry-title"><?php the_title(); ?></h1>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>
                
                    <?php if ( of_get_option('blog_inner_image') ) { ?>
                        <div class="entry-meta">
                        <?php the_post_thumbnail('blog-single'); ?>
                        </div><!-- .entry-meta -->
                    <?php } ?>

					<div class="entry-content">
						<?php the_content(); ?>
                        <div class="clear"></div>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'okthemes' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->

					<div class="entry-utility">
                    	<?php cumico_posted_on(); ?>
                        <div class="clear"></div>
						<?php cumico_posted_in(); ?>
					</div><!-- .entry-utility -->
				</div><!-- #post-## -->
				
				<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>