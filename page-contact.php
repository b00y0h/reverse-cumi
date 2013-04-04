<?php
/**
 * Template Name: Contact page
 */
?>

<?php 
$contact_page_email = rwmb_meta( 'gg_contact_page_email' );
$contact_page_success = rwmb_meta( 'gg_contact_page_success_msg' );
$contact_page_error = rwmb_meta( 'gg_contact_page_error_msg' );

$contact_map = rwmb_meta( 'gg_contact_map' );
$contact_map_latitude = rwmb_meta( 'gg_contact_map_latitude' );
$contact_map_longitude = rwmb_meta( 'gg_contact_map_longitude' );
$contact_zoom = rwmb_meta( 'gg_contact_zoom' );
$contact_map_infowindow = rwmb_meta( 'gg_contact_map_infowindow' );
$contact_map_infowindow_title = rwmb_meta( 'gg_contact_map_infowindow_title' );

$commentError ='';
$emailError ='';
$nameError ='';
//If the form is submitted
if(isset($_POST['submitted'])) {

	//Check to see if the honeypot captcha field was filled in
	if(trim($_POST['checking']) !== '') {
		$captchaError = true;
	} else {
	
		//Check to make sure that the name field is not empty
		if(trim($_POST['contactName']) === '') {
			$nameError = 'You forgot to enter your name.';
			$hasError = true;
		} else {
			$name = trim($_POST['contactName']);
		}
		
		//Check to make sure sure that a valid email address is submitted
		if(trim($_POST['email']) === '')  {
			$emailError = 'You forgot to enter your email address.';
			$hasError = true;
		} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
			$emailError = 'You entered an invalid email address.';
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}
			
		//Check to make sure comments were entered	
		if(trim($_POST['comments']) === '') {
			$commentError = 'You forgot to enter your comments.';
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}
			
		//If there is no error, send the email
		if(!isset($hasError)) {
			$emailTo = $contact_page_email;
			if (!isset($emailTo) || ($emailTo == '') ){
				$emailTo = get_option('admin_email');
			}
			$subject = 'From '.$name;
			$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
			$headers = 'From: My Site <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			
			wp_mail($emailTo, $subject, $body, $headers);
			$emailSent = true;

		}
	}
} ?>

<?php get_header();
//Retrieve and verify sidebars 
$contact_sidebar = rwmb_meta('gg_contact-widget-area');
$footer_sidebar_1 = rwmb_meta('gg_first-footer-widget-area');
$footer_sidebar_2 = rwmb_meta('gg_second-footer-widget-area');
$footer_sidebar_3 = rwmb_meta('gg_third-footer-widget-area');
$footer_sidebar_4 = rwmb_meta('gg_fourth-footer-widget-area');
$sidebar_list = of_get_option('sidebar_list');
if ($sidebar_list) : $sidebar_footer1_exists = in_array_r($footer_sidebar_1, $sidebar_list); else : $sidebar_footer1_exists = false; endif;
if ($sidebar_list) : $sidebar_footer2_exists = in_array_r($footer_sidebar_2, $sidebar_list); else : $sidebar_footer2_exists = false; endif;
if ($sidebar_list) : $sidebar_footer3_exists = in_array_r($footer_sidebar_3, $sidebar_list); else : $sidebar_footer3_exists = false; endif;
if ($sidebar_list) : $sidebar_footer4_exists = in_array_r($footer_sidebar_4, $sidebar_list); else : $sidebar_footer4_exists = false; endif;
if ($sidebar_list) : $contact_sidebar_exists = in_array_r($contact_sidebar, $sidebar_list); else : $contact_sidebar_exists = false; endif;
?>

<?php if ($contact_map) { ?>
<script type="text/javascript">
  var map;
  var image = '<?php echo get_template_directory_uri(); ?>/images/map-marker.png';
  var $j = jQuery.noConflict();
  
  $j(document).ready(function(){
	map = new GMaps({
	  div: '#map',
	  zoom: <?php echo $contact_zoom; ?>,
	  lat: <?php echo $contact_map_latitude; ?>,
	  lng: <?php echo $contact_map_longitude; ?>
	});
	
	<?php if ($contact_map_infowindow) { ?>
	map.addMarker({
	  lat: map.getCenter().lat(),
      lng: map.getCenter().lng(),
	  title:'<?php echo $contact_map_infowindow_title; ?>',
	  <?php $contact_map_infowindow = str_replace(array("\r\n", "\r", "\n"), "", $contact_map_infowindow); ?>
	  infoWindow: {content:'<?php echo html_entity_decode($contact_map_infowindow); ?>'},
	  icon: image
	  });
	<?php } ?>  
	
  });
</script>

<div class="contact-map-wrapper">
    <div class="contact-map">
        <div class="slideshow-top-shadow"></div>
        <div id="map"></div>
    </div>
</div>

<?php } ?>

<script type="text/javascript">
var $j = jQuery.noConflict();
$j(document).ready(function(){
	$j("#contactForm").validate();
});
</script>

<div class="clear"></div>

<div class="container">

<?php 
st_before_content($columns=''); 
if (rwmb_meta('gg_page_breadcrumbs')){ if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();}
if (rwmb_meta('gg_page_title')){ echo '<h1 class="entry-title">'.get_the_title().'</h1>'; }  
get_template_part( 'loop', 'page' );
?>

<?php if(isset($emailSent) && $emailSent == true) { ?>
	<div class="thanks">
		<h3>Thank you, <?php echo $name;?> !</h3>
		<p><?php echo $contact_page_success;?></p>
	</div>
<?php } ?>
	
<?php if(isset($hasError) || isset($captchaError)) { ?>
    <p class="error"><?php echo $contact_page_error;?></p>
<?php } ?>
		
<form action="<?php the_permalink(); ?>" id="contactForm" method="post">
    <ul class="contact-form <?php if(isset($emailSent) && $emailSent == true) { ?> form-finished <?php } ?>">
        <li>
            <label for="contactName">Name</label>
            <input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="required" />
        </li>    
        <li>    
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="required email" />
        </li>
        
        <li class="textarea"><label for="commentsText">Comments</label>
            <textarea name="comments" id="commentsText" rows="20" cols="30" class="required"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
        </li>
        
        <li class="screenReader"><label for="checking" class="screenReader">If you want to submit this form, do not enter anything in this field</label><input type="text" name="checking" id="checking" class="screenReader" value="<?php if(isset($_POST['checking']))  echo $_POST['checking'];?>" /></li>
        <li class="buttons"><input type="hidden" name="submitted" id="submitted" value="true" /><button type="submit">Send email</button></li>
    </ul>
</form>
	
<?php st_after_content(); get_sidebar("contact"); ?>

</div><!--Close container-->

<?php get_footer(); ?>