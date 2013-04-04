<?php
@define( 'PARENT_DIR', get_template_directory() );
@define( 'CHILD_DIR', get_stylesheet_directory() );

@define( 'PARENT_URL', get_template_directory_uri() );
@define( 'CHILD_URL', get_stylesheet_directory_uri() );

// Re-define meta box path and URL
define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/admin/meta-box/' ) );
define( 'RWMB_DIR', trailingslashit( get_template_directory(). '/admin/meta-box/' ) );

// Verify plugins
require_once PARENT_DIR . '/lib/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
function my_theme_register_required_plugins() {
	$plugins = array(
		array(
			'name' 		=> 'WooCommerce',
			'slug' 		=> 'woocommerce',
			'required' 	=> false,
		),

	);

	$theme_text_domain = 'okthemes';
	$config = array(
		'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
			'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
			'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);
	tgmpa( $plugins, $config );
}

/*-----------------------------------------------------------------------------------*/
/* Initialize the Options Framework
/* http://wptheming.com/options-framework-theme/
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/' );
	require_once (PARENT_DIR . '/admin/options-framework.php');
}

// Verify if woocommerce is active
$woocommerce_is_active = in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );

// Include the meta box script
require_once RWMB_DIR . 'meta-box.php';
// Include the meta box options
include PARENT_DIR.'/lib/metaboxes.php';
// Include the post thumb position function
include PARENT_DIR.'/lib/post-thumb-pos.php';
// Include the fonts function
include PARENT_DIR.'/lib/fonts.php';
// Include post types
require_once PARENT_DIR . '/lib/post-types.php';
// Include sidebars
require_once PARENT_DIR . '/lib/sidebars.php';

// Include woofunctions
if ($woocommerce_is_active) require_once PARENT_DIR . '/lib/theme-woocommerce.php';

require_once PARENT_DIR . '/lib/theme-flex-js.php';

/*
 * override default filter for 'textarea' sanitization.
 */

add_action('admin_init','optionscheck_change_santiziation', 100);

function optionscheck_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'st_custom_sanitize_textarea' );
}

function st_custom_sanitize_textarea($input) {
    global $allowedposttags;
    $custom_allowedtags["embed"] = array(
      "src" => array(),
      "type" => array(),
      "allowfullscreen" => array(),
      "allowscriptaccess" => array(),
      "height" => array(),
          "width" => array()
      );
    	$custom_allowedtags["script"] = array();
    	$custom_allowedtags["a"] = array('href' => array(),'title' => array());
    	$custom_allowedtags["img"] = array('src' => array(),'title' => array(),'alt' => array());
    	$custom_allowedtags["br"] = array();
    	$custom_allowedtags["em"] = array();
    	$custom_allowedtags["strong"] = array();
      $custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
      $output = wp_kses( $input, $custom_allowedtags);
    return $output;
        $of_custom_allowedtags = array_merge($of_custom_allowedtags, $allowedtags);
        $output = wp_kses( $input, $of_custom_allowedtags);
    return $output;
}

// require_once (PARENT_DIR . '/lib/shortcodes-ultimate/shortcodes-ultimate.php');
require_once (PARENT_DIR . '/lib/widgets.php');
require_once (PARENT_DIR . '/lib/custom-scripts.php');

//REMOVE VERSION STRING FROM HEADER
remove_action('wp_head', 'wp_generator');

function options_stylesheets_alt_style()   {
	if ( of_get_option('stylesheet') ) {
		wp_enqueue_style( 'options_stylesheets_alt_style', of_get_option('stylesheet'), array(), null );
	}
}
add_action( 'wp_enqueue_scripts', 'options_stylesheets_alt_style' );

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

// Build Query vars for dynamic theme option CSS from Options Framework


// functions run on activation –> important flush to clear rewrites
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {$wp_rewrite->flush_rules();}

