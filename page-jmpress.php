<?php

/**
 * Template Name: JMpress slider page
 */

get_header(); ?>

<div id="jms-slideshow" class="jms-slideshow">
<div class="slideshow-top-shadow"></div>
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	query_posts( array( 
						 'post_type' => 'slideshow', 
						 'paged' => $paged, 
						 'posts_per_page' => of_get_option('slideshow_nr_posts'),
						 'ignore_sticky_posts' => 1,
						 'slideshow_category' => 'jmpress'
						 )
				  );
$k = 1;				  
if ( have_posts() ) : while ( have_posts() ) : the_post(); 

$slideshow_video_link = rwmb_meta( 'gg_slideshow_video_link' );
$slideshow_external_link = rwmb_meta( 'gg_slideshow_external_link' );
$slideshow_caption_title = rwmb_meta( 'gg_slideshow_caption_title' );
$slideshow_caption_subtitle = rwmb_meta( 'gg_slideshow_caption_subtitle' );
?>

<div class="step" data-color="color-1"  <?php if($k%2 == 0) echo 'data-y="500" data-scale="0.4" data-rotate-x="30"'; ?>>
    <div class="jms-content">
        <h3><?php echo $slideshow_caption_title; ?></h3>
        <p><?php echo $slideshow_caption_subtitle; ?></p>
        <a class="jms-link" href="#">Read more</a>
    </div>
    <?php the_post_thumbnail( 'jmpress-thumbnail' ); ?>
</div>


<?php $k++; endwhile; endif; ?>
</div>

<script type="text/javascript">
	jQuery(function() {
		
		var jmpressOpts	= {
			animation		: { transitionDuration : '0.8s' }
		};
		
		jQuery( '#jms-slideshow' ).jmslideshow( jQuery.extend( true, { jmpressOpts : jmpressOpts }, {
			autoplay	: true,
			interval    : 3500,
			bgColorSpeed: '0.8s',
			arrows		: false,
			dots        : true
		}));
		
	});
</script>

<div class="clear"></div>

<div class="container">
<?php 
$homepage_layout = of_get_option('homepage_layout');
$homepage_sidebar = of_get_option('homepage_sidebar_select');
if ($homepage_layout == 'with_sidebar') st_before_content($columns='');
else st_before_content($columns='twelve');
?>

<div id="homepage-style-default" <?php if ($homepage_layout == 'with_sidebar') echo' class="with-sidebar" '; ?>>

<?php
$homepage_sorter = of_get_option('homepage_sorter');
$homepage_sorter = $homepage_sorter['enabled'];

$layout_width = of_get_option('layout_width');
if ($homepage_layout == 'with_sidebar') $sh_columns = '3'; else $sh_columns = '4';
if ($layout_width == 'layout_width_960') { $item_width = '220'; $item_margin = '20';  }
if ($layout_width == 'layout_width_1140') { $item_width = '245'; $item_margin = '40'; }

