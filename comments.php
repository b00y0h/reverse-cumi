<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','okthemes');?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->
<div id="comments">
<?php if ( have_comments() ) : ?>
	<div class="comments-holder">
	<?php if ( ! empty($comments_by_type['comment']) ) : ?>
    <div class="clear"></div>
    <h3><?php printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'okthemes' ),
			number_format_i18n( get_comments_number() ), '&quot;'.get_the_title().'&quot;' );?></h3>
	
    
	<ul class="commentlist">
	<?php wp_list_comments("type=comment&callback=st_comments"); ?>
	</ul>
    <?php endif; ?>
    
    <?php
	function list_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	?>
	<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
	<?php } ?>
    <?php if ( ! empty($comments_by_type['pings']) ) : ?>
    <div class="clear"></div>
    <h3><?php _e('Trackbacks/Pingbacks','okthemes');?></h3>

	<ol class="pinglist">
		<?php wp_list_comments('type=pings&callback=list_pings'); ?>
    </ol>
    </li>
	<?php endif; ?>
	
    <div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
    
    </div>
	
 <?php else : // this is displayed if there are no comments so far ?>

	
<?php endif; ?>

</div>
<?php if ( comments_open() ) : ?>

<?php 
$args = array(
	'title_reply'          => ' '.__( 'Leave a Reply' ).' ',
	'title_reply_to'       => ' '.__( 'Leave a Reply to %s' ).' ',
	'comment_notes_after'  => ''
);
comment_form($args); ?>

<?php endif; // if you delete this the sky will fall on your head ?>
