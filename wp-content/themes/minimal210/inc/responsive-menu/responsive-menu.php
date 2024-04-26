<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

if (!function_exists('min_res_menu_scripts')) {

    /**
     * Register responsive menu scripts and styles
     * @return type
     */

    function min_res_menu_scripts()
    {

        wp_register_style('min_responsive_menu_style', get_stylesheet_directory_uri() . '/css/responsive-menu.css');
        wp_register_script('min_responsive_menu_script', MIN_RESPONSIVE_MENU_URI . 'js/responsive-menu.js', array('jquery'));

        // Enequeu right away to increase speed
        wp_enqueue_style('min_responsive_menu_style');
    }
}
add_action('wp_enqueue_scripts', 'min_res_menu_scripts');

if (!function_exists('min_res_menu_load_files')) {

    /**
     * Load registered responsive menu scripts and styles
     * @return type
     */

    function min_res_menu_load_files()
    {

        if (!wp_script_is('min_responsive_menu_script', 'enqueued')) {

            wp_enqueue_script('min_responsive_menu_script');
        }
    }
}

if (!function_exists('min_res_menu_rearrange_menu')) {

    /**
     * Rearrange the given menu to use in the responsive menu
     * @param type $current_menu
     * @return type
     */

    function min_res_menu_rearrange_menu($current_menu)
    {

        // Check for a theme location
        if (is_nav_menu($current_menu) == false) {

            // Get all theme locations
            $theme_locations = get_nav_menu_locations();

            // If there are theme locations
            if (!isset($theme_locations[$theme_location]))
                return false;

            // Get menu object
            $menu_obj = get_term($theme_locations[$theme_location], 'nav_menu');

            // If the menu object is not false
            if (!$menu_obj)
                $menu_obj = false;

            // If the menu object name is not set
            if (!isset($menu_obj->name))
                return false;

            $current_menu = $menu_obj->name;
        }

        // Get navigation menu items in array
        $array_menu = wp_get_nav_menu_items($current_menu);

        // Create empty array
        $menu = array();

        foreach ($array_menu as $menu_item) {

            // If the current item has no parent
            if (empty($menu_item->menu_item_parent)) {

                // Create empty array for current menu item data
                $menu[$menu_item->ID] = array();

                // Set menu item id
                $menu[$menu_item->ID]['ID'] = $menu_item->ID;

                // Set post id
                $menu[$menu_item->ID]['post_id'] = $menu_item->object_id;

                // Set post title
                $menu[$menu_item->ID]['title'] = $menu_item->title;

                // Set post url
                $menu[$menu_item->ID]['url'] = $menu_item->url;

                // Make an empty array for the children
                $menu[$menu_item->ID]['children'] = array();

                // Store this for later
                $current_menu_id = $menu_item->ID;

                // Submenu depth 1
                foreach ($array_menu as $subx1) {

                    if ($current_menu_id == $subx1->menu_item_parent) {

                        // Store this for later
                        $current_submenu_id = $subx1->ID;

                        $submenu[$subx1->ID] = array();
                        $submenu[$subx1->ID]['ID'] = $current_submenu_id;
                        $submenu[$subx1->ID]['post_id'] = $subx1->object_id;
                        $submenu[$subx1->ID]['parent'] = $subx1->menu_item_parent;
                        $submenu[$subx1->ID]['title'] = $subx1->title;
                        $submenu[$subx1->ID]['url'] = $subx1->url;
                        $submenu[$subx1->ID]['children'] = array();

                        $menu[$current_menu_id]['children'][$submenu[$subx1->ID]['ID']] = $submenu[$subx1->ID];

                        // Submenu depth 2
                        foreach ($array_menu as $subx2) {

                            if ($current_submenu_id == $subx2->menu_item_parent) {

                                $current_submenux2_id = $subx2->ID;

                                $submenux2[$subx2->ID] = array();
                                $submenux2[$subx2->ID]['ID'] = $current_submenux2_id;
                                $submenux2[$subx2->ID]['post_id'] = $subx2->object_id;
                                $submenux2[$subx2->ID]['parent'] = $subx2->menu_item_parent;
                                $submenux2[$subx2->ID]['title'] = $subx2->title;
                                $submenux2[$subx2->ID]['url'] = $subx2->url;
                                $submenux2[$subx2->ID]['children'] = array();

                                $menu[$menu_item->ID]['children'][$current_submenu_id]['children'][$current_submenux2_id] = $submenux2[$subx2->ID];

                                // Submenu depth 3
                                foreach ($array_menu as $subx3) {

                                    if ($current_submenux2_id == $subx3->menu_item_parent) {

                                        // Store this for alter
                                        $current_submenux3_id = $subx3->ID;

                                        $submenux3[$subx3->ID] = array();
                                        $submenux3[$subx3->ID]['ID'] = $current_submenux3_id;
                                        $submenux3[$subx3->ID]['post_id'] = $subx3->object_id;
                                        $submenux3[$subx3->ID]['parent'] = $subx3->menu_item_parent;
                                        $submenux3[$subx3->ID]['title'] = $subx3->title;
                                        $submenux3[$subx3->ID]['url'] = $subx3->url;
                                        $submenux3[$subx3->ID]['children'] = array();

                                        $menu[$menu_item->ID]['children'][$current_submenu_id]['children'][$current_submenux2_id]['children'][$current_submenux3_id] = $submenux3[$subx3->ID];

                                        foreach ($array_menu as $subx4) {

                                            if ($current_submenux3_id == $subx4->menu_item_parent) {

                                                $current_submenux4_id = $subx4->ID;

                                                $submenux4[$subx4->ID] = array();
                                                $submenux4[$subx4->ID]['ID'] = $current_submenux4_id;
                                                $submenux4[$subx4->ID]['post_id'] = $subx4->object_id;
                                                $submenux4[$subx4->ID]['parent'] = $subx4->menu_item_parent;
                                                $submenux4[$subx4->ID]['title'] = $subx4->title;
                                                $submenux4[$subx4->ID]['url'] = $subx4->url;
                                                $submenux4[$subx4->ID]['children'] = array();

                                                $menu[$menu_item->ID]['children'][$current_submenu_id]['children'][$current_submenux2_id]['children'][$current_submenux4_id] = $submenux4[$subx4->ID];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $menu;
    }
}

if (!function_exists('min_responsive_menu')) {

    /**
     * Loads the responsive menu
     * @param type $menu_name can be location or menu name
     * @return type
     */

    function min_responsive_menu($menu_name)
    {

        $files = min_res_menu_load_files();

        $menu = min_res_menu_rearrange_menu($menu_name);

        $current_item_id = min_res_get_current_post_id();

        $output = '';

        $output .= '<ul id="min_responsive_menu" class="responsive-menu">';

        $trigger_counter = 0;

        // Add trigger to close the menu from inside of the menu
        // This gets displayed only when the menu goes to full width.
        // You can change this in scss > includes > _responsive-menu.scss

        $h_logo = get_field('h_logo_responsive', 'option');

        if ($h_logo && $trigger_counter == 0) {
            $output .= '<div class="top-wrap">';


            if ($h_logo) {
                $output .= '<img src="' . $h_logo . '">';
            }

            if ($trigger_counter == 0) {

                $output .= '<div id="trigger-menu-small"><i class="fa fa-times fa-fw" aria-hidden="true"></i></div>';
            }

            $output .= '</div>';
        } else {
            if ($h_logo) {
                $output .= '<img src="' . $h_logo . '">';
            }

            if ($trigger_counter == 0) {

                $output .= '<div id="trigger-menu-small"><i class="fa fa-times fa-fw" aria-hidden="true"></i></div>';
            }
        }

        $trigger_counter++;

        foreach ($menu as $menu_item) {

            // Start list item
            $output .= min_res_get_list_item($menu_item, $current_item_id);

            $output .= min_res_get_link($menu_item, false);

            if (min_res_menu_has_childs($menu_item)) {

                $output .= min_res_get_sub_toggle();

                $output .= '<ul class="responsive-submenu" >';

                $submenu = $menu_item['children'];

                foreach ($submenu as $menu_sub) {

                    $output .= min_res_get_list_item($menu_sub, $current_item_id);

                    $output .= min_res_get_link($menu_sub);

                    if (min_res_menu_has_childs($menu_sub)) {

                        $output .= min_res_get_sub_toggle();

                        $output .= '<ul class="responsive-submenu" >';

                        $submenux2 = $menu_sub['children'];

                        foreach ($submenux2 as $menu_sub_x2) {

                            $output .= min_res_get_list_item($menu_sub_x2, $current_item_id);

                            $output .= min_res_get_link($menu_sub_x2);

                            if (min_res_menu_has_childs($menu_sub_x2)) {

                                $output .= min_res_get_sub_toggle();

                                $output .= '<ul class="responsive-submenu" >';

                                $submenux3 = $menu_sub_x2['children'];

                                foreach ($submenux3 as $menu_sub_x3) {

                                    $output .= min_res_get_list_item($menu_sub_x3, $current_item_id);

                                    $output .= min_res_get_link($menu_sub_x3);

                                    $output .= '</li>';
                                }

                                $output .= '</ul>';
                            }

                            $output .= '</li>';
                        }

                        $output .= '</ul>';
                    }

                    $output .= '</li>';
                }

                $output .= '</ul>';

            }

            // End list item
            $output .= '</li>';
        }

        $h_button_repeater = 'h_button_repeater';

        if (have_rows($h_button_repeater, 'option')) {
            $output .= '<div class="repeater responsive">';

            $output .= minimal_button_repeater($h_button_repeater);

            $output .= '</div>';
        }

        if (get_field('field_activate_responsive_menu_search', 'options') == '1') {

            $output .= '<li>';

            $output .= get_search_form(false);

            $output .= '</li>';

        }

        $output .= apply_filters('min/inc/responsive_menu/button/extra', '');

        $output .= '</ul>';

        $output .= '<div id="menu_on_body_click"></div>';

        echo $output;
    }
}

if (!function_exists('min_responsive_menu_button')) {

    /**
     * Shows the responsive menu trigger button outside the menu
     * @return type
     */

    function min_responsive_menu_button()
    {

        $files = min_res_menu_load_files();

        $content = apply_filters('min/inc/responsive_menu/button/content', '<i class="fa fa-bars fa-fw" aria-hidden="true"></i>');

        $button = '';
        $button .= '<a id="trigger-menu" href="#">' . $content . '</a>';

        echo $button;
    }
}

function min_res_get_list_item($menu_item, $current_item)
{

    $classes = '';

    if ($menu_item['post_id'] == $current_item) {

        $classes .= 'current-menu-item ';
    }

    if ($menu_item['children']) {

        $classes .= 'menu-item-has-children ';

        foreach ($menu_item['children'] as $child) {

            if ($child['post_id'] == $current_item) {

                $classes .= 'current-parent ';

            } elseif ($child['children']) {
                foreach ($child['children'] as $child2) {
                    if ($child2['post_id'] == $current_item) {
                        $classes .= 'current-parent ';
                    } elseif ($child2['children']) {
                        foreach ($child2['children'] as $child3) {
                            if ($child3['post_id'] == $current_item) {
                                $classes .= 'current-parent ';
                            }
                        }
                    }
                }
            }
        }
    }

    if ($current_item) {

        $classes .= 'item-' . $menu_item['post_id'] . ' ';
    }

    $item = '<li class="menu-item ' . $classes . '">';

    return $item;
}

function min_res_get_link($menu_item, $prepend = '- ')
{

    $link = '';

    $link .= '<a href="' . $menu_item['url'] . '">';

    $link .= $prepend . $menu_item['title'];

    $link .= '</a>';

    return $link;
}

function min_res_get_sub_toggle()
{

    return '<div class="toggle_sub" href="#"><i class="fa fa-chevron-right fa-fw" aria-hidden="true"></i></div>';
}

function min_res_menu_has_childs($menu_item)
{

    if ($menu_item['children']) {

        return true;
    }

    return;
}

function min_res_get_current_post_id()
{

    if (!is_404() && !is_search() && !is_archive()) {

        global $post;

        $current_item_id = $post->ID;

    } else {

        $current_item_id = 0;
    }

    return $current_item_id;
}