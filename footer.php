<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 */
?>

	<?php
	    $pp_footer_banner = get_option('pp_footer_banner');
	
	    if(!empty($pp_footer_banner))
	    {
	?>
	    <div class="footer_ads">
	<?php
	    	echo stripslashes($pp_footer_banner);
	?>
	    </div>
	<?php
	    }
	?>

	<!-- Modal -->
	<div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <!-- <h4 class="modal-title" id="myModalLabel">Modal title</h4> -->
	      </div>
	      <div class="modal-body">
	        <?php echo do_shortcode( '[mc4wp_form id="10222"]' ); ?>
	      </div>
	      <div class="modal-footer">
	        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary">Save changes</button> -->
	      </div>
	    </div>
	  </div>
	</div>

    <!-- Begin footer -->
    <div class="footer_wrapper">
    <?php
    	$pp_footer_display_sidebar = get_option('pp_footer_display_sidebar');
	
	    if(!empty($pp_footer_display_sidebar))
	    {
	?>
	    <div id="footer">
	    	<ul class="sidebar_widget">
	    		<?php dynamic_sidebar('Footer Sidebar'); ?>
	    	</ul>
	    	
	    	<br class="clear"/><br/><br/>
	    
	    </div>
	<?php
		}
	?>
    
    <div id="copyright">
    	<div class="standard_wrapper wide">
    		<div id="copyright_left">


    	    <?php
    	    	/**
    	    	 * Get footer text
    	    	 */
    
    	    	$pp_footer_text = get_option('pp_footer_text');
    
    	    	if(empty($pp_footer_text))
    	    	{
    	    		$pp_footer_text = 'Copyright
					<script language="JavaScript" type="text/javascript">
					    now = new Date
					    theYear=now.getYear()
					    if (theYear < 1900)
					    theYear=theYear+1900
					    document.write(theYear)
					</script>
					Sapna Magazine.';
    	    	}
    	    	
    	    	echo stripslashes(html_entity_decode($pp_footer_text));
    	    ?>
    		</div>
    		<a id="toTop"><?php _e( 'Back to top', THEMEDOMAIN ); ?></a>
    	</div>
    </div>
    
    </div>
    <!-- End footer -->

</div>
<!-- End template wrapper -->

<?php
		/**
    	*	Setup Google Analyric Code
    	**/
    	get_template_part ("google-analytic");
?>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
