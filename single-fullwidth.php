<?php
/**
 * The main template file for display single post page with sidebar.
 *
 * @package WordPress
*/

get_header(); 

//Get post's featured content type
$post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
?>
<input type="hidden" id="post_carousel_column" name="post_carousel_column" value="5"/>
<div class="single_post_ft_wrapper <?php if($post_ft_type=='Gallery') { ?>gallery_ft<?php } ?> fade-in animated3">
	<?php
	    $pp_blog_single_ft_content = get_option('pp_blog_single_ft_content');
	    
	    if(!empty($pp_blog_single_ft_content) && $post_type != 'reviews')
	    {
	    	switch($post_ft_type)
	    	{
	    		case 'Image':
	    		default:
	    			if(has_post_thumbnail(get_the_ID(), 'blog_single_ft'))
	    			{
	    			    $image_id = get_post_thumbnail_id(get_the_ID());
	    			    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_single_ft', true);
	    			}
	    	
	    	        if(isset($image_thumb[0]) && !empty($image_thumb[0]))
	    	        {
	?>
	    		    <div class="post_img single">
	    		        <img src="<?php echo $image_thumb[0]; ?>" alt="" class="home_category_ft"/>
	    		    </div>
	<?php
	    			}
	    		break;
	    		
	    		case 'Gallery':
	    			
	    			if(has_post_thumbnail(get_the_ID(), 'blog_ft'))
	    			{
	    			    $image_id = get_post_thumbnail_id(get_the_ID());
	    			    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_ft', true);
	    			}
	    	
	    			$post_ft_gallery = get_post_meta($post->ID, 'post_ft_gallery', true);
	    			
	    			if(!empty($post_ft_gallery))
	    			{
	    				//Run flow gallery data
						wp_enqueue_script("script-flow-gallery", get_stylesheet_directory_uri()."/templates/script-flow-gallery.php?gallery_id=".$post_ft_gallery, false, THEMEVERSION, true);
	?>
	    				<div class="post_ft_gallery_wrapper gallery_ft">
							<div id="imageFlow" lcass="single_post">
								<div class="text">
									<div class="title"><img src="<?php echo get_template_directory_uri(); ?>/images/loading.gif" alt=""/></div>
									<div class="legend"></div>
								</div>
							</div>
	    				</div>
	<?php
	    			}
	    		break;
	    		
	    		case 'Vimeo Video':
	    			$post_ft_vimeo = get_post_meta($post->ID, 'post_ft_vimeo', true);
	?>
				<div class="video_wrapper">
	    			<iframe src="//player.vimeo.com/video/<?php echo $post_ft_vimeo; ?>?title=0&amp;byline=0&amp;portrait=0" width="960" height="539" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
				</div>
	<?php
	    		break;
	    		
	    		case 'Youtube Video':
	    			$post_ft_youtube = get_post_meta($post->ID, 'post_ft_youtube', true);
	?>
				<div class="video_wrapper">
	    			<iframe width="960" height="540" src="//www.youtube.com/embed/<?php echo $post_ft_youtube; ?>?wmode=transparent" frameborder="0" allowfullscreen wmode="Opaque"></iframe>
				</div>
	<?php
	    		break;
	    		
	    		case 'Sound Cloud Audio':
	    			
	    			$post_ft_sound_cloud = get_post_meta($post->ID, 'post_ft_sound_cloud', true); 
	    			
	    			if(!empty($post_ft_sound_cloud))
	    			{
	    				echo '<div class="post_sound_cloud_wrapper">'.$post_ft_sound_cloud.'</div>';
	    			}
	    		break;
	    		
	    		case 'Self-Hosted Audio':
	    			
	    			if(has_post_thumbnail(get_the_ID(), 'blog_single_ft'))
	    			{
	    			    $image_id = get_post_thumbnail_id(get_the_ID());
	    			    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_single_ft', true);
	    			}
	    	
	    	        
	    			$post_ft_audio = get_post_meta($post->ID, 'post_ft_audio', true); 
	    			
	    			if(!empty($post_ft_audio))
	    			{
	    				echo '<div class="post_audio_wrapper"><audio id="single_post_audio" src="'.$post_ft_audio.'" type="audio/mp3" controls="controls" width="960"></audio></div>';
	    			}
	    		break;
	    		
	    		case 'Self-Hosted Video':
	    			$post_ft_video = get_post_meta($post->ID, 'post_ft_video', true);
	    			
	    			if(!empty($post_ft_video))
	    			{
	    				if(has_post_thumbnail(get_the_ID(), 'blog_ft'))
	    				{
	    				    $image_id = get_post_thumbnail_id(get_the_ID());
	    				    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_ft', true);
	    				}
	    				
	    				echo '<div class="post_audio_wrapper">';
	    				echo do_shortcode('[video width="960" height="540" img_src="'.$image_thumb[0].'" video_src="'.$post_ft_video.'"]');
	    				echo '</div>';
	    			}
	    		break;
	    	}
	    } //End if enable featured content
	?>
	<div id="page_caption" class="single_post fade-in animated2">
		<div class="boxed_wrapper">
			<div class="sub_page_caption">
				<h2><?php the_title(); ?></h2>
				<?php
				$author_id=$post->post_author;
				?>
				<h4><a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo get_the_author_meta('display_name' , $author_id); ?></a></h4>
				<?php
		    		$post_categories = wp_get_post_categories(get_the_ID());
		    		
		    		foreach($post_categories as $c)
		    		{
						$cat = get_category( $c );
				?>
					<a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->name; ?></a> /
				<?php
					}
		    	?> <?php echo get_the_time(THEMEDATEFORMAT); ?>
		    </div>
		</div>
	</div>
