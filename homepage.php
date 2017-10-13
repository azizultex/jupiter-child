<?php
/**
 * Template Name: Homepage
 *
 * @package WordPress
*/


get_header();


?>


<!-- Begin content -->
<div id="content_wrapper">
    <div class="inner fade-in animated4">
    	<!-- Begin main content -->
    	<div class="inner_wrapper fullwidth">
    		<?php 
    			if ( have_posts() ) {
    		    while ( have_posts() ) : the_post(); ?>		
    	
    		    <?php the_content();   ?>

    			<?php endwhile; 
	    	    }
    		?>
    	</div>
    	<!-- End main content -->
    </div> 
</div>
<!-- End content -->
<?php get_footer(); ?>