if ($homepage_sorter):
foreach ($homepage_sorter as $key=>$value) {
    switch($key) {
		//Headline area
	    case 'headline_area':
       
		$headline_title = of_get_option('headline_title');
		$headline_title_link = of_get_option('headline_title_link');
		$headline_desc = of_get_option('headline_desc');
		
		echo do_shortcode('[headline title="'.$headline_title.'" link="'.$headline_title_link.'" border_bottom="no" border_top="yes"]'.$headline_desc.'[/headline]');
		
        break;
		//End headline area
		
       	//Featured products area
	    case 'featured_products':
        if ($woocommerce_is_active) {
		$featured_products_title = of_get_option('featured_products_title');
		$featured_products_carousel = of_get_option('featured_products_carousel');
		$featured_products_carousel_autoplay = of_get_option('featured_products_carousel_autoplay');
		$featured_products_posts = of_get_option('featured_products_posts');
		$featured_products_orderby = of_get_option('featured_products_orderby');
		$featured_products_order = of_get_option('featured_products_order'); 
		echo '<div class="hr-bullet"></div>';
		if ($featured_products_carousel == "yes") echo '<div class="flexslider carousel products-wrapper uniq-featured-products">';
		else echo '<div class="products-wrapper">';

        if ($featured_products_title) echo '<h3 class="widget-title">'.$featured_products_title.'</h3>';
        echo do_shortcode('[featured_products columns="'.$sh_columns.'" per_page="'.$featured_products_posts.'" orderby="'.$featured_products_orderby.'" order="'.$featured_products_order.'"]');
		
		echo '</div>';
		
		if ($featured_products_carousel == 'yes') {
		echo '<script type="text/javascript">';
		echo 'jQuery(document).ready(function(){jQuery(".products-wrapper.flexslider.carousel.uniq-featured-products").flexslider({';
		echo 'animation: "slide",move:1, selector: ".products > li", itemWidth: '.$item_width.',itemMargin: '.$item_margin.',controlNav: false,slideshow: '.$featured_products_carousel_autoplay.',fixedHeightMiddleAlign: true';
		echo '});});</script>';
		} else { echo ''; }
		}
        break;
		//End featured products area
		
		//Sale products area
        case 'sale_products':
		if ($woocommerce_is_active) {
		$sale_products_title = of_get_option('sale_products_title');
		$sale_products_carousel = of_get_option('sale_products_carousel');
		$sale_products_carousel_autoplay = of_get_option('sale_products_carousel_autoplay');
		$sale_products_posts = of_get_option('sale_products_posts');
		$sale_products_orderby = of_get_option('sale_products_orderby');
		$sale_products_order = of_get_option('sale_products_order');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[sale_products columns="'.$sh_columns.'" title="'.$sale_products_title.'" per_page="'.$sale_products_posts.'" orderby="'.$sale_products_orderby.'" order="'.$sale_products_order.'" carousel_mode="'.$sale_products_carousel.'" slideshow="'.$sale_products_carousel_autoplay.'"]');
		}
        break;
		//End sale products area
		
		//Recent products area
        case 'recent_products':
		if ($woocommerce_is_active) {
		$recent_products_title = of_get_option('recent_products_title');
		$recent_products_carousel = of_get_option('recent_products_carousel');
		$recent_products_carousel_autoplay = of_get_option('recent_products_carousel_autoplay');
		$recent_products_posts = of_get_option('recent_products_posts');
		$recent_products_orderby = of_get_option('recent_products_orderby');
		$recent_products_order = of_get_option('recent_products_order');
		
		if ($recent_products_carousel == "yes") echo '<div class="flexslider carousel products-wrapper uniq-recent-products">';
		else echo '<div class="products-wrapper"> <div class="hr-bullet"></div>';

        if ($recent_products_title) echo '<h3 class="widget-title">'.$recent_products_title.'</h3>';
        echo do_shortcode('[recent_products columns="'.$sh_columns.'" per_page="'.$recent_products_posts.'" orderby="'.$recent_products_orderby.'" order="'.$recent_products_order.'" slideshow="false"]');
        echo '</div>';
		
		if ($recent_products_carousel == 'yes') {
		echo '<script type="text/javascript">';
		echo 'jQuery(document).ready(function(){jQuery(".products-wrapper.flexslider.carousel.uniq-recent-products").flexslider({';
		echo 'animation: "slide", move:1, selector: ".products > li", itemWidth: '.$item_width.',itemMargin: '.$item_margin.',controlNav: false,slideshow: '.$recent_products_carousel_autoplay.',fixedHeightMiddleAlign: true';
		echo '});});</script>';
		} else { echo ''; }
		}
        break;
		//End recent products area
		
		//Best selling products area
		case 'best_selling_products':
		if ($woocommerce_is_active) {
		$best_selling_products_title = of_get_option('best_selling_products_title');
		$best_selling_products_carousel = of_get_option('best_selling_products_carousel');
		$best_selling_products_carousel_autoplay = of_get_option('best_selling_products_carousel_autoplay');
		$best_selling_products_posts = of_get_option('best_selling_products_posts');
		$best_selling_products_orderby = of_get_option('best_selling_products_orderby');
		$best_selling_products_order = of_get_option('best_selling_products_order');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[best_selling_products title="'.$best_selling_products_title.'" per_page="'.$best_selling_products_posts.'" orderby="'.$best_selling_products_orderby.'" order="'.$best_selling_products_order.'" carousel_mode="'.$best_selling_products_carousel.'" slideshow="'.$best_selling_products_carousel_autoplay.'"]');
		}
        break;
		//End best selling products area
		
		//Products by id area
		case 'products_by_ids':
		if ($woocommerce_is_active) {
		$products_by_id_title = of_get_option('products_by_id_title');
		$products_by_id_carousel = of_get_option('products_by_id_carousel');
		$products_by_id_carousel_autoplay = of_get_option('products_by_id_carousel_autoplay');
		$products_by_id_orderby = of_get_option('products_by_id_orderby');
		$products_by_id_order = of_get_option('products_by_id_order');
		$products_ids = of_get_option('products_ids');
		echo '<div class="hr-bullet"></div>';
		if ($products_by_id_carousel == "yes") echo '<div class="flexslider carousel products-wrapper uniq-products-by-id">';
		else echo '<div class="products-wrapper">';

        if ($products_by_id_title) echo '<h3 class="widget-title">'.$products_by_id_title.'</h3>';
        echo do_shortcode('[products columns="'.$sh_columns.'" ids="'.$products_ids.'" orderby="'.$products_by_id_orderby.'" order="'.$products_by_id_order.'" slideshow="false"]');
        
        echo '</div>';
		
		if ($products_by_id_carousel == 'yes') {
		echo '<script type="text/javascript">';
		echo 'jQuery(document).ready(function(){jQuery(".products-wrapper.flexslider.carousel.uniq-products-by-id").flexslider({';
		echo 'animation: "slide", move:1, selector: ".products > li", itemWidth: '.$item_width.',itemMargin: '.$item_margin.',controlNav: false,slideshow: '.$products_by_id_carousel_autoplay.',fixedHeightMiddleAlign: true';
		echo '});});</script>';
		} else { echo ''; }
		}
        break;
		//End products by id area
		
		//Product categories area
		case 'product_categories':
		if ($woocommerce_is_active) {
		$products_category_title = of_get_option('products_category_title');
		$products_category_carousel = of_get_option('products_category_carousel');
		$products_category_carousel_autoplay = of_get_option('products_category_carousel_autoplay');
		$products_category_orderby = of_get_option('products_category_orderby');
		$products_category_order = of_get_option('products_category_order');
		$products_category_posts = of_get_option('products_category_posts');
		echo '<div class="hr-bullet"></div>';	
		if ($products_category_carousel == "yes") echo '<div class="flexslider carousel products-wrapper uniq-products-category">';
		else echo '<div class="products-wrapper">';

        if ($products_category_title) echo '<h3 class="widget-title">'.$products_category_title.'</h3>';
        echo do_shortcode('[product_categories columns="'.$sh_columns.'" number="'.$products_category_posts.'" orderby="'.$products_category_orderby.'" order="'.$products_category_order.'" parent="0"]');
		
		echo '</div>';
		
        if ($products_category_carousel == 'yes') {
		echo '<script type="text/javascript">';
		echo 'jQuery(document).ready(function(){jQuery(".products-wrapper.flexslider.carousel.uniq-products-category").flexslider({';
		echo 'animation: "slide", move:1, selector: ".products > li", itemWidth: '.$item_width.',itemMargin: '.$item_margin.',controlNav: false,slideshow: '.$products_category_carousel_autoplay.',fixedHeightMiddleAlign: true';
		echo '});});</script>';
		} else { echo ''; }
		}
        break;
		//End product categories area
		
		//Products by category slug
		case 'products_by_category_slug':
		if ($woocommerce_is_active) {
		$products_by_category_slug_title = of_get_option('products_by_category_slug_title');
		$products_by_category_slug_carousel = of_get_option('products_by_category_slug_carousel');
		$products_by_category_slug_carousel_autoplay = of_get_option('products_by_category_slug_carousel_autoplay');
		$products_by_category_slug_orderby = of_get_option('products_by_category_slug_orderby');
		$products_by_category_slug_order = of_get_option('products_by_category_slug_order');
		$products_by_category_slug_posts = of_get_option('products_by_category_slug_posts');
		$products_by_category_slug_name = of_get_option('products_by_category_slug_name');
		echo '<div class="hr-bullet"></div>';
		if ($products_by_category_slug_carousel == "yes") echo '<div class="flexslider carousel products-wrapper uniq-products-by-cat-slug">';
		else echo '<div class="products-wrapper">';

        if ($products_by_category_slug_title) echo '<h3 class="widget-title">'.$products_by_category_slug_title.'</h3>';
        echo do_shortcode('[product_category columns="'.$sh_columns.'" category="'.$products_by_category_slug_name.'" per_page="'.$products_by_category_slug_posts.'" orderby="'.$products_by_category_slug_orderby.'" order="'.$products_by_category_slug_order.'"]');
        
        echo '</div>';
		
        if ($products_by_category_slug_carousel == 'yes') {
		echo '<script type="text/javascript">';
		echo 'jQuery(document).ready(function(){jQuery(".products-wrapper.flexslider.carousel.uniq-products-by-cat-slug").flexslider({';
		echo 'animation: "slide", move:1, selector: ".products > li", itemWidth: '.$item_width.',itemMargin: '.$item_margin.',controlNav: false,slideshow: '.$products_by_category_slug_carousel_autoplay.',fixedHeightMiddleAlign: true';
		echo '});});</script>';
		} else { echo ''; }
		}
        break;
		//End products by category slug area
		
		//Ads area
		case 'ads':

		$ads_title = of_get_option('ads_title');
		$ads_carousel = of_get_option('ads_carousel');
		$ads_carousel_autoplay = of_get_option('ads_carousel_autoplay');
		$ads_orderby = of_get_option('ads_orderby');
		$ads_order = of_get_option('ads_order');
		$ads_posts = of_get_option('ads_posts');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[ads_posts columns="'.$sh_columns.'" title="'.$ads_title.'" limit="'.$ads_posts.'" orderby="'.$ads_orderby.'" order="'.$ads_order.'" carousel_mode="'.$ads_carousel.'" slideshow="'.$ads_carousel_autoplay.'"]');
		
        break;
		//End ads area
		
		//Portfolio area
		case 'portfolio':
		
		$portfolio_title = of_get_option('portfolio_title');
		$portfolio_carousel = of_get_option('portfolio_carousel');
		$portfolio_carousel_autoplay = of_get_option('portfolio_carousel_autoplay');
		$portfolio_orderby = of_get_option('portfolio_orderby');
		$portfolio_order = of_get_option('portfolio_order');
		$portfolio_posts = of_get_option('portfolio_posts');
		$portfolio_categories = of_get_option('portfolio_categories');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[portfolio_posts columns="'.$sh_columns.'" title="'.$portfolio_title.'" carousel_mode="'.$portfolio_carousel.'" limit="'.$portfolio_posts.'" cats="'.$portfolio_categories.'" orderby="'.$portfolio_orderby.'" order="'.$portfolio_order.'" slideshow="'.$portfolio_carousel_autoplay.'"]');
		
        break;
		//End portfolio area
		
		//Testimonials area
		case 'testimonials':

		$testimonials_title = of_get_option('testimonials_title');
		$testimonials_carousel = of_get_option('testimonials_carousel');
		$testimonials_carousel_autoplay = of_get_option('testimonials_carousel_autoplay');
		$testimonials_orderby = of_get_option('testimonials_orderby');
		$testimonials_order = of_get_option('testimonials_order');
		$testimonials_posts = of_get_option('testimonials_posts');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[testimonials_posts columns="'.$sh_columns.'" title="'.$testimonials_title.'" limit="'.$testimonials_posts.'" orderby="'.$testimonials_orderby.'" order="'.$testimonials_order.'" carousel_mode="'.$testimonials_carousel.'" slideshow="'.$testimonials_carousel_autoplay.'"]');
		
        break;
		//End testimonials area
		
		//Sponsors area
		case 'sponsors':

		$sponsors_title = of_get_option('sponsors_title');
		$sponsors_carousel = of_get_option('sponsors_carousel');
		$sponsors_carousel_autoplay = of_get_option('sponsors_carousel_autoplay');
		$sponsors_orderby = of_get_option('sponsors_orderby');
		$sponsors_order = of_get_option('sponsors_order');
		$sponsors_posts = of_get_option('sponsors_posts');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[sponsors_posts columns="'.$sh_columns.'" title="'.$sponsors_title.'" limit="'.$sponsors_posts.'" orderby="'.$sponsors_orderby.'" order="'.$sponsors_order.' carousel_mode="'.$sponsors_carousel.'" slideshow="'.$sponsors_carousel_autoplay.'"]');
		
        break;
		//End sponsors area
		
		//Team area		
		case 'team':

		$team_title = of_get_option('team_title');
		$team_carousel = of_get_option('team_carousel');
		$team_carousel_autoplay = of_get_option('team_carousel_autoplay');
		$team_orderby = of_get_option('team_orderby');
		$team_order = of_get_option('team_order');
		$team_posts = of_get_option('team_posts');
		echo '<div class="hr-bullet"></div>';
        echo do_shortcode('[team_posts columns="'.$sh_columns.'" title="'.$team_title.'" limit="'.$team_posts.'" orderby="'.$team_orderby.'" order="'.$team_order.'" carousel_mode="'.$team_carousel.'" slideshow="'.$team_carousel_autoplay.'"]');
		
        break;
		//End team area

    }
}
endif;
?>

</div><!-- /#homepage -->

<?php 
st_after_content();
if ($homepage_layout == 'with_sidebar') get_sidebar("homepage");
?>

</div><!--Close container-->

<?php get_footer(); ?>