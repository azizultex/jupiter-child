<?php
/*
Element Description: Home Slider
*/

// Element Class 
class vcHomeSlider extends WPBakeryShortCode {
     
    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'vc_jupiter_mapping' ) );
        add_shortcode( 'vc_jupiter_slider', array( $this, 'vc_jupiter_html' ) );
    }
     
    // Element Mapping
	public function vc_jupiter_mapping() {
	         
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
	            'name' => __('Home Slider', 'jupiter-child'),
	            'base' => 'vc_jupiter_slider',
	            'description' => __('My theme custom slider', 'jupiter-child'), 
	            'category' => __('Jupiter Element', 'jupiter-child'),   
	            'icon' => 'icon-wpb-images-carousel',            
	            'params' => array( 

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
	                    'heading' => __( 'Show Post Number', 'jupiter-child' ),
	                    'param_name' => 'count',
	                    'value' => 6,
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
	public function vc_jupiter_html( $atts ) {
	     
	    // Params extraction
	    extract(
	        shortcode_atts(
	            array(
	                'category'   => '',
	                'count' => '',
	            ), 
	            $atts
	        )
	    );
	     
	    //Get all post from this category
		$args = array(
			'posts_per_page'  	=> (int)$count,
			'category_name'     => $category,
		);
		$slider_posts = get_posts($args);
		if(!empty($slider_posts)){
			$html = '<div class="slider_wrapper fade-in animated2">
						<div id="page_slider" class="flexslider">
							<ul class="slides">';
			foreach($slider_posts as $key => $slider_post){
				$image_thumb = '';
				$html .= '<li>';
				if(has_post_thumbnail($slider_post->ID, 'slider_full_ft'))
				{
				    $image_id = get_post_thumbnail_id($slider_post->ID);
				    $image_thumb = wp_get_attachment_image_src($image_id, 'home_slider', true);
				}

				$html .= '
					<div class="main_post_full">
						<a href="'. get_permalink($slider_post->ID) .'" title="'. $slider_post->post_title .'">
							<img src="'. $image_thumb[0] .'" alt=""/>
							
						</a>

					</div>
					<div class="clear_fix"></div>
					<h3>'. $slider_post->post_title .'</h3>
				';

				$html .= '</li>';
			}

			$html .= '		</ul>
						</div>
					</div>';
		}

	    return $html;
	}
     
} // End Element Class
 
// Element Class Init
new vcHomeSlider();