//Register and enqueue scripts
add_action('wp_enqueue_scripts', 'load_styles_and_scripts');
function load_styles_and_scripts() {

	//only on frontend
	if(is_admin()) return;
	$woocommerce_is_active = in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
	$theme  = wp_get_theme();
	$version = $theme['Version'];

	//Register styles
	wp_register_style('skeleton', get_template_directory_uri().'/styles/skeleton.css', false, $version, 'screen, projection');
	wp_register_style('theme', get_stylesheet_directory_uri().'/style.css', 'okthemes', $version, 'screen, projection');
	wp_register_style('prettyphoto', get_template_directory_uri().'/styles/prettyPhoto.css', 'okthemes', $version, 'screen, projection');
	wp_register_style('isotope', get_template_directory_uri().'/styles/isotope.css', 'okthemes', $version, 'screen, projection');
	wp_register_style('woocommercecustomstyle', get_template_directory_uri().'/styles/woocommerce.css', 'okthemes', $version, 'screen, projection');
	wp_register_style('cloudzoomstyle', get_template_directory_uri().'/styles/cloud-zoom.css', 'okthemes', $version, 'screen, projection');
	wp_register_style('flexslider', get_template_directory_uri().'/styles/flexslider.css', 'okthemes', $version, 'screen, projection');
	wp_register_style('eislider', get_template_directory_uri().'/styles/eislider.css', 'okthemes', $version, 'screen, projection');
	wp_register_style('catslider', get_template_directory_uri().'/styles/catslider.css', 'okthemes', $version, 'screen, projection');
	wp_register_style('sequence', get_template_directory_uri().'/styles/sequencejs-theme.modern-slide-in.css', 'okthemes', $version, 'screen, projection');
	wp_register_style('iview', get_template_directory_uri().'/styles/iview.css', 'okthemes', $version, 'screen, projection');
	wp_register_style('slit', get_template_directory_uri().'/styles/slit.css', 'okthemes', $version, 'screen, projection');
	wp_register_style('jmpress', get_template_directory_uri().'/styles/jmpress.css', 'okthemes', $version, 'screen, projection');
	wp_register_style('ie7-style', get_template_directory_uri() . '/styles/ie7.css', 'okthemes', $version, 'screen, projection');
	wp_register_style('responsive', get_template_directory_uri().'/styles/responsive.css', 'okthemes', $version, 'screen, projection');
	wp_register_style('phpstyle', get_template_directory_uri() . '/style.php', 'okthemes', $version, 'screen, projection');

	//Enqueue styles
	wp_enqueue_style( 'skeleton' );
	wp_enqueue_style( 'theme' );
	wp_enqueue_style( 'prettyphoto' );

	//Portfolio isotope
	if ( is_page_template('page-portfolio.php') )
	wp_enqueue_style( 'isotope' );

	wp_enqueue_style( 'woocommercecustomstyle' );

	//Product cloud zoom
	if (of_get_option('product_cloud_zoom'))
		wp_enqueue_style( 'cloudzoomstyle' );

	wp_enqueue_style( 'flexslider' );

	//Elastic slider
	if (of_get_option('slideshow_select') == "elastic")
		wp_enqueue_style( 'eislider' );

	//Category slider
	if (of_get_option('slideshow_select') == "multiitemslider")
		wp_enqueue_style( 'catslider' );

	//Sequence slider
	if (of_get_option('slideshow_select') == "sequence")
		wp_enqueue_style( 'sequence' );

	//Iview slider
	if (of_get_option('slideshow_select') == "iview")
		wp_enqueue_style( 'iview' );

	//Slit slider
	if (of_get_option('slideshow_select') == "slit")
		wp_enqueue_style( 'slit' );

	//Jmpress slider
	if (of_get_option('slideshow_select') == "jmpress")
		wp_enqueue_style( 'jmpress' );

	wp_enqueue_style( 'ie7-style' );

	//Responsiveness
	if (of_get_option('responsiveness'))
		wp_enqueue_style( 'responsive' );

	wp_enqueue_style( 'phpstyle' );

	//Register scripts
	wp_register_script('custom',get_template_directory_uri() ."/javascripts/app.js",array('jquery'),'1.2.3',true);
	wp_register_script('prettyphoto',get_template_directory_uri() ."/javascripts/jquery.prettyPhoto.js",array('jquery'),'1.2.3',true);
	wp_register_script('isotope',get_template_directory_uri() ."/javascripts/jquery.isotope.min.js",array('jquery'),'1.2.3',true);
	wp_register_script('mobilemenu',get_template_directory_uri() ."/javascripts/jquery.mobilemenu.js",array('jquery'),'1.2.3',true);
	wp_register_script('fitvids',get_template_directory_uri() ."/javascripts/jquery.fitvids.js",array('jquery'),'1.2.3',true);
	wp_register_script('cloud-zoom',get_template_directory_uri() ."/javascripts/cloud-zoom.1.0.2.min.js",array('jquery'),'1.2.3',true);
	wp_register_script('modernizr',get_template_directory_uri() ."/javascripts/modernizr.js",array('jquery'),'1.2.3',true);
	wp_register_script('easing',get_template_directory_uri() ."/javascripts/jquery.easing.1.3.js",array('jquery'),'1.2.3',true);
	wp_register_script('raphael',get_template_directory_uri() ."/javascripts/raphael-min.js",array('jquery'),'1.2.3',true);
	wp_register_script('flexslider',get_template_directory_uri() ."/javascripts/jquery.flexslider-min.js",array('jquery'),'1.2.3',true);
	wp_register_script('eislideshow',get_template_directory_uri() ."/javascripts/jquery.eislideshow.js",array('jquery'),'1.2.3',true);
	wp_register_script('catslider',get_template_directory_uri() ."/javascripts/jquery.catslider.js",array('jquery'),'1.2.3',true);
	wp_register_script('sequence',get_template_directory_uri() ."/javascripts/sequence.jquery-min.js",array('jquery'),'1.2.3',true);
	wp_register_script('iview',get_template_directory_uri() ."/javascripts/iview.min.js",array('jquery'),'1.2.3',true);
	wp_register_script('ba-slit',get_template_directory_uri() ."/javascripts/jquery.ba-cond.min.js",array('jquery'),'1.2.3',true);
	wp_register_script('slit',get_template_directory_uri() ."/javascripts/jquery.slitslider.js",array('jquery'),'1.2.3',true);
	wp_register_script('jmpress',get_template_directory_uri() ."/javascripts/jmpress.min.js",array('jquery'),'1.2.3',true);
	wp_register_script('jmslideshow',get_template_directory_uri() ."/javascripts/jquery.jmslideshow.js",array('jquery'),'1.2.3',true);
	wp_register_script('gmaps',get_template_directory_uri() ."/javascripts/gmaps.js",array('jquery'),'1.2.3',true);
	wp_register_script('google-map',"http://maps.google.com/maps/api/js?sensor=true");
	wp_register_script('jvalidate',get_template_directory_uri() ."/javascripts/jquery.validate.min.js",array('jquery'),'1.2.3',true);
	wp_register_script('jcookie',get_template_directory_uri() ."/javascripts/jquery.cookie.min.js",array('jquery'),'1.2.3',true);
	wp_register_script('grid-list',get_template_directory_uri() ."/javascripts/jquery.gridlistview.min.js",array('jquery'),'1.2.3',true);
	wp_register_script('scrollto',get_template_directory_uri() ."/javascripts/jquery.scrollTo-1.4.3.1-min.js",array('jquery'),'1.2.3',true);

	//Enqueue script
	wp_enqueue_script( 'custom' );
	wp_enqueue_script( 'prettyphoto' );

	//Portfolio isotope
	if ( is_page_template('page-portfolio.php') )
		wp_enqueue_script( 'isotope' );

	wp_enqueue_script( 'mobilemenu' );
	wp_enqueue_script( 'fitvids' );

	//Cloud zoom
	if (of_get_option('product_cloud_zoom'))
		wp_enqueue_script( 'cloud-zoom' );

	wp_enqueue_script( 'modernizr' );
	wp_enqueue_script( 'easing' );
	wp_enqueue_script( 'flexslider' );

	//Elastic slider
	if (of_get_option('slideshow_select') == "elastic")
		wp_enqueue_script( 'eislideshow' );

	//Category slider
	if (of_get_option('slideshow_select') == "multiitemslider")
		wp_enqueue_script( 'catslider' );

	//Sequence slider
	if (of_get_option('slideshow_select') == "sequence")
		wp_enqueue_script( 'sequence' );

	//Iview slider
	if (of_get_option('slideshow_select') == "iview") {
		wp_enqueue_script( 'raphael' );
		wp_enqueue_script( 'iview' );
	}

	//Slit slider
	if (of_get_option('slideshow_select') == "slit") {
		wp_enqueue_script( 'ba-slit' );
		wp_enqueue_script( 'slit' );
	}

	//Jmpress slider
	if (of_get_option('slideshow_select') == "jmpress") {
		wp_enqueue_script( 'jmpress' );
		wp_enqueue_script( 'jmslideshow' );
	}

	//Gmaps
	if ( is_page_template('page-contact.php') ) {
		wp_enqueue_script( 'gmaps' );
		wp_enqueue_script( 'google-map' );
	}

	wp_enqueue_script( 'jvalidate' );
	wp_enqueue_script( 'scrollto' );

	//Grid on shop pages
	if ($woocommerce_is_active) {
	if ( is_shop() || is_product_category() || is_product_tag() ) {
		wp_enqueue_script( 'jcookie' );
		wp_enqueue_script( 'grid-list' );
	}}

	global $wp_styles;
	$wp_styles->add_data('ie7-style', 'conditional', 'lte IE 7');
}

