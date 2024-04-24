<?php

/*-------------------------------------------------------------------------------
	Create ACF settings
-------------------------------------------------------------------------------*/

if( ! function_exists('min_breadcrumbs_local_field_gropu') ) {
	
	/**
	 * Creates the settings for the breadcrumbs
	 * @return type
	 */

	function min_breadcrumbs_local_field_gropu() {

		// Ensure translations have been loaded
		if( function_exists('acf_add_options_page') ) {
		
		    // Slider settings page
		    acf_add_options_sub_page(array(
				'page_title' 	=> __('Breadcrumbs','minimal210'),
				'menu_title'	=> __('Breadcrumbs','minimal210'),
				'parent_slug'	=> '/options-general.php',
				'capability'	=> 'manage_options',
			));

		    // Settings group general
			acf_add_local_field_group( array(
		        'key'      => 'group_breadcrumbs',
		        'title'    => __('Breadcrumbs settings','minimal210'),
		        'location' => array(
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'acf-options-breadcrumbs',
						),
					),
				),
		        'menu_order'            => 0,
		        'position'              => 'normal',
		        'style'                 => 'default',
		        'label_placement'       => 'top',
		        'instruction_placement' => 'label',
		        'hide_on_screen'        => '',
		    ) );

   			acf_add_local_field( array(
		        'key'          => 'field_breadcrumbs_separator',
		        'label'        => __('Separator','minimal210'),
		        'name'         => 'setting_breadcrumbs_separator',
		        'type'         => 'text',
		        'parent'       => 'group_breadcrumbs',
		        'required'     => 0,
				'default_value'=> '/',
	   		) );

   			// Remove attachments and pages
	   		$exclude_cpts = array(
	   		    'attachment','page'
	   		);

	   		// Include is plugin active function
	   		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	   		if ( is_plugin_active( 'formidable/formidable.php' ) ) {

	   			// Include formidable forms display
	   		    array_push( $exclude_cpts, 'frm_display' );
	   		} 

	   		// We only want the public post types
	   		$post_types = get_post_types( array(
	   		    'public'  => true,
	   		) );

	   		// Remove attachments from the others
	   		foreach( $exclude_cpts as $exclude_cpt ){

	   		    unset( $post_types[$exclude_cpt] );
	   		}

	   		// If there are any left
	   		if($post_types){

	   			// Loop the post types
	   			foreach ( $post_types  as $post_type ) {

	   				// Retrieve object
	   				$obje = get_post_type_object( $post_type );

	   				// Enable user metabox for post type
	   			    acf_add_local_field( array(
	   			        'key'          	=> 'field_set_redirect_for_'.$post_type.'_key',
	   			        'label'        	=> 'Set redirect for '.$obje->labels->name,
	   			        'name'         	=> 'setting_set_redirect_for_'.$post_type.'_name',
	   			        'type'         	=> 'link',
	   			        'parent'       	=> 'group_breadcrumbs',
	   			        'instructions' 	=> 'Set redirect for '.$obje->labels->name.' in the breadcrumbs.',
	   			        'required'     	=> 0,
	   					'allow_null'	=> 0,
	   					'allow_archives'=> 0,
	   					'multiple'		=> 0,
	   			    ) );
	   			}
	   		}

   		    // Settings group side
   			acf_add_local_field_group( array(
   		        'key'      => 'group_side_breadcrumbs',
   		        'title'    => __('Gebruik','minimal210'),
   		        'location' => array(
   					array(
   						array(
   							'param' => 'options_page',
   							'operator' => '==',
   							'value' => 'acf-options-breadcrumbs',
   						),
   					),
   				),
   		        'menu_order'            => 0,
   		        'position'              => 'side',
   		        'style'                 => 'default',
   		        'label_placement'       => 'top',
   		        'instruction_placement' => 'label',
   		        'hide_on_screen'        => '',
   		    ) );

   		    // Shortcode in side
		    acf_add_local_field( array(
		        'key'					=> 'field_message_breadcrumbs_side',
		        'name'         			=> '',
		        'parent'       			=> 'group_side_breadcrumbs',
		        'type'         			=> 'message',
		        'message'				=> '',
		        'instructions'			=> __( 'Use this code to display your breadcrumbs', 'minimal210' ),
	   		) );
		} // End if ACF can add option pages
	}
}
add_action( 'init', 'min_breadcrumbs_local_field_gropu' );

if( ! function_exists( 'min_alter_breadcrumbs_side_message' ) ) {

	/**
	 * Alters the side message for the usable functions
	 * @param type $field 
	 * @return type
	 */

	function min_alter_breadcrumbs_side_message( $field ) {

		$field['message'] = '';
		$field['message'] .= '<strong>Shortcode:</strong><br>';
		$field['message'] .= '<input onclick="this.focus();this.select()" value="[min-breadcrumbs]"><br>';
		$field['message'] .= '<strong>Functie:</strong><br>';
		$field['message'] .= '<input onclick="this.focus();this.select()" value="min_breadcrumbs();">';

		return $field;
	}
}
add_filter('acf/load_field/key=field_message_breadcrumbs_side', 'min_alter_breadcrumbs_side_message');