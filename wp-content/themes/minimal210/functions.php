<?php

/*-------------------------------------------------------------------------------
	After theme setup
-------------------------------------------------------------------------------*/

if ( ! function_exists( 'minimal210_setup' ) ) {

	function minimal210_setup() {

		// Load textdomain
		load_theme_textdomain( 'minimal210', get_template_directory() . '/languages' );

		// Add theme support
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'custom-logo');
	    add_theme_support( 'woocommerce' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'minimal210' ),
		) );

		$GLOBALS['content_width'] = apply_filters( 'minimal210_content_width', 1080 );

		add_image_size( 'featured_preview', 400, 200 );
	}
	add_action( 'after_setup_theme', 'minimal210_setup' );
}

/*-------------------------------------------------------------------------------
	Theme requirements
-------------------------------------------------------------------------------*/

define( 'MIN_INC_PATH', get_template_directory(). '/inc/' );
define( 'MIN_RESPONSIVE_MENU_PATH', get_template_directory(). '/inc/responsive-menu/' );
define( 'MIN_RESPONSIVE_MENU_URI', get_template_directory_uri(). '/inc/responsive-menu/' );
define( 'MIN_CUSTOM_ACF_FIELDS_PATH', get_template_directory(). '/inc/settings/fields/' );
define( "INC_PATH", get_template_directory(). '/inc');

require( INC_PATH. '/customizer/customizer.php' );
require( INC_PATH. '/admin/admin.php' );
require( INC_PATH. '/settings/settings.php' );


/*-------------------------------------------------------------------------------
	Require modules on setting
-------------------------------------------------------------------------------*/

if( ! function_exists( 'min_require_theme_modules' ) ) {

    function min_require_theme_modules() {

        // $slider_enabled             = get_field( 'setting_slider_module_name', 'option' );
        $breadcrumbs_enabled        = get_field( 'setting_activate_breadcrumbs', 'option' );
        $responsive_menu_enabled    = get_field( 'setting_activate_responsive_menu', 'option' );

        // Activated by default
        // if( file_exists( INC_PATH. '/slider/slider.php' ) && $slider_enabled === NULL || $slider_enabled == true ) {
		//
        //     require_once( INC_PATH. '/slider/slider.php' );
        // }
		//
        if( file_exists( INC_PATH. '/breadcrumbs/breadcrumbs.php' ) && $breadcrumbs_enabled == true ) {

            require_once( INC_PATH. '/breadcrumbs/breadcrumbs.php' );
        }

        if( file_exists( MIN_RESPONSIVE_MENU_PATH. 'responsive-menu.php' ) && $responsive_menu_enabled == true ) {

            require_once( MIN_RESPONSIVE_MENU_PATH. 'responsive-menu.php' );
        }
    }

}
add_action( 'after_setup_theme', 'min_require_theme_modules' );

/*-------------------------------------------------------------------------------
	Thema updater
-------------------------------------------------------------------------------*/

// require 'inc/version/plugin-update-checker.php';
// $myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
// 	'http://minimal.buro210.nl/theme.json',
// 	__FILE__,
// 	'minimal210'
// );

/*-------------------------------------------------------------------------------
	Customize ACF path
-------------------------------------------------------------------------------*/

if( ! function_exists( 'minimal210_acf_settings_path' ) ) {

	function minimal210_acf_settings_path( $path ) {

	    // update path
	    $path = get_template_directory() . '/inc/acf/';

	    // return
	    return $path;
	}
	add_filter( 'acf/settings/path', 'minimal210_acf_settings_path' );
}

/*-------------------------------------------------------------------------------
	Customize ACF dir
-------------------------------------------------------------------------------*/

if( ! function_exists( 'minimal210_acf_settings_dir' ) ) {

	function minimal210_acf_settings_dir( $dir ) {

		// update dir
		$dir = get_template_directory_uri() . '/inc/acf/';

		// return
		return $dir;
	}
	add_filter( 'acf/settings/dir', 'minimal210_acf_settings_dir' );
}

/*-------------------------------------------------------------------------------
	Include ACF
-------------------------------------------------------------------------------*/

include_once( get_template_directory() . '/inc/acf/acf.php' );

