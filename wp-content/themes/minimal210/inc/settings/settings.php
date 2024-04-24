<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*-------------------------------------------------------------------------------
	Extend ACF with Post type selector
-------------------------------------------------------------------------------*/

if( ! function_exists( 'min_include_custom_acf_field_post_type_select' ) ) {

	function min_include_custom_acf_field_post_type_select( $version ) {

	    include_once( MIN_CUSTOM_ACF_FIELDS_PATH. '/post-type-select/post-type-select.php' );
	}
}
add_action('acf/include_field_types', 'min_include_custom_acf_field_post_type_select' );

if( ! function_exists( 'min_include_custom_acf_field_action_button' ) ) {

	function min_include_custom_acf_field_action_button( $version ) {

	    include_once( MIN_CUSTOM_ACF_FIELDS_PATH. '/button/action-button.php' );
	}
}
add_action('acf/include_field_types', 'min_include_custom_acf_field_action_button');

if( ! function_exists('minimal_settings_local_field_group') ) {

	function minimal_settings_local_field_group() {

		if( function_exists('acf_add_options_page') ) {

			/*-------------------------------------------------------------------------------
				Create options page for theme settings
			-------------------------------------------------------------------------------*/

			acf_add_options_page(array(
				'menu_title'	=> __('Theme Settings','minimal210'),
				'menu_slug' 	=> 'settings-minimal210',
				'capability'	=> 'manage_options',
				'parent_slug'	=> 'options-general.php',
				'autoload'		=> true,
			));

			/*-------------------------------------------------------------------------------
				Create options group for theme settings page
			-------------------------------------------------------------------------------*/

			// Settings group general
			acf_add_local_field_group( array(
		        'key'      				=> 'settings_group',
		        'title'    				=> __('General theme settings','minimal210'),
		        'location'	 			=> array(
					array(
						array(
							'param' 	=> 'options_page',
							'operator' 	=> '==',
							'value' 	=> 'settings-minimal210',
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

		    /*-------------------------------------------------------------------------------
				Tab 1: Header
				Has following settings:
				- Sticky header
				- Search in menu
			-------------------------------------------------------------------------------*/

		    acf_add_local_field( array(
		        'key'          		=> 'setting_tab_header_key',
		        'label'        		=> __('Header','minimal210'),
		        'name'         		=> '',
		        'type'         		=> 'tab',
		        'endpoint'			=> 0,
		        'parent'       		=> 'settings_group',
	   		) );

		    acf_add_local_field( array(
		        'key'          		=> 'setting_sticky_header_key',
		        'label'        		=> __('Sticky header','minimal210'),
		        'name'         		=> 'setting_sticky_header_name',
		        'parent'       		=> 'settings_group',
				'default_value'		=> true,
		        'type'         		=> 'true_false',
		        'ui' 				=> 1,
    			'ui_on_text' 		=> __( 'On', 'minimal210' ),
    			'ui_off_text' 		=> __( 'Off', 'minimal210' ),
	   		) );

	   		acf_add_local_field( array(
		        'key'          		=> 'setting_search_in_menu_key',
		        'label'        		=> __('Search in menu','minimal210'),
		        'name'         		=> 'setting_search_in_menu_name',
		        'parent'       		=> 'settings_group',
				'default_value'		=> true,
		        'type'         		=> 'true_false',
		        'ui' 				=> 1,
				'ui_on_text' 		=> __( 'On', 'minimal210' ),
				'ui_off_text' 		=> __( 'Off', 'minimal210' ),
	   		) );

	   		/*-------------------------------------------------------------------------------
				Tab 2: Modules
				Has following settings:
				- Activate carousel module
				- Activate maps module
			-------------------------------------------------------------------------------*/

	   		acf_add_local_field( array(
	   			'key'          		=> 'setting_tab_modules_key',
	   			'label'        		=> __('Modules','minimal210'),
	   			'name'         		=> '',
	   			'parent'       		=> 'settings_group',
	   			'type'         		=> 'tab',
	   			'endpoint'			=> 0,
	   		) );


			acf_add_local_field( array(
		        'key'          		=> 'setting_carousel_module_key',
		        'label'        		=> __('Activate slick carousel module','minimal210'),
		        'name'         		=> 'setting_carousel_module_name',
		        'parent'       		=> 'settings_group',
				'default_value'		=> true,
				'type'         		=> 'true_false',
		        'ui' 				=> 1,
    			'ui_on_text' 		=> __( 'On', 'minimal210' ),
    			'ui_off_text' 		=> __( 'Off', 'minimal210' ),
	   		) );

	   		acf_add_local_field( array(
		        'key'          		=> 'field_setting_lightbox_module_key',
		        'label'        		=> __('Activate Lightbox module','minimal210'),
		        'name'         		=> 'setting_lightbox_module_name',
		        'parent'       		=> 'settings_group',
		        'instructions' 		=> __('Creates settings on settings > lightbox.','minimal210'),
				'default_value'		=> false,
				'type'         		=> 'true_false',
		        'ui' 				=> 1,
    			'ui_on_text' 		=> __( 'On', 'minimal210' ),
    			'ui_off_text' 		=> __( 'Off', 'minimal210' ),
	   		) );

	   		acf_add_local_field( array(
		        'key'          		=> 'field_activate_breadcrumbs',
		        'label'        		=> __('Activate Breadcrumbs','minimal210'),
		        'name'         		=> 'setting_activate_breadcrumbs',
		        'parent'       		=> 'settings_group',
				'type'         		=> 'true_false',
		        'ui' 				=> 1,
    			'ui_on_text' 		=> __( 'On', 'minimal210' ),
    			'ui_off_text' 		=> __( 'Off', 'minimal210' ),
	   		) );

	   		acf_add_local_field( array(
		        'key'          		=> 'field_activate_responsive_menu',
		        'label'        		=> __('Activate responsive menu', 'minimal210'),
		        'name'         		=> 'setting_activate_responsive_menu',
		        'parent'       		=> 'settings_group',
				'type'         		=> 'true_false',
		        'ui' 				=> 1,
    			'ui_on_text' 		=> __( 'On', 'minimal210' ),
				'ui_off_text' 		=> __( 'Off', 'minimal210' ),
				'wrapper' 			=> array(
					'width'			=> '25',
					'class' 		=> '',
					'id' 			=> '',
				),
			) );

			acf_add_local_field( array(
		        'key'          		=> 'field_activate_responsive_menu_search',
		        'label'        		=> __('Responsive menu searchform','minimal210'),
		        'name'         		=> 'field_activate_responsive_menu_search',
		        'parent'       		=> 'settings_group',
				'default_value'		=> false,
				'type'         		=> 'true_false',
		        'ui' 				=> 1,
    			'ui_on_text' 		=> __( 'On', 'minimal210' ),
    			'ui_off_text' 		=> __( 'Off', 'minimal210' ),
				'conditional_logic' => array(
					array(
						array(
							'field' 	=> 'field_activate_responsive_menu',
							'operator' 	=> '==',
							'value' 	=> 1,
						),
					),
				),
				'wrapper' 			=> array(
					'width'			=> '25',
					'class' 		=> '',
					'id' 			=> '',
				),
	   		) );

	   		acf_add_local_field( array(
	   			'key'          		=> 'field_tab_acf_option_pages',
	   			'label'        		=> __('Optie paginas', 'minimal210'),
	   			'name'         		=> '',
	   			'parent'       		=> 'settings_group',
	   			'type'         		=> 'tab',
	   		) );

	   		$pages = array(

	   			'key'				=> 'field_option_pages_repeater',
	   			'label'				=> __( 'Optie paginas', 'minimal210' ),
	   			'name'				=> 'option_pages_repeater',
	   			'type'				=> 'repeater',
	   			'instructions'		=> '',
	   			'parent'			=> 'settings_group',
	   			'required'			=> 0,
	   			'layout'			=> 'table',
	   			'sub_fields'		=> array(
	   				array(
	   					'key'			=> 'field_page_name',
	   					'label'			=> 'Pagina naam',
	   					'name'			=> 'page_name',
	   					'type'			=> 'text',
	   					'required'		=> 1,
	   				),
	   			),
	   		);
	   		$pages = max_acf_php_repeater( $pages );
	   		acf_add_local_field( $pages );

	   		acf_add_local_field( array(
	   			'key'          		=> 'setting_tab_insert',
	   			'label'        		=> __('Header/Body/Footer code','minimal210'),
	   			'name'         		=> '',
	   			'parent'       		=> 'settings_group',
	   			'type'         		=> 'tab',
	   			'endpoint'			=> 0,
	   		) );

	   		acf_add_local_field( array(
		        'key'          		=> 'setting_header_insert',
		        'label'        		=> __('Header code','minimal210'),
		        'name'         		=> 'setting_header_insert',
		        'type'         		=> 'textarea',
		        'parent'       		=> 'settings_group',
		        'instructions' 		=> __('Vull hier alles in wat in de header moet komen.','minimal210'),
		        'rows'				=> 10,
	   		) );
	   		acf_add_local_field( array(
		        'key'          		=> 'setting_body_insert',
		        'label'        		=> __('Body code','minimal210'),
		        'name'         		=> 'setting_body_insert',
		        'type'         		=> 'textarea',
		        'parent'       		=> 'settings_group',
		        'instructions' 		=> __('Vull hier alles in wat in de body moet komen.','minimal210'),
		        'rows'				=> 10,
	   		) );
	   		acf_add_local_field( array(
		        'key'          		=> 'setting_footer_insert',
		        'label'        		=> __('Footer code','minimal210'),
		        'name'         		=> 'setting_footer_insert',
		        'type'         		=> 'textarea',
		        'parent'       		=> 'settings_group',
		        'instructions' 		=> __('Vull hier alles in wat in de footer moet komen.','minimal210'),
		        'rows'				=> 10,
	   		) );
		}
	}
	add_action('acf/init', 'minimal_settings_local_field_group');
}