// Clean HTML
add_filter('the_content', 'shortcode_empty_paragraph_fix');

function shortcode_empty_paragraph_fix($content) {
$array = array (
	'<p>[' => '[',
	']</p>' => ']',
	']<br />' => ']'
);
$content = strtr($content, $array);
return $content;
}


/** Tell WordPress to run cumico_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'cumico_setup' );

if ( ! function_exists( 'cumico_setup' ) ):

function cumico_setup() {

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 660, 99999, true ); // default Post Thumbnail dimensions (cropped)

	// additional image sizes
	bt_add_image_size( 'blog-single', 660, 99999, array( 'left', 'top' ) );
	bt_add_image_size( 'slideshow-thumbnail', 1200, 450 , array( 'left', 'top' ) );
	bt_add_image_size( 'camera-thumbnail', 100, 75 , array( 'left', 'top' ) );
	bt_add_image_size( 'sequence-thumbnail', 266, 568 , array( 'left', 'top' ) );
	bt_add_image_size( 'jmpress-thumbnail', 400, 450 , array( 'left', 'top' ) );
	bt_add_image_size( 'sequence-thumbnail-mini', 60, 128 , array( 'left', 'top' ) );
	bt_add_image_size( 'page-thumbnail', 1200, 350 , array( 'left', 'top' ) );
	bt_add_image_size( 'blog-thumbnail-3-col', 300, 300 , array( 'left', 'top' ) );
	bt_add_image_size( 'portfolio-thumbnail-4-col', 180, 180 , array( 'left', 'top' ) );
	bt_add_image_size( 'sponsors-thumbnail', 180, 180 , array( 'left', 'top' ) );
	bt_add_image_size( 'testimonials-thumbnail', 50, 50 , array( 'left', 'top' ) );
	bt_add_image_size( 'team-thumbnail', 180, 180 , array( 'left', 'top' ) );
	bt_add_image_size( 'portfolio-thumbnail-3-col', 260, 260 , array( 'left', 'top' ) );
	bt_add_image_size( 'portfolio-thumbnail-2-col', 420, 420 , array( 'left', 'top' ) );
	bt_add_image_size( 'portfolio-thumbnail-1-col', 900, 900 , array( 'left', 'top' ) );
	bt_add_image_size( 'sponsors', 300, 9999); //207x180 pixels

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Enable shortcodes in widgets
	add_filter('widget_text', 'do_shortcode');

	// This theme supports woocommerce
	add_theme_support( 'woocommerce' );

	// Register the available menus
	register_nav_menus( array(
		'primary' => __('Primary Navigation', 'okthemes' ),
		'secondary' => __('Footer Navigation', 'okthemes' ),
		'tertiary' => __('Top Header Navigation', 'okthemes' )
	));

	if ( ! isset( $content_width ) ) $content_width = 900;

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'okthemes', PARENT_DIR . '/languages' );

	$locale = get_locale();
	$locale_file = PARENT_DIR . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	}
	endif;

/**
 * Sets the post excerpt length to 40 characters.
 */