/*-------------------------------------------------------------------------------
	Verwijder Wordpress Version Number
-------------------------------------------------------------------------------*/
function remove_wordpress_version() {
    return '';
}
add_filter('the_generator', 'remove_wordpress_version');

// Pick out the version number from scripts and styles
function remove_version_from_style_js( $src ) {
    if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'remove_version_from_style_js');
add_filter( 'script_loader_src', 'remove_version_from_style_js');

/*-------------------------------------------------------------------------------
	Include plugins
-------------------------------------------------------------------------------*/

require_once( get_template_directory() . '/plugin-activation.php' );

if( ! function_exists( 'minimal210_plugin_extra' ) ) {

    function minimal210_plugin_extra( ) {
        $plugins = array(

            // This is an example of how to include a plugin from the WordPress Plugin Repository.

            array(
                'name'      => 'Klassieke editor',
                'slug'      => 'classic-editor',
                'required'  => true,
            ),

            array(
                'name'      => 'WP-SCSS',
                'slug'      => 'wp-scss',
                'required'  => true,
            ),

            array(
                'name'      => 'Imsanity',
                'slug'      => 'imsanity',
                'required'  => true,
            ),

            array(
                'name'      => 'ACF: Better Search',
                'slug'      => 'acf-better-search',
                'required'  => false,
            ),

            array(
                'name'      => 'Advanced Custom Fields: Font Awesome Field',
                'slug'      => 'advanced-custom-fields-font-awesome',
                'required'  => false,
            ),

            array(
                'name'      => 'Ninja Forms',
                'slug'      => 'ninja-forms',
                'required'  => false,
            ),

            array(
                'name'      => 'ACF: Ninjaforms Add-on',
                'slug'      => 'acf-ninjaforms-add-on',
                'required'  => false,
            ),

			array(
                'name'      => 'Duplicate Posts',
                'slug'      => 'duplicate-post',
                'required'  => false,
            ),

			array(
                'name'      => 'Post SMTP',
                'slug'      => 'post-smtp',
                'required'  => false,
            ),

			array(
                'name'      => 'Post Terms Order',
                'slug'      => 'post-types-order',
                'required'  => false,
            ),

            array(
                'name'      => 'SVG Support',
                'slug'      => 'svg-support',
                'required'  => false,
            ),

        );

        $config = array(
            'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to bundled plugins.
            'menu'         => 'install-plugins-theme', // Menu slug.
            'parent_slug'  => 'plugins.php',            // Parent menu slug.
            'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => true,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
        );

        tgmpa( $plugins, $config );
    }

}

add_action( 'tgmpa_register', 'minimal210_plugin_extra' );


/*-------------------------------------------------------------------------------
	Enqueue scripts and styles
-------------------------------------------------------------------------------*/

if( ! function_exists( 'minimal210_scripts' ) ) {

	function minimal210_scripts() {

		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'minimal210_style', get_stylesheet_uri() );
        wp_enqueue_style( 'minimal210_fontAwesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css' );

		// Frontend retrieved from settings page
		$frontend_path = get_template_directory_uri(). '/inc/frontend';

		if( get_field( 'setting_search_in_menu_name','option' ) ) {

			wp_enqueue_script( 'minimal210_search_in_menu_script', $frontend_path. '/js/search-in-menu.js', array( 'jquery' ) );
		}

		if( get_field( 'setting_sticky_header_name','option' ) ) {

			wp_enqueue_script( 'minimal210_sticky_menu_script', $frontend_path. '/js/sticky-menu.js', array( 'jquery' ) );
		}

        if( get_field( 'setting_carousel_module_name','option' ) ) {

            wp_enqueue_style( 'slick-style','//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' );
            wp_enqueue_script( 'slick-script', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery') );

        }
	}
	add_action( 'wp_enqueue_scripts', 'minimal210_scripts' );
}

/*-------------------------------------------------------------------------------
	Menu
-------------------------------------------------------------------------------*/

if( ! function_exists( 'minimal210_menu' ) ) {

	function minimal210_menu() { ?>

		<nav id='main-navigation' class='block menu'>

			<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>

		</nav>

	<?php }
}

