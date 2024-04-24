<?php

function minimal210_enqueue_child_styles()
{

    $parent_style = 'parent-style';

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array($parent_style), wp_get_theme()->get('Version'));

    wp_enqueue_style('minimal-scss-main-style', get_stylesheet_directory_uri() . '/css/main.css');
    wp_enqueue_style('minimal-scss-responsive-style', get_stylesheet_directory_uri() . '/css/responsive.css');

    wp_enqueue_script('matchheight', get_stylesheet_directory_uri() . '/scripts/jquery.matchHeight.js', array('jquery'));
    wp_enqueue_script('objectfit', get_stylesheet_directory_uri() . '/scripts/objectfit.js', array('jquery'));
    wp_enqueue_script('scripts', get_stylesheet_directory_uri() . '/scripts/scripts.js', array('jquery'));
    wp_enqueue_script('slider', get_stylesheet_directory_uri() . '/scripts/slider.js', array('jquery'));
}
add_action('wp_enqueue_scripts', 'minimal210_enqueue_child_styles');

function minimal210_enqueue_child_admin_styles()
{

    wp_enqueue_style('minimal210-child-admin-styles', get_stylesheet_directory_uri() . '/css/admin.css');
}
add_action('admin_enqueue_scripts', 'minimal210_enqueue_child_admin_styles');

// Customize adminbar
function min_modify_adminbar()
{

    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'min_modify_adminbar');

// remove standaard post wordpress
function remove_default_post_type($args, $postType)
{
    if ($postType === 'post') {
        $args['public'] = false;
        $args['show_ui'] = false;
        $args['show_in_menu'] = false;
        $args['show_in_admin_bar'] = false;
        $args['show_in_nav_menus'] = false;
        $args['can_export'] = false;
        $args['has_archive'] = false;
        $args['exclude_from_search'] = true;
        $args['publicly_queryable'] = false;
        $args['show_in_rest'] = false;
    }

    return $args;
}
add_filter('register_post_type_args', 'remove_default_post_type', 0, 2);


function min_get_link_menu($field_value = '', $current_post_id = '', $class = '')
{

    if (empty($field_value)) {

        return;
    }

    if (empty($current_post_id)) {

        if (!is_404()) {

            global $post;
            $current_post_id = $post->ID;

        } else {

            $current_post_id = 0;
        }
    }

    $post_parents = get_post_ancestors($post->ID);
    $link = esc_url($field_value['url']);
    $title = $field_value['title'];
    $current_menu_post_id = url_to_postid($link);

    if ($current_menu_post_id == $current_post_id) {

        $current = 'current-product-item';

    } elseif (in_array($current_post_id, $post_parents) == true) {

        $current = 'current-product-item-ancestor';

    } else {

        $current = '';
    }

    return '<li class="' . $current . ' ' . $menu_link_class . '"><a href="' . $link . '">' . $title . '</a></li>';
}

if (!function_exists('min_get_admin_menu_key_by_name')) {

    function min_get_admin_menu_key_by_name($name, $menu = '')
    {

        if (!$menu) {

            global $menu;
        }

        foreach ($menu as $key => $menu_content) {

            if (array_search($name, $menu_content)) {

                return $key;
            }
        }
    }
}

//Button repeater//Button repeater
function minimal_button_repeater($atts)
{

    $button_repeater = $atts;

    if (have_rows($button_repeater)) {

        $output = '';
        $output .= '<div class="block button-repeater">';

        while (have_rows($button_repeater)) {
            the_row();
            $link = get_sub_field('link');
            $color = get_sub_field('color');

            if ($link['title'] && $link['url']) {

                if ($link['target']) {
                    $link_target = 'target="' . $link["target"] . '"';
                } else {
                    $link_target = '';
                }

                if ($color) {
                    $output .= '<a class="button ' . $color . '" ' . $link_target . ' href="' . $link["url"] . '">' . '<p>' . $link["title"] . '</p>' . '</a>';
                } else {
                    $output .= '<a class="button" ' . $link_target . ' href="' . $link["url"] . '">' . $link["title"] . '</a>';
                }

            } //check URL & Title

        } //While Loop

        $output .= '</div>';

        return $output;

    } else if (have_rows($button_repeater, 'option')) {

        $output = '';
        $output .= '<div class="block button-repeater">';

        while (have_rows($button_repeater, 'option')) {
            the_row();
            $link = get_sub_field('link');
            $color = get_sub_field('color');

            if ($link['title'] && $link['url']) {

                if ($link['target']) {
                    $link_target = 'target="' . $link["target"] . '"';
                } else {
                    $link_target = '';
                }

                if ($color) {
                    $output .= '<a class="button ' . $color . '" ' . $link_target . ' href="' . $link["url"] . '">' . '<p>' . $link["title"] . '</p>' . '</a>';
                } else {
                    $output .= '<a class="button" ' . $link_target . ' href="' . $link["url"] . '">' . $link["title"] . '</a>';
                }

            } //check URL & Title

        } //While Loop

        $output .= '</div>';

        return $output;
    } else {

        echo '<pre><p>Repeater is empty or does not exists</p></pre>';
    }

}
add_shortcode('button_repeater', 'minimal_button_repeater');