if ( !function_exists( 'cumico_excerpt_length' ) ) {
function cumico_excerpt_length( $length ) {return 40;}
	add_filter( 'excerpt_length', 'cumico_excerpt_length' );
}


/**
 * Sets the post excerpt length dynamic.
 */

function cumico_custom_excerpt( $excerpt, $num_words ) {
	//Delete all shortcode tags from the content.
    $excerpt = strip_shortcodes( $excerpt );

    $excerpt = str_replace(']]>', ']]&gt;', $excerpt);

    $allowed_tags = '<p>,<a>,<strong>'; /*** Add the allowed HTML tags separated by a comma. ***/
    $excerpt = strip_tags($excerpt, $allowed_tags);

    $words = preg_split("/[\n\r\t ]+/", $excerpt, $num_words + 1, PREG_SPLIT_NO_EMPTY);
    if ( count($words) > $num_words ) {
        array_pop($words);
        $excerpt = implode(' ', $words);
        $excerpt = $excerpt . '&hellip;';
    } else {
        $excerpt = implode(' ', $words);
    }

	return $excerpt;
}

/**
 * Returns a "Continue Reading" link for excerpts
 */
if ( !function_exists( 'cumico_continue_reading_link' ) ) {
function cumico_continue_reading_link() {
	return '<p><a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&#187;</span>', 'okthemes' ) . '</a></p>';
}
}
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and cumico_continue_reading_link().
 */

