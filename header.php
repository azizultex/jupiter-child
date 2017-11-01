<?php
/**
 * The Header for the template.
 *
 * @package WordPress
 */


if(session_id() == '') 
{
	//session_start();
}

if ( ! isset( $content_width ) ) $content_width = 960;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<title><?php wp_title('&lsaquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php
	/**
	*	Get favicon URL
	**/
	$pp_favicon = get_option('pp_favicon');
	
	if(!empty($pp_favicon))
	{
?>
		<link rel="shortcut icon" href="<?php echo $pp_favicon; ?>" />
<?php
	}
?>

<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
<script src="https://use.fontawesome.com/eba2620a49.js"></script>
</head>

<body <?php body_class(); ?>>
	<?php
		$pp_ajax_search = get_option('pp_ajax_search');
	?>
	<input type="hidden" id="pp_ajax_search" name="pp_ajax_search" value="<?php echo $pp_ajax_search; ?>"/>
	<input type="hidden" id="pp_homepage_url" name="pp_homepage_url" value="<?php echo home_url(); ?>"/>
	<?php
		//Check footer sidebar columns
		$pp_slider_auto = get_option('pp_slider_auto');
	?>
	<input type="hidden" id="pp_slider_auto" name="pp_slider_auto" value="<?php echo $pp_slider_auto; ?>"/>
	<?php
		//Check footer sidebar columns
		$pp_slider_timer = get_option('pp_slider_timer');
	?>
	<input type="hidden" id="pp_slider_timer" name="pp_slider_timer" value="<?php echo $pp_slider_timer; ?>"/>
	
	<!-- Begin mobile menu -->
	<div class="mobile_menu_wrapper">
	    <?php 	
	    	if ( has_nav_menu( 'main-menu' ) ) 
	    	{
	    		//Get page nav
	    		wp_nav_menu( 
	    		    	array( 
	    		    		'menu_id'			=> 'mobile_main_menu',
	    		    		'menu_class'		=> 'mobile_main_nav',
	    		    		'theme_location' 	=> 'main-menu',
	    		    	) 
	    		); 
	    	}
	    	
	    	if ( has_nav_menu( 'second-menu' ) ) 
	    	{
	    	    //Get page nav
	    	    wp_nav_menu( 
	    	        	array( 
	    	        		'menu_id'			=> 'mobile_second_menu',
	    	        		'menu_class'		=> 'mobile_main_nav',
	    	        		'theme_location' 	=> 'second-menu',
	    	        	) 
	    	    ); 
	    	}
	    ?>
	</div>
	<!-- End mobile menu -->
	
	<!-- Begin template wrapper -->
	<div id="wrapper">
	
		<!-- Begin header -->
		<div id="header_wrapper">
			<div class="standard_wrapper">
				<div id="mobile_nav_icon"></div>
				<?php 	
				if ( has_nav_menu( 'main-menu' ) ) 
				{
					//Get page nav
					wp_nav_menu( 
					    	array( 
					    		'menu_id'			=> 'main_menu',
					    		'menu_class'		=> 'main_nav',
					    		'theme_location' 	=> 'main-menu',
					    	) 
					); 
				}
				else
				   {
				    		echo '<div class="mainmenu notice">Please setup "Main Menu" using Wordpress Dashboard > Appearance > Menus</div>';
				   }
				?>
				<div id="menu_border_wrapper"></div>
				<form role="search" method="get" name="searchform" id="searchform" action="<?php echo home_url(); ?>/">
					<div>
						<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" autocomplete="off" title="<?php _e( 'Search...', THEMEDOMAIN ); ?>"/>
						<button type="submit">
					    	<img src="<?php echo get_template_directory_uri(); ?>/images/search_form_icon.png" alt=""/>
					    </button>
					</div>
				    <div id="autocomplete"></div>
				</form>
				<?php
					get_template_part("/templates/template-socials");
				?>
			</div>
		</div>
		<!-- End header -->
		
		<div class="header_ads fade-in animated1">
		    <?php
		        $pp_top_banner = get_option('pp_top_banner');
	
		        if(!empty($pp_top_banner))
		        {
		        	echo stripslashes($pp_top_banner);
		        }
		    ?>
		</div>
		
		<div id="boxed_wrapper">
			<div class="logo fade-in animated1">
				<!-- Begin logo -->	
				<?php
					//get custom logo
					$pp_logo = get_option('pp_logo');
					$pp_retina_logo = get_option('pp_retina_logo');
								
					if(empty($pp_logo) && empty($pp_retina_logo))
					{
						$pp_retina_logo = get_template_directory_uri().'/images/logo@2x.png';
					}
					
					if(!empty($pp_retina_logo))
					{
						//Get image width and height
						list($logo_width, $logo_height, $logo_type, $logo_attr) = getimagesize($pp_retina_logo);
						
						$logo_retina_width = $logo_width/2;
						$logo_retina_height = $logo_height/2;
				?>		
					<a id="custom_logo" class="logo_wrapper" href="<?php echo home_url(); ?>">
						<img src="<?php echo $pp_retina_logo?>" alt="" width="<?php echo $logo_retina_width; ?>" height="<?php echo $logo_retina_height; ?>"/>
					</a>
				<?php
					}
					else //if not retina logo
					{
				?>
					<a id="custom_logo" class="logo_wrapper" href="<?php echo home_url(); ?>">
						<img src="<?php echo $pp_logo?>" alt=""/>
					</a>
				<?php
					}
				?>
				<!-- End logo -->
			</div>
			
			<?php 	
			if ( has_nav_menu( 'second-menu' ) ) 
			{
			    //Get page nav
			    wp_nav_menu( 
			        	array( 
			        		'menu_id'			=> 'second_menu',
			        		'menu_class'		=> 'second_nav fade-in animated1',
			        		'theme_location' 	=> 'second-menu',
			        		'walker' 			=> new tg_walker(),
			        	) 
			    ); 
			}
			else
			   {
			    		echo '<div class="secondmenu notice">Please setup "Secondary Menu" using Wordpress Dashboard > Appearance > Menus</div>';
			   }
			?>
		</div>