<?php
/*
Element Description: Category Blog
*/

// Element Class 
class vcCategoryBlog extends WPBakeryShortCode {
     
    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'vc_category_blog_mapping' ) );
        add_shortcode( 'vc_category_blog', array( $this, 'vc_category_blog_html' ) );
    }
     
    // Element Mapping
	public function vc_category_blog_mapping() {
	         
	    // Stop all if VC is not enabled
	    if ( !defined( 'WPB_VC_VERSION' ) ) {
	            return;
	    }

	    $cat_list = array();
	    $cats = get_categories();
	    foreach ($cats as $cat) {
	    	$cat_list[$cat->name] = $cat->slug;
	    }
	         
	    // Map the block with vc_map()
	    vc_map( 
	  
	        array(
	            'name' => __('Category Blog', 'jupiter-child'),
	            'base' => 'vc_category_blog',
	            'description' => __('Add Category Posts', 'jupiter-child'), 
	            'category' => __('Jupiter Element', 'jupiter-child'),   
	            'icon' => 'icon-wpb-application-icon-large',            
	            'params' => array(
	            		array(
	                    'type' => 'textfield',
	                    'heading' => __( 'Title', 'jupiter-child' ),
	                    'param_name' => 'title',
	                    'admin_label' => false,
	                    'weight' => 0,
	                    'group' => 'Content',
	                ),  

	                array(
	                    'type' => 'dropdown',
	                    'heading' => __( 'Select Post Category', 'jupiter-child' ),
	                    'param_name' => 'category',
	                    'value' => $cat_list,
	                    'admin_label' => false,
	                    'weight' => 0,
	                    'group' => 'Content',
	                ),  

	                  
	                array(
	                    'type' => 'textfield',
	                    'heading' => __( 'Items', 'jupiter-child' ),
	                    'param_name' => 'items',
	                    'value' => 9,
	                    'description' => __( 'Add how much post want to display', 'jupiter-child' ),
	                    'admin_label' => false,
	                    'weight' => 0,
	                    'group' => 'Content',
	                ),                 
	                     
	            )
	        )
	    );                                
	        
	}
     
     
	// Element HTML
	public function vc_category_blog_html( $atts ) {

		remove_filter('the_content', 'pp_formatter', 99);

		//extract short code attr
		extract(shortcode_atts(array(
			'size' => 'one',
			'title' => '',
			'items' => 9,
			'category' => '',
		), $atts));
		
		
		//Get current page template
		$current_page_template = basename(get_page_template());

		//Get category posts
		$args = array(
		    'numberposts' => $items,
		    'order' => 'DESC',
		    'orderby' => 'date',
		    'post_type' => array('post'),
		);
		
		if(!empty($category))
		{
			$args['category'] = $category;
		}

		$posts_arr = get_posts($args);
		$return_html = '';
		$return_html.= '<div class="'.$size.'">';

		if(!empty($posts_arr))
		{	
			if(!empty($title))
			{
				$return_html.= '<div class="ppb_header ';
				
				if($current_page_template != 'page_sidebar.php')
				{
					$return_html.= 'fullwidth';
				}
				
				$return_html.= '"><h5 class="header_line ';
				
				if($current_page_template != 'page_sidebar.php')
				{
					$return_html.= 'post_fullwidth';
				}
				
				$return_html.= '"><span>'.$title.'</span></h5></div>';
			}
			
			$image_thumb = '';
			
			//Get first post detail
			if(has_post_thumbnail($posts_arr[0]->ID, 'blog_cat_ft'))
			{
			    $image_id = get_post_thumbnail_id($posts_arr[0]->ID);
			    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_cat_ft', true);
			}
			
			//Check page template
			if($current_page_template == 'page_sidebar.php')
			{
				$return_html.= '<div class="one_half">';
			}
			else
			{
				$return_html.= '<div class="one_half">';
			}
		    
		    //Display first post
		    if(!empty($image_thumb))
		    {
		        $return_html.= '<div class="post_img ';
		        
		        if($current_page_template == 'page_sidebar.php')
				{
					$return_html.= 'ppb_cat_sidebar';
				}
				else
				{
					$return_html.= 'ppb_cat_fullwidth';
				}
		        
		        $return_html.= ' entry_img" style="margin-top:0;';
		        
		        $return_html.= '">';
		        $return_html.= '<a href="'.get_permalink($posts_arr[0]->ID).'" title="'.$posts_arr[0]->post_title.'">';
		        $return_html.= '<img src="'.$image_thumb[0].'" alt="" class="home_category_ft" ';
		        $return_html.= '/>';
		        $return_html.= '</a>';
				
				//Get post type
			    $post_ft_type = get_post_meta($posts_arr[0]->ID, 'post_ft_type', true);
				
				//Get Post review score
				$post_review_score = get_review_score($posts_arr[0]->ID);
				
				if(!empty($post_review_score))
				{
					$return_html.= '<div class="review_score_bg">'.$post_review_score.'<div class="review_point">'.__( 'Points', THEMEDOMAIN ).'</div></div>';
				}
				elseif(!empty($post_ft_type))
					{
						switch($post_ft_type)
					    {
					    	case 'Gallery':
					    		$return_html.= '<div class="post_type_bg"><img src="'.get_template_directory_uri().'/images/icon_gallery.png" alt="" style="width:38px;height:38px;"/></div>';
					    	break;
					    	
					    	case 'Vimeo Video':
					    	case 'Youtube Video':
					    	case 'Sound Cloud Audio':
					    	case 'Self-Hosted Audio':
					    	case 'Self-Hosted Video':
					    		$return_html.= '<div class="post_type_bg"><img src="'.get_template_directory_uri().'/images/icon_play.png" alt="" style="width:38px;height:38px;"/></div>';
					    	break;
					    }
					}
				
		        $return_html.= '</div>';
		    }

		    $return_html.= '<h5 class="ppb_classic_title">';
		    $return_html.= '<a href="'.get_permalink($posts_arr[0]->ID).'" title="'.$posts_arr[0]->post_title.'">'.$posts_arr[0]->post_title.'</a></h5>';
		    $return_html.= '<p>'.pp_substr(strip_tags(strip_shortcodes($posts_arr[0]->post_content)), 160).'</p>';
		    $return_html.= '<div class="post_detail space half">';
		    
		    if(comments_open($posts_arr[0]->ID))
			{
				$return_html.= '<a href="'.get_permalink($posts_arr[0]->ID).'" title="'.$posts_arr[0]->post_title.'">'.get_comments_number($posts_arr[0]->ID).' ';
				if(get_comments_number($posts_arr[0]->ID) <= 1)
				{
				    $return_html.= __( 'Comment', THEMEDOMAIN );
				}
				else
				{
				    $return_html.= __( 'Comments', THEMEDOMAIN );
				}
				$return_html.= '</a>'.' / ';
			}
			$return_html.= date('M d, Y', strtotime($posts_arr[0]->post_date));
			$return_html.='</div>';
			
		    $return_html.= '</div>';
			
			if($current_page_template != 'page_sidebar.php')
			{
				//Display second and third posts
				$return_html.= '<div class="one_half last">';
				
				$return_html.= '<div class="one_half">';
				//Get second post
				if(has_post_thumbnail($posts_arr[1]->ID, 'related_post'))
				{
				    $image_id = get_post_thumbnail_id($posts_arr[1]->ID);
				    $image_thumb = wp_get_attachment_image_src($image_id, 'related_post', true);
				}
				
				if(!empty($image_thumb))
			    {
			    	$return_html.= '<div class="post_img entry_img ppb_cat">';
			    	$return_html.= '<a href="'.get_permalink($posts_arr[1]->ID).'" title="'.$posts_arr[1]->post_title.'">';
			        $return_html.= '<img src="'.$image_thumb[0].'" alt="" class="home_category_ft" ';
			        $return_html.= '/>';
			        $return_html.= '</a>';
			    	$return_html.= '</div>';
			    }
			    $return_html.= '<h7 class="ppb_cat_title">';
			    $return_html.= '<a href="'.get_permalink($posts_arr[1]->ID).'" title="'.$posts_arr[1]->post_title.'">'.$posts_arr[1]->post_title.'</a></h7>';
		
				//Get third post
				if(has_post_thumbnail($posts_arr[2]->ID, 'related_post'))
				{
				    $image_id = get_post_thumbnail_id($posts_arr[2]->ID);
				    $image_thumb = wp_get_attachment_image_src($image_id, 'related_post', true);
				}
				
				if(!empty($image_thumb))
			    {
			    	$return_html.= '<div class="post_img entry_img ppb_cat">';
			    	$return_html.= '<a href="'.get_permalink($posts_arr[2]->ID).'" title="'.$posts_arr[2]->post_title.'">';
			        $return_html.= '<img src="'.$image_thumb[0].'" alt="" class="home_category_ft" ';
			        $return_html.= '/>';
			        $return_html.= '</a>';
			    	$return_html.= '</div>';
			    }
			    $return_html.= '<h7 class="ppb_cat_title">';
			    $return_html.= '<a href="'.get_permalink($posts_arr[2]->ID).'" title="'.$posts_arr[2]->post_title.'">'.$posts_arr[2]->post_title.'</a></h7>';
				$return_html.= '</div>';
			}
			
			//Get the rest of posts
			$return_html.= '<div class="one_half last ppb_cat_last">';
			$begin_last_column = 2;
			if($current_page_template == 'page_sidebar.php')
			{
				$begin_last_column = 0;
			}
			
			foreach($posts_arr as $key => $post)
			{
		        if($key > $begin_last_column)
		        {
		        	$return_html.= '<div>';
		        	
		        	if($current_page_template == 'page_sidebar.php')
					{
						$image_thumb = '';
				        if(has_post_thumbnail($post->ID, 'related_post'))
						{
						    $image_id = get_post_thumbnail_id($post->ID);
						    $image_thumb = wp_get_attachment_image_src($image_id, 'related_post', true);
						}
						
						$return_html.= '<a class="item_bg" href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">';
		
			    		if(isset($image_thumb[0]) && !empty($image_thumb[0]))
			    		{
			    			$return_html.= '<img class="alignleft thumb" src="'.$image_thumb[0].'" alt=""/>';
			    		}
						$return_html.= '</a>';
					}
		        	
					$return_html.= '<a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'" class="post_title">';
		    		$return_html.= $post->post_title.'</a><br/>';
					$return_html.= '<span class="post_attribute ppb_cat_last ';
					
					if($current_page_template != 'page_sidebar.php')
					{
						$return_html.= 'ppb_cat_last_fullwidth';
					}
					
					$return_html.= '">'.date('M d, Y', strtotime($post->post_date)).'</span>';
					$return_html.= '</div>';
					
					if($current_page_template == 'page_sidebar.php')
					{
						$return_html.= '<br class="clear"/>';
					}
		        }
				
			}
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= '</div>';
			}
			
			$return_html.= '</div>';
		}
		else
		{
			$return_html.= 'Empty blog post Please make sure you have created it.';
		}

		$return_html.= '</div><br class="clear"/>';

		return $return_html;



	}
     
} // End Element Class
 
// Element Class Init
new vcCategoryBlog();