/*-------------------------------------------------------------------------------
	Admin footer
-------------------------------------------------------------------------------*/

if( ! function_exists( 'minimal210_admin_footer' ) ) {

	function minimal210_admin_footer() {

		echo __( 'Ontwikkeld door BURO210','minimal210' );
	}
	add_filter( 'admin_footer_text', 'minimal210_admin_footer' );
}

/*-------------------------------------------------------------------------------
	Search in menu
-------------------------------------------------------------------------------*/

if( ! function_exists( 'minimal210_search_menu' ) ) {

	function minimal210_search_icon() {

		if( get_field( 'setting_search_in_menu_name','option' ) ) {

			echo '<div id="theme-search" class="block search-icon"><i class="fa fa-search" aria-hidden="true"></i></div>';

			get_search_form();
		}
	}
}

/*-------------------------------------------------------------------------------
	Numbered Pagination
-------------------------------------------------------------------------------*/

if( ! function_exists( 'minimal_pagination' ) ) {

    function minimal_pagination( $numpages = '', $pagerange = '', $paged='' ) {

        if( empty( $pagerange ) ) {
            $pagerange = 2;
        }

        global $paged;

        if( empty( $paged ) ) {
            $paged = 1;
        }
        if( $numpages == '' ) {
            global $wp_query;
            $numpages = $wp_query->max_num_pages;

            if( ! $numpages ) {
                $numpages = 1;
            }
        }

        if( get_option('permalink_structure') && !is_search() ) {

            $format = 'page/%#%/';

        }elseif(is_search()){

            $format = '&paged=%#%';
        }else{

            $format = '&paged=%#%';
        }

        $pagination_args = array(
            'base'              => get_pagenum_link(1) . '%_%',
            'format'            => $format,
            'total'             => $numpages,
            'current'           => $paged,
            'show_all'          => False,
            'end_size'          => 1,
            'mid_size'          => $pagerange,
            'prev_next'         => True,
            'prev_text'         => '<i class="fa fa-caret-left"></i>',
            'next_text'         => '<i class="fa fa-caret-right"></i>',
            'type'              => 'plain',
            'add_args'          => false,
            'add_fragment'      => ''
        );

        $paginate_links = paginate_links( $pagination_args );

        if( $paginate_links ) {
            echo '<nav class="minimal-pagination">';
            // echo '<div class="page-of">Page ' . $paged . ' of ' . $numpages . '</div>';
            echo $paginate_links;
            echo '</nav>';
        }
    }
}

/*-------------------------------------------------------------------------------
	Normalize attributes
	Currently used in /inc/slider/slider.php
-------------------------------------------------------------------------------*/

if( ! function_exists( 'minimal_normalize_attributes' ) ) {

	function minimal_normalize_attributes( $atts ) {
	    foreach( $atts as $key => $value ) {
	    	if( is_int( $key ) ) {
	            $atts[$value] = true;
	            unset( $atts[$key] );
	    	}
		}
		return $atts;
	}
}

/*-------------------------------------------------------------------------------
	Post id exists
	Not used
-------------------------------------------------------------------------------*/

function min_post_exists( $id ) {

	return is_string( get_post_status( $id ) );
}

function min_user_has_role( $role, $user_id = '' ) {

    return true;

    if( is_user_logged_in() == false )
        return;

    if( empty( $user_id ) )
        $user_id = wp_get_current_user()->ID;

    $role = get_userdata( $user_id )->roles;

    if( in_array( $role, (array) $role ) ) {

        return true;

    }else{

        return false;
    }
}

if( ! function_exists( 'max_acf_php_repeater' ) ) {

    function max_acf_php_repeater( $repeater ) {

        if( isset( $repeater['sub_fields'] ) && is_array( $repeater['sub_fields'] ) ) {

            $defaults = array(

                'required'          => 0,
                'instructions'      => '',
                'wrapper'           => array( 'width' => ''  ),
                'prefix'            => 0,
                'append'            => '',
                '_prepare'          => 0,
                '_name'             => '',
            );

            foreach( $repeater['sub_fields'] as $field_key => $sub_field ) {

                // Loop defaults
                foreach( $defaults as $key => $property ) {

                    // If property is not set
                    if( ! isset( $repeater['sub_fields'][$field_key][$key] ) ) {

                        // Set property
                        $repeater['sub_fields'][$field_key][$key] = $property;
                    }
                }
            }
        }

        return $repeater;
    }
}

