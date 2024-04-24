<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function minimal210_admin_scripts() {

	$admin_path = get_template_directory_uri(). '/inc/admin';

	// Enqueue styles
	wp_enqueue_style( 'minimal210-admin-css', $admin_path. '/css/admin.css' );

	// Only for users list table page
	if( get_current_screen()->id == 'users' && ! current_user_can('administrator') ) {

		// wp_enqueue_script( 'minimal-admin-userlist-script', $admin_path. '/js/admin-userlist.js' , array('jquery') );
		// wp_enqueue_style( 'minimal-admin-userlist-style', $admin_path. '/css/admin-userlist.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'minimal210_admin_scripts' ); 

// Add Website beheerder role
// Date:	24-4-2017
if( ! function_exists('minimal_add_client_role') ) {

	function minimal_add_client_role() {

		global $wp_roles;

		if (!isset($wp_roles)) {

			$wp_roles = new WP_Roles();
		}

		$adm = $wp_roles->get_role('administrator');
		$wp_roles->add_role( 'klant' , __('Website beheerder','minimal210'), $adm->capabilities);
		$web = $wp_roles->get_role('klant');

		// Restrictments to plugins
		$web->remove_cap( 'delete_plugins' );
		$web->remove_cap( 'update_plugins' );
		$web->remove_cap( 'edit_plugins' );
		$web->remove_cap( 'install_plugins' );

		// Restrictments to theme
		$web->remove_cap( 'delete_themes' );
		$web->remove_cap( 'update_themes' );
		$web->remove_cap( 'edit_themes' );
		$web->remove_cap( 'install_themes' );
		$web->remove_cap( 'switch_themes' );

		// Restrictments to other
		$web->remove_cap( 'manage_options' );
		$web->remove_cap( 'export' );
		$web->remove_cap( 'import' );
		$web->remove_cap( 'delete_site' );  
	}
	add_action( 'init', 'minimal_add_client_role' );
}

if( ! function_exists('minimal_remove_menu_pages_client') ) {

	function minimal_remove_menu_pages_client(){

		if( ! current_user_can('administrator') ) {

			remove_menu_page( 'tools.php' ); // Extra
		}

		// Removed until created
		remove_menu_page( 'edit-comments.php' ); // reacties
	}
	add_action( 'admin_menu', 'minimal_remove_menu_pages_client' );
}

// Restricts clients to add a new admin account
if( ! function_exists('minimal_restrict_new_admin_accounts') ) {

	function minimal_restrict_new_admin_accounts($all_roles) {

		if( isset( $all_roles['administrator'] ) && !current_user_can('administrator') ){

			unset( $all_roles['administrator']);
	    }
	    return $all_roles;
	}
	add_filter('editable_roles', 'minimal_restrict_new_admin_accounts');
}

// Docs https://isabelcastillo.com/editor-role-manage-users-wordpress
class minimal_restrict_client_role_class {

	function __construct(){
		add_filter( 'map_meta_cap', array(&$this, 'map_meta_cap'),10,4);
	}

	function map_meta_cap( $caps, $cap, $user_id, $args ){
		switch( $cap ){
			case 'edit_user':
			case 'remove_user':
			case 'promote_user':
				if( isset($args[0]) && $args[0] == $user_id )
					break;
				elseif( !isset($args[0]) )
					$caps[] = 'do_not_allow';
				$other = new WP_User( absint($args[0]) );
				if( $other->has_cap( 'administrator' ) ){
					if(!current_user_can('administrator')){
						$caps[] = 'do_not_allow';
					}
				}
				break;
			case 'delete_user':
			case 'delete_users':
				if( !isset($args[0]) )
					break;
				$other = new WP_User( absint($args[0]) );
				if( $other->has_cap( 'administrator' ) ){
					if(!current_user_can('administrator')){
						$caps[] = 'do_not_allow';
					}
				}
				break;
			default:
				break;
		}
		return $caps;
	}
}
$minimal_user_caps = new minimal_restrict_client_role_class();

// Default sort order user list
// Place admins on bottom
if( ! function_exists( 'minimal_userlist_default_order' ) ) {

	function minimal_userlist_default_order( $query_args ){

		if( is_admin() && ! isset($_GET['order']) && ! current_user_can('administrator') ) {

			$query_args->query_vars['order'] = 'DESC';
		}

		return $query_args;
	}
	add_action( 'pre_get_users', 'minimal_userlist_default_order' );
}

// Add option pages sections according to settings
if( ! function_exists('minimal_add_sections_module') ) {

	function minimal_add_sections_module() {

		if( function_exists('acf_add_options_page') ) {

			$pages = array();

			if( have_rows( 'option_pages_repeater', 'option' ) ) {

			
				while( have_rows( 'option_pages_repeater', 'option' ) ) { the_row();

					$page_name = get_sub_field( 'page_name' );
					$page_name = strip_tags( $page_name );

					if( ! empty( $page_name ) ) {

						$pages[] = $page_name;
					}
				}
			}

			if( ! empty( $pages ) ) {

				// If there is only 1 page
				if( count( $pages ) == 1 ) {

					// Get menu title
					$menu_title = $pages[0];
				
				// Anything else
				}else{

					// Get menu title
					$menu_title = __( 'Sections', 'minimal210' );
				}

				// Filter menu title
				$menu_title = apply_filters( 'min/inc/admin/option_pages/menu_title', $menu_title );

				// Filter menu icon
				$menu_icon = apply_filters( 'min/inc/admin/option_pages/menu_icon', 'dashicons-align-center' );

				// Filter capability
				$menu_capability = apply_filters( 'min/inc/admin/option_pages/menu_capability', 'edit_posts' );

				// Filter menu slug
				$menu_slug = apply_filters( 'min/inc/admin/option_pages/menu_slug', 'minimal210_sections' );

				// Add menu page
				acf_add_options_page(array(
					'menu_title'	=> $menu_title,
					'menu_slug' 	=> $menu_slug,
					'capability'	=> $menu_capability,
					'redirect'		=> true,
					'icon_url'   	=> $menu_icon,
				));

				foreach( $pages as $page_name ) {

					acf_add_options_sub_page(array(
						'page_title' 	=> $page_name,
						'menu_title' 	=> $page_name,
						'parent_slug'	=> $menu_slug,
						'capability'	=> $menu_capability,
					));
				}
			}
		}
	}
	add_action('after_setup_theme', 'minimal_add_sections_module');
}

if( ! function_exists( 'min_admin_custom_columns_content' ) ) {

	/**
	 * Handles the content for the custom post type columns
	 * @param type $column 
	 * @param type $post_id 
	 * @param type $columns_content array
	 * @return type
	 */

	function min_admin_custom_columns_content( $column, $post_id, $columns_content, $location = '' ) {

		foreach( $columns_content as $key => $value ) {

			$is_image = false;

			if( $column == $key ) {

				$data = '';

				$data .= '<div class="min_admin_column">';

				if( current_user_can( 'edit_posts' ) && ! array_key_exists( 'no_url', $value ) )  {

					if( array_key_exists( 'type', $value ) ){

						if( $value['type'] == 'image' || $value['type'] == 'img' ) {

							$is_image = true;

							if( ! empty( $value['field_value'] ) ) {

								$image_id = $value['field_value']['ID'];

								$value['field_value'] = image_get_intermediate_size( $image_id, 'thumbnail' )['url'];

								if( array_key_exists( 'edit_url', $value ) ) {

									if( $value['edit_url'] == 'from_field_value' ) {

										$value['edit_url'] = wp_get_attachment_url( $image_id );
									
									}else{

										$value['edit_url'] = '';
									}
								}
							}
						}

						elseif( $value['type'] == 'title' ) {

							if( ! empty( $value['field_value'] ) ) {

								$title_id = $value['field_value'];

								$value['field_value'] = get_the_title( $title_id );

								if( array_key_exists( 'edit_url', $value ) ) {

									if( $value['edit_url'] == 'from_field_value' ) {

										$value['edit_url'] = get_edit_post_link( $title_id );

									}elseif( $value['edit_url'] == 'from_attachment_url' ) {

										$value['edit_url'] = wp_get_attachment_url( $title_id );
									
									}else{

										$value['edit_url'] = '';
									}
								}

							}else{

								$value['field_value'] = '--';

								$value['edit_url'] = '';
							}
						}

						elseif( $value['type'] == 'user_email' ) {

							if( ! empty( $value['field_value'] ) ) {

								$user_id = $value['field_value'];

								$user_email = get_userdata( $user_id )->user_email;

								$value['field_value'] = $user_email;

								if( array_key_exists( 'edit_url', $value ) ) {

									if( $value['edit_url'] == 'from_field_value' ) {

										$value['edit_url'] = get_edit_user_link( $user_id );
									
									}else{

										$value['edit_url'] = '';
									}
								}

							}else{

								$value['field_value'] = '--';

								$value['edit_url'] = '--';
							}
						}

						elseif( $value['type'] == 'status' ) {

							$status = $value['field_value'];

							$value['field_value'] = '<div class="abc_status_container abc_status-'.$status.'">';

							if( $status == 'new' ) {

								$value['field_value'] .= 'Nieuw';
							
							}elseif( $status == 'paid' ) {

								$value['field_value'] .= 'Betaald';

							}elseif( $status == 'expired' ) {

								$value['field_value'] .= 'Verlopen';
							}

							$value['field_value'] .= '</div>';    
						}

						elseif( $value['type'] == 'bool' ) {

							$bool = $value['field_value'];

							if( $bool == 'true' || $bool == true ) {

								$value['field_value'] = 'Ja';
							
							}else{

								$value['field_value'] = 'Nee';
							}
						}
					}

					if( array_key_exists( 'edit_url', $value ) ) {

						if( ! empty( $value['edit_url'] ) ) {

							$edit_url = esc_url( $value['edit_url'] );
						
						}else{

							if( $location == 'user_profile' ) {

								$edit_url = get_edit_user_link( $post_id );
							
							}else{

								$edit_url = get_edit_post_link( $post_id );
							}
						}

					}else{

						if( $location == 'user_profile' ) {

							$edit_url = get_edit_user_link( $post_id );

						}else{

							$edit_url = get_edit_post_link( $post_id );
						}
					}

					if( array_key_exists( 'empty_value', $value ) ) {

						$value['field_value'] = trim( $value['field_value'] );

						if( empty( $value['field_value'] ) ) {

							$value['field_value'] = $value['empty_value'];

							if( $is_image == true ) {

								$value['field_value'] = '';
							}
						}
					}

					$data .= '<a href="'.$edit_url.'">';

						if( $is_image == true ) {

							$data .= '<img src="'.$value['field_value'].'">';
						
						}else{

							$data .= $value['field_value'];
						}

					$data .= '</a>';

				}else{

					if( $is_image == true ) {

						$data .= '<img src="'.$value['field_value'].'">';
					
					}else{

						$data .= $value['field_value'];
					}
				}

				$data .= '</div>';

				return $data;
			}
		}
	}
}
function minimal_custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/inc/admin/login/minimal-login-style.css" />';
}
add_action('login_head', 'minimal_custom_login');

function minimal_loginlogo_url($url) {
    return 'https://www.buro210.nl';
}
add_filter( 'login_headerurl', 'minimal_loginlogo_url' );

function minimal_custom_footer() {

    // Add your content here
    ?>
		<p class="contact">Bij vragen of problemen: neem contact op met onze helpdesk via <a href="tel:+31182342808">0182 - 34 28 08 </a> of mail naar <a href="mailto:support@buro210.nl">support@buro210.nl</a>.</p>
    <?php
}
add_action( 'login_footer', 'minimal_custom_footer' );