if ( !function_exists( 'cumico_auto_excerpt_more' ) ) {
function cumico_auto_excerpt_more( $more ) {
	return ' &hellip;' . cumico_continue_reading_link();
}
add_filter( 'excerpt_more', 'cumico_auto_excerpt_more' );

}

/**
 * Removes inline styles printed when the gallery shortcode is used.
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Remove read more jump
 */

if ( !function_exists( 'remove_more_jump_link' ) ) {
function remove_more_jump_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
	$end = strpos($link, '"',$offset);
	}
	if ($end) {
	$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
	}
	add_filter('the_content_more_link', 'remove_more_jump_link');
}

/** Pagination */
function pagination($pages = '', $range = 4)
{
     $showitems = ($range * 2)+1;

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }

     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
         echo "</div>\n";
     }
}

// Add specific CSS class by filter
add_filter('post_class','my_class_names');
function my_class_names($classes) {
	// add 'class-name' to the $classes array
	$classes[] = 'custom';
	// return the $classes array
	return $classes;
}

/** Comment Styles */

if ( ! function_exists( 'st_comments' ) ) :
function st_comments($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
<div id="comment-<?php comment_ID(); ?>" class="single-comment clearfix">
    <div class="comment-author vcard"> <?php echo get_avatar($comment,$size='64'); ?></div>
    <div class="comment-meta commentmetadata">
            <?php if ($comment->comment_approved == '0') : ?>
            <em><?php _e('Comment is awaiting moderation','okthemes');?></em> <br />
            <?php endif; ?>
            <h6><?php echo ''.get_comment_author_link(). '' ?></h6>
            <span class="comment-date"><?php echo ''. get_comment_date(). '' ?></span>
            <span class="comment-reply-link"><?php comment_reply_link(array_merge( $args, array('reply_text' => __('Reply','okthemes'),'depth' => $depth, 'max_depth' => $args['max_depth']))); ?></span>

            <div class="clear"></div>
            <?php comment_text() ?>
    </div>
</div>
<!-- </li> -->
<?php  }
endif;

if ( ! function_exists( 'cumico_posted_on' ) ) :
function cumico_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'okthemes' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'okthemes' ), get_the_author() ) ),
		get_the_author()
	);
}
endif;

if ( ! function_exists( 'cumico_posted_in' ) ) :
function cumico_posted_in() {
	/* translators: used between list items, there is a space after the comma */
	  $categories_list = get_the_category_list( __( ', ', 'okthemes' ) );

	  /* translators: used between list items, there is a space after the comma */
	  $tag_list = get_the_tag_list( '', __( ', ', 'okthemes' ) );
	  if ( '' != $tag_list ) {
		  $utility_text = __( 'Posted in %1$s and tagged %2$s', 'okthemes' );
	  } elseif ( '' != $categories_list ) {
		  $utility_text = __( 'Posted in %1$s by <a href="%6$s">%5$s</a>.', 'okthemes' );
	  } else {
		  $utility_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'okthemes' );
	  }

	  printf(
		  $utility_text,
		  $categories_list,
		  $tag_list,
		  esc_url( get_permalink() ),
		  the_title_attribute( 'echo=0' ),
		  get_the_author(),
		  esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
	  );
}

endif;

// Remove rel attribute from the category list
function remove_category_list_rel($output)
{
  $output = str_replace(' rel="category"', '', $output);
  return $output;
}
add_filter('wp_list_categories', 'remove_category_list_rel');
add_filter('the_category', 'remove_category_list_rel');

// Header Functions

// Hook to add content before header

if ( !function_exists( 'st_above_header' ) ) {
	function st_above_header() {do_action('st_above_header');}
} // endif

// Primary Header Function
if ( !function_exists( 'st_header' ) ) {
	function st_header() {do_action('st_header');}
}