//Remove H1 Uit Wysiwyg Editor
if( ! function_exists( 'remove_h1_from_editor' ) ) {
    function remove_h1_from_editor( $settings ) {
        $settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Preformatted=pre;';
        return $settings;

    }
    add_filter( 'tiny_mce_before_init', 'remove_h1_from_editor' );
}


// redirect wp-admin en wp-login.php open based on easy-hide-login

function minimal_hide_login_head(){

    $EHL_slug =  'adminlogin';

    if( isset($_GET['action']) && isset($_GET['key']) ) return;

    if(isset($_GET['action']) && $_GET['action'] == 'resetpass' ) return;
    if(isset($_GET['action']) && $_GET['action'] == 'rp' ) return;

    if( isset($_POST['redirect_slug']) && $_POST['redirect_slug'] == $EHL_slug) return false;


    if( strpos($_SERVER['REQUEST_URI'], 'action=logout') !== false ){
      check_admin_referer( 'log-out' );

      $user = wp_get_current_user();

      wp_logout();
      wp_safe_redirect( home_url(), 302 );
      die;
    }

    if(!is_user_logged_in()){

        if( ( strpos($_SERVER['REQUEST_URI'], $EHL_slug) === false  ) &&
        ( strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false  ) ){


            wp_safe_redirect( home_url( 'no-access' ), 302 );
            exit();

        }
    }
}
add_action( 'login_init', 'minimal_hide_login_head',1);

function minimal_hide_login_hidden_field(){
    $EHL_slug =  'adminlogin';
    ?>
        <input type="hidden" name="redirect_slug" value="<?php echo $EHL_slug ?>" />
  <?php
}
add_action('login_form', 'minimal_hide_login_hidden_field');

function minimal_hide_login_lostpassword() {
    $EHL_slug =  'adminlogin';
    return site_url("wp-login.php?action=lostpassword&$EHL_slug&redirect=false");
}
add_filter( 'lostpassword_url',  'minimal_hide_login_lostpassword', 10, 0 );

function minimal_hide_logout( $logout_url) {

    return home_url();
}

add_action('lostpassword_form', 'minimal_hide_login_hidden_field');

function minimal_hide_login_lostpassword_redirect($lostpassword_redirect) {
    $EHL_slug = get_option('wpseh_l01gnhdlwp');

    return 'wp-login.php?checkemail=confirm&redirect=false&' . $EHL_slug;
}
add_filter( 'lostpassword_redirect', 'minimal_hide_login_lostpassword_redirect', 100, 1 );

// redirect wp-admin en wp-login.php close



function minimal_button($atts){

    //create addts
    $a = shortcode_atts( array(
      'link' => '',
      'target' => '',
      'text' =>'',
      'class' =>'',
   ), $atts );

    //geef alle add
    $link = $a['link'];
    $target = $a['target'];
    $text = $a['text'];
    $class = $a['class'];
    $button = '';

    //check of args leeg zijn
    if( !empty($link) && !empty($text) ){

        $button .= "<a href='$link' target='$target' class='$class'>";
        $button .= $text;
        $button .= "</a>";

        return $button;

    }
}
add_shortcode( 'minimal_button', 'minimal_button' );


//Buro210 img ophalen met alle gegevens

if( ! function_exists( 'minimal210_img' ) ) {

    function minimal210_img($field,$class,$size){

        if(is_array($field)){

            if(empty($size)){
                $url = $field['url'];
            }else{
               $url = $field['sizes'][$size];
            }
            $alt = $field['alt'];
            $title = $field['title'];

            if(!empty($url)){
                ?>

                    <img
                        src="<?php echo $url;?>"
                         <?php if($class !== ''){ echo "class='" . $class . "'";}  ?>
                        <?php if($title !== ''){ echo "title='" . $title . "'";}  ?>
                        <?php if($alt !== ''){ echo "alt='" . $alt . "'";}  ?>
                    >

                <?php
            }
        }else{
            if( current_user_can('administrator')){
                echo"De afbeelding is geen array";
            }
        }

    }

}