//Custom wysiwyg
function my_mce4_options($init)
{

    $custom_colours = '
		"ff0000", "Rood",
        "ffff00", "Geel",
        "0000ff", "Blauw",
        "000", "Zwart",
        "fff", "Wit",
		"ed0579", "Buro210 roze",

    ';

    // build colour grid default+custom colors
    $init['textcolor_map'] = '[' . $custom_colours . ']';

    // change the number of rows in the grid if the number of colors changes
    // 8 swatches per row
    $init['textcolor_rows'] = 4;

    return $init;
}
add_filter('tiny_mce_before_init', 'my_mce4_options');

// D.m.v. deze code worden alle images in het bericht veld (Documentatie) verkleind.
function my_acf_admin_head()
{
    ?>
    <style type="text/css">
        .acf-input img {
            max-height: 250px;
            max-width: 85%;

            width: fit-content;
            object-fit: contain;
        }
    </style>
    <?php
}

add_action('acf/input/admin_head', 'my_acf_admin_head');

/*-------------------------------------------------------------------------------
    Hieronder kan je beginnen met coderen.
-------------------------------------------------------------------------------*/

//Custom post type Nieuwsberichten

// function nieuws_post_type() {
//
//     $tag_default        = 'Nieuwsberichten';
//     $tag_single         = 'Nieuwsbericht';
//     $tag_low_single     = 'nieuws';
//
//     $labels = array(
//         'name'                  => _x( $tag_default, 'Post Type General Name', 'minimal210-child' ),
//         'singular_name'         => _x( $tag_default, 'Post Type Singular Name', 'minimal210-child' ),
//         'menu_name'             => __( $tag_default, 'minimal210-child' ),
//         'name_admin_bar'        => __( $tag_default, 'minimal210-child' ),
//         'archives'              => __( $tag_single . ' archief', 'minimal210-child' ),
//         'attributes'            => __( $tag_single . ' attributen', 'minimal210-child' ),
//         'parent_item_colon'     => __( 'Parent '. $tag_single .' item:', 'minimal210-child' ),
//         'all_items'             => __( 'Alle '. $tag_default .' ', 'minimal210-child' ),
//         'add_new_item'          => __( 'Voeg '. $tag_single .' toe', 'minimal210-child' ),
//         'add_new'               => __( 'Voeg '. $tag_single .' toe', 'minimal210-child' ),
//         'new_item'              => __( 'New '. $tag_single .' item', 'minimal210-child' ),
//         'edit_item'             => __( 'Edit '. $tag_single .' item', 'minimal210-child' ),
//         'update_item'           => __( 'Update '. $tag_single .' Item', 'minimal210-child' ),
//         'view_item'             => __( 'View '. $tag_single .' item', 'minimal210-child' ),
//         'view_items'            => __( 'View '. $tag_single .' items', 'minimal210-child' ),
//         'search_items'          => __( 'Search '. $tag_single .' item', 'minimal210-child' ),
//         'not_found'             => __( 'Not found', 'minimal210-child' ),
//         'not_found_in_trash'    => __( $tag_default . ' not found in trash', 'minimal210-child' ),
//         'featured_image'        => __( 'Featured image', 'minimal210-child' ),
//         'set_featured_image'    => __( 'Set featured image', 'minimal210-child' ),
//         'remove_featured_image' => __( 'Remove featured image', 'minimal210-child' ),
//         'use_featured_image'    => __( 'Use as featured image', 'minimal210-child' ),
//         'insert_into_item'      => __( 'Insert into '. $tag_single .' item', 'minimal210-child' ),
//         'uploaded_to_this_item' => __( 'Uploaded to this '. $tag_single .' item', 'minimal210-child' ),
//         'items_list'            => __( $tag_single . ' list', 'minimal210-child' ),
//         'items_list_navigation' => __( 'Items list navigation', 'minimal210-child' ),
//         'filter_items_list'     => __( 'Filter items list', 'minimal210-child' ),
//     );
//     $args = array(
//         'label'                 => __( $tag_default, 'minimal210-child' ),
//         'description'           => __( $tag_single .' messages', 'minimal210-child' ),
//         'labels'                => $labels,
//         'supports'              => array( 'title'),
//         'taxonomies'            => array( 'sub-category'),
//         'hierarchical'          => false,
//         'public'                => true,
//         'show_ui'               => true,
//         'show_in_menu'          => true,
//         'menu_position'         => 5,
//         'menu_icon'             => 'dashicons-format-aside',
//         'show_in_admin_bar'     => true,
//         'show_in_nav_menus'     => true,
//         'can_export'            => true,
//         'has_archive'           => false,
//         'exclude_from_search'   => false,
//         'publicly_queryable'    => true,
//         'capability_type'       => 'page',
//
//     );
//     register_post_type( $tag_low_single , $args );
//
// }
// add_action( 'init', 'nieuws_post_type' , 0 );
function profielen_post_type()
{

    $tag_default = 'Recepten';
    $tag_single = 'Recept';
    $tag_low_single = 'Recepten';

    $labels = array(
        'name' => _x($tag_default, 'Post Type General Name', 'minimal210-child'),
        'singular_name' => _x($tag_default, 'Post Type Singular Name', 'minimal210-child'),
        'menu_name' => __($tag_default, 'minimal210-child'),
        'name_admin_bar' => __($tag_default, 'minimal210-child'),
        'archives' => __($tag_single . ' archief', 'minimal210-child'),
        'attributes' => __($tag_single . ' attributen', 'minimal210-child'),
        'parent_item_colon' => __('Parent ' . $tag_single . ' item:', 'minimal210-child'),
        'all_items' => __('Alle ' . $tag_single . ' items', 'minimal210-child'),
        'add_new_item' => __('Add ' . $tag_single . ' item', 'minimal210-child'),
        'add_new' => __('Add ' . $tag_single . ' item', 'minimal210-child'),
        'new_item' => __('New ' . $tag_single . ' item', 'minimal210-child'),
        'edit_item' => __('Edit ' . $tag_single . ' item', 'minimal210-child'),
        'update_item' => __('Update ' . $tag_single . ' Item', 'minimal210-child'),
        'view_item' => __('View ' . $tag_single . ' item', 'minimal210-child'),
        'view_items' => __('View ' . $tag_single . ' items', 'minimal210-child'),
        'search_items' => __('Search ' . $tag_single . ' item', 'minimal210-child'),
        'not_found' => __('Not found', 'minimal210-child'),
        'not_found_in_trash' => __($tag_default . ' not found in trash', 'minimal210-child'),
        'featured_image' => __('Featured image', 'minimal210-child'),
        'set_featured_image' => __('Set featured image', 'minimal210-child'),
        'remove_featured_image' => __('Remove featured image', 'minimal210-child'),
        'use_featured_image' => __('Use as featured image', 'minimal210-child'),
        'insert_into_item' => __('Insert into ' . $tag_single . ' item', 'minimal210-child'),
        'uploaded_to_this_item' => __('Uploaded to this ' . $tag_single . ' item', 'minimal210-child'),
        'items_list' => __($tag_single . ' list', 'minimal210-child'),
        'items_list_navigation' => __('Items list navigation', 'minimal210-child'),
        'filter_items_list' => __('Filter items list', 'minimal210-child'),
    );
    $args = array(
        'label' => __($tag_default, 'minimal210-child'),
        'description' => __($tag_single . ' messages', 'minimal210-child'),
        'labels' => $labels,
        'supports' => array('title'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-users',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
        'taxonomies' => array('category'),
    );
    register_post_type($tag_low_single, $args);
}
add_action('init', 'profielen_post_type', 0);