// Opening #header div with flexible grid
if ( !function_exists( 'st_header_open' ) ) {
	function st_header_open() {
	  echo "<div id=\"header\">\n<div class=\"container\">\n";
	}
} // endif

add_action('st_header','st_header_open', 1);


// Hookable theme option field to add content to header
if ( !function_exists( 'st_header_extras' ) ) {

function st_header_extras() {
	if ( has_nav_menu( 'tertiary' ) ) {
		echo '<div id="header-top-navigation" class="twelve columns">';
		wp_nav_menu( array( 'container_class' => 'top-menu-header', 'theme_location' => 'tertiary'));
		echo '</div><!--/#header-top-navigation-->';
	}
}
} // endif

add_action('st_header','st_header_extras', 2);


// Build the logo
if ( !function_exists( 'st_logo' ) ) {

function st_logo() {
	// Displays H1 or DIV based on whether we are on the home page or not (SEO)
	$heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div';
	if (of_get_option('use_logo_image')) {
		$class="graphic";
	} else {
		$class="text";
	}

	echo '<div class="logo-wrap twelve columns">
	<div class="logo-wrapper">
	<'.$heading_tag.' id="site-title" class="'.$class.'">
		<a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo('name','display')).'">'.get_bloginfo('name').'</a>
	</'.$heading_tag.'>'. "\n";

	if (of_get_option('display_site_tagline') ) {
		echo '<span class="site-desc '.$class.'">'.get_bloginfo('description').'</span>'. "\n";
	}
	echo '</div>';

	if (function_exists('header_mini_cart')) {
		if (!of_get_option('store_catalog_mode')) {
			if (of_get_option('store_header_cart')) {
				echo header_mini_cart();
			}
		}
	}

	if (of_get_option('store_header_search')) {

		echo  '<div class="header_form">
		<form role="search" method="get" id="searchform" class="main-search" action="'.esc_url( home_url( '/'  ) ).'">
            <div>
                <input type="text" value="'.get_search_query().'" name="s" id="s" />
                <input type="submit" class="submit-button" value="'.esc_attr__( 'Search' ).'" />
                <input type="hidden" name="post_type" value="product" />
            </div>
        </form>
		</div>';

	}

	echo '</div>';
}
} // endif

add_action('st_header','st_logo', 3);

if ( !function_exists( 'logostyle' ) ) {

function logostyle() {
	if (of_get_option('use_logo_image')) {
	$logo768w = of_get_option('logo_width') / 1.2;
	$logo768h = of_get_option('logo_height') / 1.2;
	echo '<style type="text/css">
	#header #site-title.graphic a {
		background-image: url('.of_get_option('header_logo').');
		width: '.of_get_option('logo_width').'px;
		height: '.of_get_option('logo_height').'px;
	}
	@media only screen and (min-width: 768px) and (max-width: 959px) {
		#header #site-title.graphic a {
			width: '.$logo768w.'px;
			height: '.$logo768h.'px;
		}
	}
	</style>';
	}
}

} //endif

add_action('wp_head', 'logostyle');

// Navigation (menu)
if ( !function_exists( 'st_navbar' ) ) {

function st_navbar() {
	if ( has_nav_menu( 'primary' ) ) {
		echo '<div id="navigation" class="twelve columns">';
		echo '<div class="hr-bullet"></div>';
		wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary'));
		echo '<div class="hr-bullet navigation-bottom"></div>';
		echo '</div><!--/#navigation-->';
	}
}

} //endif
add_action('st_header','st_navbar', 4);

if ( !function_exists( 'st_header_close' ) ) {
	function st_header_close() {echo "</div></div><!--/#header-->";}
} //endif
add_action('st_header','st_header_close', 5);



// Hook to add content after header

if ( !function_exists( 'st_below_header' ) ) {
	function st_below_header() {do_action('st_below_header');}
} //endif

/**
 * Replaces the login header logo
 */
add_action( 'login_head', 'namespace_login_style' );
function namespace_login_style() {
	if (of_get_option('use_wp_admin_logo')) {
    echo '<style>.login h1 a { background-image: url( '.of_get_option('wp_admin_logo').' ) !important; background-size:auto; width:auto; height:auto; margin-bottom:15px; }</style>';
	}
}

// End Header Functions

// Before Content - st_before_content($columns);

