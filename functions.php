<?php

/* Add your custom functions here */
add_action( 'wp_enqueue_scripts', 'jupiter_child_enqueue_styles' );
function jupiter_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}


//Add Visual Composer Elements Files
// Before VC Init
add_action( 'vc_before_init', 'vc_before_init_actions' );
 
function vc_before_init_actions() {
     
    //.. Code from other Tutorials ..//
 
    // Require new custom Element
    require_once( get_stylesheet_directory().'/vc-elements/vc-child-home-slider.php' );  
    require_once( get_stylesheet_directory().'/vc-elements/vc-child-category-blog.php' );  
    require_once( get_stylesheet_directory().'/vc-elements/vc-child-columns-blog.php' );  
    require_once( get_stylesheet_directory().'/vc-elements/vc-child-gallery.php' );  
     
}


add_image_size( 'home_slider', 960, 420, true );