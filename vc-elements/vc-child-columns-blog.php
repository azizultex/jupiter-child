<?php
/*
Element Description: Category Blog
*/

// Element Class 
class vcColumnsBlog extends WPBakeryShortCode {
     
    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'vc_columns_blog_mapping' ) );
        add_shortcode( 'vc_columns_blog', array( $this, 'vc_columns_blog_html' ) );
    }
     
    // Element Mapping
	public function vc_columns_blog_mapping() {
	         
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
	            'name' => __('Columns Blog', 'jupiter-child'),
	            'base' => 'vc_columns_blog',
	            'description' => __('Add Columns Blog Posts', 'jupiter-child'), 
	            'category' => __('Jupiter Element', 'jupiter-child'),   
	            'icon' => 'vc_icon-vc-media-grid',            
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
	                    'value' => 4,
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
	public function vc_columns_blog_html( $atts ) {

		remove_filter('the_content', 'pp_formatter', 99);

		//extract short code attr
		extract(shortcode_atts(array(
			'size' => 'one',
			'title' => '',
			'items' => 4,
			'category' => '',
			'template' => '',
		), $atts));
		
		//Get current page template
		if(!empty($template))
		{
			$current_page_template = $template;
		}
		else
		{
			$current_page_template = basename(get_page_template());
		}

		//Get category posts
		$args = array(
		    'numberposts' => $items,
		    'order' => 'DESC',
		    'orderby' => 'date',
		    'post_type' =>'post',
		);
		
		if(!empty($category))
		{
			$args['category_name'] = $category;
		}
		$posts_arr = get_posts($args);
		$return_html = '';
		$return_html.= '<div class="'.$size.' ppb_column">';

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
			
			$return_html.= '<div>';
			
			$count = 1;
			foreach($posts_arr as $key => $post)
			{
				$image_thumb = '';
				$return_html.= '<div class="ppb_column_post ppb_column ';
				
				if($current_page_template != 'page_sidebar.php')
				{
					$return_html.= 'masonry ';
				}
				
				if($current_page_template == 'page_sidebar.php')
				{
					if($count%2==0)
					{ 
						$return_html.= 'last'; 
					}
				}
				else
				{
					if($count%3==0)
					{ 
						$return_html.= 'last'; 
					}
				}
				
				$return_html.= '">';
				
				if($current_page_template == 'page_sidebar.php')
				{
					if(has_post_thumbnail($post->ID, 'blog_half_ft'))
					{
					    $image_id = get_post_thumbnail_id($post->ID);
					    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_half_ft', true);
					}
				}
				else
				{
					if(has_post_thumbnail($post->ID, 'blog_mansory_ft'))
					{
					    $image_id = get_post_thumbnail_id($post->ID);
					    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_mansory_ft', true);
					}
				}
				
				$return_html.= '<div class="post_wrapper full ';
				
				if($current_page_template != 'page_sidebar.php')
				{
					$return_html.= 'masonry ';
				}
				
				if($current_page_template == 'page_sidebar.php')
				{
					if($count%2==0)
					{ 
						$return_html.= 'last'; 
					}
				}
				else
				{
					if($count%3==0)
					{ 
						$return_html.= 'last'; 
					}
				}

				$return_html.= '">';
				
				if($current_page_template == 'page_sidebar.php')
				{
			    	$return_html.= '<div class="post_inner_wrapper half">';
			    }
			    
			    if(isset($image_thumb[0]) && !empty($image_thumb))
				{
					$return_html.= '<div class="post_img ';
					
					if($current_page_template == 'page_sidebar.php')
					{
						$return_html.= 'ppb_column_sidebar';
					}
					else
					{
						$return_html.= 'ppb_column_fullwidth';
					}
					
					$return_html.= ' entry_img">';
					$return_html.= '<a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">';
					$return_html.= '<img src="'.$image_thumb[0].'" alt=""/></a>';
					
					//Get post type
			        $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
					
					//Get Post review score
					$post_review_score = get_review_score($post->ID);
					
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
			    //pp_debug($post);
			    $return_html.= '<div class="post_inner_wrapper half header">';
			    $return_html.= '<div class="post_header_wrapper half">';
			    $return_html.= '<div class="post_header half">';
			    $categories = wp_get_post_categories($post->ID);
			    foreach($categories as $category){
					$return_html.= '<h4><a href="'. get_category_link($category) .'">'. get_cat_name($category) .'</a></h4>';
			    }

			    $return_html.= '<h3><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h3>';
			    $return_html.= '</div></div>';
				/*$return_html.= '<p>'.pp_substr(strip_tags(strip_shortcodes($post->post_content)), 100).'</p>';*/
				$return_html.= '<div class="post_detail half">';
				
				$author_id=$post->post_author;
				$return_html.= '<span>'.date('M d, Y', strtotime($post->post_date)) . '</span>';
				
				if($current_page_template == 'page_sidebar.php')
				{
					$return_html.='</div>';
				}
				
				$return_html.= '</div></div><br class="clear"/></div>';
				$return_html.= '</div>';
				
				if($current_page_template != 'page_sidebar.php' && $count%3==0)
				{
					$return_html.= '<br class="clear"/>';
				}
				
				if($current_page_template == 'page_sidebar.php' && $count%2==0)
				{
					$return_html.= '<br class="clear"/>';
				}
				
				$count++;
			}
			
			$return_html.= '</div>';
		}
		else
		{
			$return_html.= 'Empty blog post Please make sure you have created it.';
		}

		$return_html.= '</div>';

		return $return_html;



	}
     
} // End Element Class
 
// Element Class Init
new vcColumnsBlog();