if ( !function_exists( 'st_before_content' ) ) {

	function st_before_content($columns) {

	// Set the default

	if (empty($columns)) {
	$columns = 'nine';
	} else {
	// Check the function for a returned variable
	$columns = $columns;
	}


	if (is_page_template('onecolumn-page.php')) {
	$columns = 'twelve';
	}

	// check to see if bbpress is installed

	if ( class_exists( 'bbPress' ) ) {
	// force wide on bbPress pages
	if (is_bbpress()) {
	$columns = 'twelve';
	}

	// unless it's the member profile
	if (bbp_is_user_home()) {
	$columns = 'twelve';
	}

	} // bbPress

	// Apply the markup
	echo "<div id=\"content\" class=\"$columns columns\">";
	}
}


// After Content

if (! function_exists('st_after_content'))  {
    function st_after_content() {
    	echo "\t\t</div><!-- /.columns (#content) -->\n";
    }
}

// Page headline

if (! function_exists('st_page_headline'))  {
    function st_page_headline() {
		if( !is_home() && !is_tag() && !is_category() && !is_author() && !is_day() && !is_month() && !is_year() && !is_404() && !is_attachment() && !is_search() && !is_archive() ) {
			$page_headlines = rwmb_meta( 'gg_page_headline' );

			if ($page_headlines) {
				if ( (!is_single()) || (!is_archive()) ) {
					echo "<div class=\"page-headline-wrapper\"><div class=\"container\"><div class=\"twelve columns\">";
					echo "<p>$page_headlines</p>";
					echo "</div><div class=\"clear\"></div><div class=\"hr-bullet\"></div></div></div><div class=\"clear\"></div>";
				}
			}

			if ( (has_post_thumbnail() && is_page())) {
				echo "<div class=\"page-headline-image-wrapper\"><div class=\"page-headline-image\"><div class=\"slideshow-top-shadow\"></div>";
					the_post_thumbnail('page-thumbnail');
				echo "</div></div>";
			}
		}
    }
}


// Before Sidebar - do_action('st_before_sidebar')

// call up the action
if ( !function_exists( 'before_sidebar' ) ) {

	function before_sidebar($columns) {
	if (empty($columns)) {
	// Set the default
	$columns = 'three';
	} else {
	// Check the function for a returned variable
	$columns = $columns;
	}
	echo '<div id="sidebar" class="'.$columns.' columns" role="complementary">';
	}
} //endif
// create our hook
add_action( 'st_before_sidebar', 'before_sidebar');

// After Sidebar
if ( !function_exists( 'after_sidebar' ) ) {
	function after_sidebar() {
	// Additional Content could be added here
	   echo '</div><!-- #sidebar -->';
	}
} //endif
add_action( 'st_after_sidebar', 'after_sidebar');

function custom_body_class($classes){
	$bodyvar = "";
	if((has_post_thumbnail() && is_page())){
		$bodyvar = "page-with-thumbnail";
	}

	if (of_get_option('slideshow_select') == 'none')
		$bodyvar = "no-slideshow";

	if (of_get_option('slideshow_select') == 'multiitemslider')
		$bodyvar = "multiitemslider-slideshow";

	global $post;
	array_push($classes, $bodyvar);
	return $classes;
}

add_filter('body_class', 'custom_body_class');


// Enable Shortcodes in excerpts and widgets
add_filter('widget_text', 'do_shortcode');
add_filter('the_excerpt', 'do_shortcode');
add_filter('get_the_excerpt', 'do_shortcode');

