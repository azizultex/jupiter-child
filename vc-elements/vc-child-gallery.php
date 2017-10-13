<?php
/*
Element Description: Home Slider
*/

// Element Class 
class vcGallery extends WPBakeryShortCode {
     
    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'vc_gallery_mapping' ) );
        add_shortcode( 'vc_jupiter_gallery', array( $this, 'vc_gallery_html' ) );
    }
     
    // Element Mapping
	public function vc_gallery_mapping() {
	         
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
	            'name' => __('Photo Gallery', 'jupiter-child'),
	            'base' => 'vc_jupiter_gallery',
	            'description' => __('My theme custom gallery', 'jupiter-child'), 
	            'category' => __('Jupiter Element', 'jupiter-child'),   
	            'icon' => 'icon-wpb-images-stack',            
	            'params' => array( 
	                  
	                array(
	                    'type' => 'textfield',
	                    'heading' => __( 'Gallery ID', 'jupiter-child' ),
	                    'param_name' => 'gallery_id',
	                    'description' => __( 'Add the gallery id you want to display', 'jupiter-child' ),
	                    'admin_label' => false,
	                    'weight' => 0,
	                    'group' => 'Content',
	                ),  

	                array(
	                    'type' => 'textfield',
	                    'heading' => __( 'Width', 'jupiter-child' ),
	                    'param_name' => 'width',
	                    'description' => __( 'Add the gallery image width', 'jupiter-child' ),
	                    'admin_label' => false,
	                    'weight' => 0,
	                    'group' => 'Content',
	                ),    

	                array(
	                    'type' => 'textfield',
	                    'heading' => __( 'Height', 'jupiter-child' ),
	                    'param_name' => 'height',
	                    'description' => __( 'Add the gallery image height', 'jupiter-child' ),
	                    'admin_label' => false,
	                    'weight' => 0,
	                    'group' => 'Content',
	                ),               
	                     
	            )
	        )
	    );                                
	        
	}
     
     
	// Element HTML
	public function vc_gallery_html( $atts ) {
	     
	    // Params extraction
	    extract(
	        shortcode_atts(
	            array(
	                'gallery_id'   => '',
	                'width' => '205',
	                'height' => '205',
	            ), 
	            $atts
	        )
	    );
	     
	    //Get gallery images
		$args = array( 
	        'post_type' => 'attachment', 
	        'numberposts' => -1, 
	        'post_status' => null, 
	        'post_parent' => (int) $gallery_id,
	        'order' => 'ASC',
	        'orderby' => 'menu_order',
	    );

		$images_arr = get_posts($args);
		$return_html = '';

		if(!empty($images_arr))
		{
			$return_html.= '<div class="pp_gallery">';
			foreach($images_arr as $key => $image)
			{
				$thumb = $image->ID;
				$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
				$image_resized = aq_resize( $img_url, (int) $width, (int) $height, true ); //resize & crop img
				
				$return_html.= '<div style="float:left;margin-right:5px;">';
				$return_html.= '<a title="'.$image->post_title.' '.$image->post_content.'" rel="gallery" href="'.$image->guid.'">';
				$return_html.= '<img src="'.$image_resized.'" alt="" />';
				$return_html.= '</a>';
				$return_html.= '</div>';
			}
			$return_html.= '</div>';
		}
		else
		{
			$return_html.= 'Empty gallery item. Please make sure you have upload image to it or check the short code.';
		}

		$return_html.= '<br class="clear"/>';

		return $return_html;
	}
     
} // End Element Class
 
// Element Class Init
new vcGallery();