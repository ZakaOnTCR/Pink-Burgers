<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*-------------------------------------------------------------------------------
	Enqueue scripts and styles
-------------------------------------------------------------------------------*/

if( ! function_exists( 'minimal_breadcrumbs_scripts' ) ) {

	function minimal_breadcrumbs_scripts() {

		// Create path
		$breadcrumbs_path = get_template_directory_uri(). '/inc/breadcrumbs';

		// Frontend styles
		wp_register_style( 'minimal210-breadcrumbs-style', $breadcrumbs_path. '/css/breadcrumbs.css' );

	}
}
add_action( 'wp_enqueue_scripts', 'minimal_breadcrumbs_scripts' );


/*-------------------------------------------------------------------------------
	Require ACF Breadcrumbs settings
-------------------------------------------------------------------------------*/

require_once( get_template_directory(). '/inc/breadcrumbs/settings.php');

/*-------------------------------------------------------------------------------
	Breadcrumbs main function
-------------------------------------------------------------------------------*/

if( ! function_exists( 'min_breadcrumbs' ) ) {

	function min_breadcrumbs( $separator = '' ) {

		// Enqueue style registered in minimal_breadcrumbs_scripts()
		wp_enqueue_style( 'minimal210-breadcrumbs-style' );

	    global $post;

	    if( ! empty( $separator ) ) {

	    // Retrieve separator from settings page
	    }elseif( get_field( 'setting_breadcrumbs_separator', 'option' ) ) {

	        $separator = get_field( 'setting_breadcrumbs_separator', 'option' );
	        
	    }else{

	        $separator = '/';
	    }

	    // Wrap separator
	    $separator = '<li class="separator">&nbsp;'.$separator.'&nbsp;</li>';

	    $separator = apply_filters( 'min/inc/breadcrumbs/separator', $separator );

	    // Start

	    // Breadcrumbs wrapper
	    // ID for styling purposes
	    echo '<ul class="minimal-breadcrumbs" id="minimal-breadcrumbs">';

	    // Get home in list and url
	    echo '<li class="item item-home"><a href="'. get_home_url() .'">';

	    	$home_title = apply_filters( 'min/inc/breadcrumbs/home_title', get_the_title( get_option( 'page_on_front' ) ) );

	    	// Get home title
	        echo $home_title;

	    echo '</a></li>';

	    // If is post type page
	    if( is_page() ) {

	    	// If page has parent
	        if( $post->post_parent ) {

	            // Get array of post parents
	            $parents = get_post_ancestors( $post->ID );

	            // Reverse parents
	            $parents = array_reverse( $parents );

	            // If parents are set
	            if( isset( $parents ) ) {

	            	// Foreach parent 
	                foreach( $parents as $parent ) {

	                	// Get parent url
	                    $parent_url = get_permalink( $parent );

	                    // Get parent title
	                    $parent_title = get_the_title( $parent );

	                    echo $separator;

	                    // Show parent
	                    echo '<li class="item item-page-parent"><a href="'.$parent_url.'">'.$parent_title.'</a></li>';                    
	                }
	            }
	        }

	        echo $separator;

	        // Show current page
	        echo '<li class="item current">'.get_the_title().'</li>';
	    
	    // If is single
	    }elseif( is_single() ) {

	    	// Get post type 
	        $post_type = get_post_type();

	        // Check if post type setting for breadcrumbs for current post type is set
	        if( get_field( 'setting_set_redirect_for_'.$post_type.'_name', 'option' ) ) {

	        	// Get value from setting
	        	$value = get_field( 'setting_set_redirect_for_'.$post_type.'_name', 'option' );

	        	// If minimal210_get_link function exists
	        	if( function_exists( 'minimal210_get_link' ) ) {

	        		$link = minimal210_get_link( $value );
	        	}else{

	        		$link = '<a href="'.$value['url'].'">'.$value['title'].'</a>';
	        	}

	        	echo $separator;

	        	// Show post type
	        	echo '<li class="item post-type">'.$link.'</li>';
	        }

	        echo $separator;

	        // Get single item
	        echo '<li class="item current">'.get_the_title().'</li>';

	    }elseif( is_search() ) {

	        echo $separator;

	        $search = apply_filters( 'min/inc/breadcrumbs/search',  '<li class="item search-item">Zoekresultaten</li>' );

	    	echo $search;

	    }elseif( is_404() ) {

	        echo $separator;

	        $error = apply_filters( 'min/inc/breadcrumbs/error', '<li class="item error-item">Error 404</li>' );

	    	echo $error;
	    }

	    echo '</ul>';
	}
}

/*-------------------------------------------------------------------------------
	Breadcrumbs main shortcode
-------------------------------------------------------------------------------*/

function min_breadcrumbs_shortcode( $atts ) {

	return min_breadcrumbs($atts);
}
add_shortcode( 'min-breadcrumbs', 'min_breadcrumbs_shortcode' );

?>