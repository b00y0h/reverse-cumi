<?php
/**
 * The Sidebar containing the secondary Page widget area.
 */
?>
<?php do_action('st_before_sidebar');?>

<?php // secondary widget area
	global $homepage_sidebar;
	if ( is_active_sidebar( $homepage_sidebar ) ) : ?>
	<ul>
		<?php dynamic_sidebar( $homepage_sidebar ); ?>
	</ul>
    
	<?php endif; // end secondary widget area ?>

<?php do_action('st_after_sidebar');?>