</div>
<!-- Begin content -->
<div id="content_wrapper">
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner_wrapper fullwidth">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<!-- Begin each blog post -->
						<div class="post_wrapper" style="padding-top:0;">
							<div class="post_inner_wrapper">
						    	<div class="post_wrapper_inner">
									<div class="post_inner_wrapper">
								        
										<?php the_content(); ?>
										
										<?php
											//Get Post's Tags
											$pp_blog_tags = get_option('pp_blog_tags');
											
											if(!empty($pp_blog_tags))
											{
												$post_tags = wp_get_post_tags(get_the_ID());
												
												if(!empty($post_tags))
												{
										?>
													<br/><strong><?php _e( 'Tags:', THEMEDOMAIN ); ?>&nbsp;</strong>
										<?php
													foreach($post_tags as $post_tags)
													{
										?>
														<a class="meta-tags" href="<?php echo get_tag_link($post_tags->term_id); ?>"><?php echo $post_tags->name; ?></a>
										<?php
													}
												}
											}
										?>
										
										<br class="clear"/><br/>
										<?php
											//Get Social Share
											get_template_part("/templates/template-addthis");
										?>
										
									</div>
									
								</div>
								<!-- End each blog post -->
						</div>
						
						<?php
							$args = array(
								'before'           => '<p>' . __('Pages:'),
								'after'            => '</p>',
								'link_before'      => '',
								'link_after'       => '',
								'next_or_number'   => 'number',
								'nextpagelink'     => __('Next page'),
								'previouspagelink' => __('Previous page'),
								'pagelink'         => '%',
								'echo'             => 1
							);
							wp_link_pages($args);
						
						    $pp_blog_next_prev = get_option('pp_blog_next_prev');
						    
						    if($pp_blog_next_prev)
						    {
						
						    	//Get Previous and Next Post
						    	$prev_post = get_previous_post();
						    	$next_post = get_next_post();
						    
						    	//If has previous or next post then add line break
						    	if(!empty($prev_post) OR !empty($next_post))
						    	{
						    		echo '<br class="clear"/><hr class="thick"/><br class="clear"/>';
						    	}
						?>
						    
						    <?php
						    	//Get Previous Post
						    	if (!empty($prev_post)): 
						    ?>
						    	  	<div class="post_previous">
						    	  		<span class="post_previous_icon"></span>
						    	  		<div class="post_previous_content">
						    	  			<h6><?php echo _e( 'Previous Post', THEMEDOMAIN ); ?></h6>
						    	  			<a href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo $prev_post->post_title; ?></a>
						    	  		</div>
						    	  	</div>
						    <?php endif; ?>
						    
						    <?php
						    	//Get Next Post
						    	if (!empty($next_post)): 
						    ?>
						    	  	<div class="post_next">
						    	  		<span class="post_next_icon"></span>
						    	  		<div class="post_next_content">
						    	  			<h6><?php echo _e( 'Next Post', THEMEDOMAIN ); ?></h6>
						    	  			<a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo $next_post->post_title; ?></a>
						    	  		</div>
						    	  	</div>
						    <?php endif; ?>
						
						<?php
						    	//If has previous or next post then add line break
						    	if(!empty($prev_post) OR !empty($next_post))
						    	{
						    		echo '<br class="clear"/><br class="clear"/><br class="clear"/>';
						    	}
						    
						    }
						?>

						<div class="post_wrapper" style="padding-top:0">
							<div class="post_wrapper_inner">
								<?php
									$pp_blog_display_author = get_option('pp_blog_display_author');
									
									if($pp_blog_display_author)
									{
								?>
								
								<div class="post_wrapper author">
									<div class="author_wrapper_inner">
										<div id="about_the_author">
											<div class="gravatar"><?php echo get_avatar( get_the_author_meta('email'), '80' ); ?></div>
											<div class="description">
												<h5 class="author_name"><?php the_author_meta('first_name', get_the_author_meta('ID')); ?> <?php the_author_meta('last_name', get_the_author_meta('ID')); ?></h5>
												<?php the_author_meta('description'); ?>
											</div>
										</div><br class="clear"/><br/>
									</div>
								</div>
								<br class="clear"/>
								
								<?php
									}
								?>
								
								<?php
									$pp_blog_display_related = get_option('pp_blog_display_related');
									
									if($pp_blog_display_related)
									{
								?>
								
								<?php
								//for use in the loop, list 9 post titles related to post's tags on current post
								$tags = wp_get_post_tags($post->ID);

								if ($tags) {
								
									$tag_in = array();
								  	//Get all tags
								  	foreach($tags as $tags)
								  	{
									  	$tag_in[] = $tags->term_id;
								  	}

								  	$args=array(
									  	  'tag__in' => $tag_in,
									  	  'post__not_in' => array($post->ID),
									  	  'showposts' => 9,
									  	  'ignore_sticky_posts' => 1,
									  	  'orderby' => 'date',
									  	  'order' => 'DESC'
								  	 );
								  	$my_query = new WP_Query($args);
								  	
								  	if( $my_query->have_posts() ) {
								  	  	echo '<br class="clear"/><h5 class="header_line subtitle"><span>'.__( 'You might also like', THEMEDOMAIN ).'</span></h5><br class="clear"/>';
								 ?>
								  
								 	<div class="flexslider post_carousel">
								 		<ul class="slides">
								  
										 <?php
										 	global $have_related;
										    while ($my_query->have_posts()) : $my_query->the_post();
										    $have_related = TRUE; 
										 ?>
										    <li>
										    	<?php
										    		if(has_post_thumbnail($post->ID, 'related_post'))
													{
														$image_id = get_post_thumbnail_id($post->ID);
														$image_url = wp_get_attachment_image_src($image_id, 'related_post', true);
										    	?>
										    		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><img class="carousel_thumb" src="<?php echo $image_url[0]; ?>" alt="<?php the_title(); ?>"/></a>
										    	<?php
										    		}
										    	?>
										    	<h7><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h7>
										    	<span class="post_attribute"><?php echo date(THEMEDATEFORMAT, strtotime($post->post_date)); ?></span>
											</li>
										  <?php
												endwhile;
												    
												wp_reset_query();
										  ?>
									  
								  		</ul>
								    </div>
								    <br class="clear"/><br/>
								<?php
								  	}
								}
								?>
								
								<?php
									} //end if show related
								?>
		
								<br class="clear"/>
								<?php comments_template( '' ); ?>
								<?php comment_form(); ?>
								<br class="clear"/>
								
								<?php wp_link_pages(); endwhile; endif; ?>
							</div>
					</div>
				</div>
					
				</div>
				<!-- End main content -->
				
				<br class="clear"/>
			</div>
			
			<div class="bottom"></div>
			
		</div>
		<!-- End content -->

		<?php
			//Get More Story Module
			$pp_blog_more_story = get_option('pp_blog_more_story');
			
			if(!empty($prev_post) && !empty($pp_blog_more_story))
			{
				$post_more_image = '';
				if(has_post_thumbnail(get_the_ID(), 'blog_half_ft'))
				{
				    $post_more_image_id = get_post_thumbnail_id($prev_post->ID);
				    $post_more_image = wp_get_attachment_image_src($post_more_image_id, 'blog_half_ft', true);
				}
		?>
		<div id="post_more_wrapper" class="hiding">
			<a href="javascript:;" id="post_more_close"><img src="<?php echo get_template_directory_uri(); ?>/images/popup_close.png" alt=""/></a>
			<h5 class="header_line subtitle"><span><?php _e( 'More Story', THEMEDOMAIN ); ?></span></h5>
			<?php
				if(!empty($post_more_image))
				{
			?>
			<div class="post_more_img_wrapper">
				<a href="<?php echo get_permalink($prev_post->ID); ?>">
					<img src="<?php echo $post_more_image[0]; ?>" alt=""/>
				</a>
			</div>
			<?php
				}
			?>
			<a class="post_more_title" href="<?php echo get_permalink($prev_post->ID); ?>">
				<h6 style="margin-top:-5px"><?php echo $prev_post->post_title; ?></h6>
			</a>
			<?php echo pp_substr(strip_tags(strip_shortcodes($prev_post->post_content)), 120); ?>
		</div>
		<?php
			}
		?>

<?php get_footer(); ?>