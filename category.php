<?php
/**
 * The main template file for display category page.
 *
 * @package WordPress
*/

get_header(); 
?>
<div id="page_caption" class="fade-in animated3">
	<div class="boxed_wrapper">
		<div class="sub_page_caption"><?php echo dimox_breadcrumbs(); ?></div>
	</div>
</div>
<div id="content_wrapper">
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner_wrapper">
    		<div class="sidebar_content fade-in animated4">
    			<h2>
					<?php
						printf( __( ' %s', THEMEDOMAIN ), '' . single_cat_title( '', false ) . '' );
					?>
				</h2>
		    	<?php
		    		$pp_category_layout = get_option('pp_category_layout');
		    	
		    		//Get 1 column blog style layout
		    		if(file_exists(get_template_directory() . "/templates/template-blog-".$pp_category_layout.".php"))
		    		{
			    		get_template_part ("templates/template", "blog-".$pp_category_layout);
		    		}
		    		else
		    		{
						get_template_part ("templates/template", "blog-2");
					}
					get_template_part ("templates/template", "pagination");
		    	?>
		    	</div>
		    	<div class="sidebar_wrapper fade-in animated4">
		    		<div class="sidebar">
		    			<div class="content">
		    				<ul class="sidebar_widget">
		    					<?php dynamic_sidebar('Category Sidebar'); ?>
		    				</ul>
		    			</div>
		    		</div>
		    		<br class="clear"/>
		    	</div>
				<br class="clear"/>
			</div>
			<!-- End main content -->
		</div>
	</div>
    </div>
</div>
<?php get_footer(); ?>