<?php
/**
 * The template for displaying 404 pages (Not Found).
*/

get_header(); ?>

<div class="container">

<?php 
st_before_content($columns='');
if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();
?>
<h1 class="entry-title"><?php _e( '404 error', 'okthemes') ?></h1>

<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'okthemes' ); ?></p>
<?php get_search_form(); ?>

<script type="text/javascript">
    // focus on search field after it has loaded
    document.getElementById('s') && document.getElementById('s').focus();
</script>

<?php
st_after_content();
get_sidebar(); 
?>

</div><!--Close container-->

<?php get_footer(); ?>