function dimox_breadcrumbs() {

  /* === OPTIONS === */
  $text['home']     = 'Home'; // text for the 'Home' link
  $text['category'] = 'Archive by Category "%s"'; // text for a category page
  $text['search']   = 'Search Results for "%s" Query'; // text for a search results page
  $text['tag']      = 'Posts Tagged "%s"'; // text for a tag page
  $text['author']   = 'Articles Posted by %s'; // text for an author page
  $text['404']      = 'Error 404'; // text for the 404 page

  $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $delimiter   = ' &rsaquo; '; // delimiter between crumbs
  $before      = '<span class="current">'; // tag before the current crumb
  $after       = '</span>'; // tag after the current crumb
  /* === END OF OPTIONS === */

  global $post;
  $homeLink = home_url() . '/';
  $linkBefore = '<span typeof="v:Breadcrumb">';
  $linkAfter = '</span>';
  $linkAttr = ' rel="v:url" property="v:title"';
  $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

  if (is_home() || is_front_page()) {

    if ($showOnHome == 1) echo '<div id="breadcrumb"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

  } else {

    echo '<div id="breadcrumb" >' . sprintf($link, $homeLink, $text['home']) . $delimiter;

    if ( is_category() ) {
      $thisCat = get_category(get_query_var('cat'), false);
      if ($thisCat->parent != 0) {
        $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
        echo $cats;
      }
      echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

    } elseif ( is_search() ) {
      echo $before . sprintf($text['search'], get_search_query()) . $after;

    } elseif ( is_day() ) {
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
      echo $before . get_the_time('d') . $after;

    } elseif ( is_month() ) {
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo $before . get_the_time('F') . $after;

    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;

    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
        if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, $delimiter);
        if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
        $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
        $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
        echo $cats;
        if ($showCurrent == 1) echo $before . get_the_title() . $after;
      }

    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;

    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      $cats = get_category_parents($cat, TRUE, $delimiter);
      $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
      $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
      echo $cats;
      printf($link, get_permalink($parent), $parent->post_title);
      if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

    } elseif ( is_page() && !$post->post_parent ) {
      if ($showCurrent == 1) echo $before . get_the_title() . $after;

    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      for ($i = 0; $i < count($breadcrumbs); $i++) {
        echo $breadcrumbs[$i];
        if ($i != count($breadcrumbs)-1) echo $delimiter;
      }
      if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

    } elseif ( is_tag() ) {
      echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . sprintf($text['author'], $userdata->display_name) . $after;

    } elseif ( is_404() ) {
      echo $before . $text['404'] . $after;
    }

    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page', 'okthemes') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }

    echo '</div>';

  }
} // end dimox_breadcrumbs()

if (!function_exists('get_image_path'))  {
function get_image_path() {
	global $post;
	$id = get_post_thumbnail_id();
	// check to see if NextGen Gallery is present
	if(stripos($id,'ngg-') !== false && class_exists('nggdb')){
	$nggImage = nggdb::find_image(str_replace('ngg-','',$id));
	$thumbnail = array(
	$nggImage->imageURL,
	$nggImage->width,
	$nggImage->height
	);
	// otherwise, just get the wp thumbnail
	} else {
	$thumbnail = wp_get_attachment_image_src($id,'full', true);
	}
	$theimage = $thumbnail[0];
	return $theimage;
}
}

function in_array_r($needle, $haystack, $strict = true) {
	foreach ($haystack as $item) {
		if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
			return true;
		}
	}
	return false;
}



add_filter( 'the_category', 'replace_cat_tag' );
function replace_cat_tag ( $text ) {
	$text = str_replace('rel="category tag"', "", $text); return $text;
}

// Before Footer
if (!function_exists('st_before_footer'))  {
    function st_before_footer() {
			echo '<div class="footer-wrapper-wide"><div class="container"><div id="footer" class="twelve columns">';
    }
}

if ( !function_exists( 'st_footer' ) ) {

// The Footer
function st_footer() {
	  get_sidebar("footer");
	?>

	<div id="credits">
		<div class="hr-bullet"></div>
		<div class="eight columns alpha">
		<?php if ( has_nav_menu( 'secondary' ) ) {wp_nav_menu( array( 'container_class' => 'menu-footer', 'theme_location' => 'secondary'));} ?>
		</div>

		<div class="four columns omega">
		<?php if (of_get_option("footer_copyright")){ echo '<p>'.of_get_option('footer_copyright').'</p>'; } ?>
		</div>
	</div>

	<?php
	$footer_img = of_get_option('footer_image');
	$footer_img_link = of_get_option('footer_image_link');
	if ($footer_img) {
		echo '<div class="footer-image">';
		echo '<div class="hr-bullet"></div>';
		if ($footer_img_link) echo '<a href="'.$footer_img_link.'">';
			echo '<img src="'.$footer_img.'" alt="" />';
		if ($footer_img_link) echo '</a>';
		echo '</div>';
	}
}
}

// After Footer
if (!function_exists('st_after_footer'))  {

    function st_after_footer() {
			echo "</div>"; //close .container (before credits)
			echo "</div>"; //close .credits-wrapper-wide
			echo "</div>"; //close .master-wrapper
			echo "</div>"; //close .master-wrapper


			// Google Analytics
			if (of_get_option('footer_scripts') <> "" ) {
				echo '<script type="text/javascript">'.stripslashes(of_get_option('footer_scripts')).'</script>';
			}


    }
}