//buttons
function minimal_go_to_button($atts){

    $handle = 'go_to_button.js';
    $list = 'enqueued';
    if (!wp_script_is( $handle, $list )) {
        wp_enqueue_script( 'go_to_button', get_template_directory_uri(). '/inc/frontend'. '/js/go_to_button.js', array( 'jquery' ) );
    }

    //create addts
    $a = shortcode_atts( array(
        'target' => '',
        'class' => '',
        'text' =>'',
        'pos' => '0'
    ), $atts );

    //geef alle add
    $target = $a['target'];
    $text = $a['text'];
    $class = $a['class'];
    $pos = $a['pos'];
    $button = '';

    //check of args leeg zijn
    if( !empty($target) && !empty($text) && !empty($class) ){

        $button .="<button class=".$class." onclick=\"go_to_button('$target','$pos')\">";
        $button .= "$text";
        $button .='</button>';

        return $button;

    }
}
add_shortcode( 'minimal_go_to_button', 'minimal_go_to_button' );

//Buro210 ACF link converter
if( ! function_exists( 'minimal210_link' ) ) {

    function minimal210_link($field,$class){

        if( $field ) {

           if( $field['url'] && $field['title'] ) {

              if( $field['target'] ) {
                $target = 'target="' . $field['target'] . '"';
              } else {
                $target = '';
              }

              if( $class ) {
                $a_class = 'class="'. $class .'"';
              } else {
                $a_class = '';
              }

              ?>

              <a <?= $a_class ?> href='<?= $field['url'] ?>' <?= $target ?>><?= $field['title'] ?></a>

           <?php }

        }

    }

}

function menu_item_text( $menu ) {
    $menu = str_ireplace( 'Thema Editor', '<i class="fa fa-code"></i> Code Editor', $menu );
    $menu = str_ireplace( 'Weergave', ' Minimal', $menu );
    $menu = str_ireplace( 'Customizer', ' Identiteit', $menu );
    return $menu;
}
add_filter('gettext', 'menu_item_text');
add_filter('ngettext', 'menu_item_text');




function my_custom_fonts() {
    wp_enqueue_style( 'minimal210_fontAwesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css' );

    echo '
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap");
        #adminmenu #menu-appearance .wp-menu-image:before {
            font-family: "Poppins", sans-serif;
            content: "210" !important;
            font-size: 13px;
            padding-top: 10px;
            -webkit-text-stroke: 1px  rgb(255,124,189);
            color:  rgb(255,124,189);
            transition: 0.3s;
        }
    </style>';
}
add_action('admin_head', 'my_custom_fonts');

add_action( 'admin_menu', 'add_google_to_admin' );
function add_google_to_admin() {
    add_menu_page( 'add_google_to_admin', 'Menu', 'read', '/nav-menus.php', '', 'dashicons-align-full-width', 80 );
}


//Website beheerder mag ninjaforms inzendingen bekijken
//// Must use all three filters for this to work properly.
add_filter( 'ninja_forms_admin_submissions_capabilities',   'nf_subs_capabilities' ); // Submissions Submenu

function nf_subs_capabilities( $cap ) {
    return 'edit_posts'; // EDIT: User Capability
}


/**
 * Filter hook used in the API route permission callback to retrieve submissions
 *
 * return bool as for authorized or not.
 */
add_filter( 'ninja_forms_api_allow_get_submissions', 'nf_define_permission_level', 10, 2 );
add_filter( 'ninja_forms_api_allow_delete_submissions', 'nf_define_permission_level', 10, 2 );
add_filter( 'ninja_forms_api_allow_update_submission', 'nf_define_permission_level', 10, 2 );
add_filter( 'ninja_forms_api_allow_handle_extra_submission', 'nf_define_permission_level', 10, 2 );
add_filter( 'ninja_forms_api_allow_email_action', 'nf_define_permission_level', 10, 2 );

function nf_define_permission_level() {

  $allowed = \current_user_can("delete_others_posts");

  return $allowed;
}
