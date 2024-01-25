<?php 
function create_exercise_tools_post_type()
{

    $labels = array(
        'name' => _x('Exercise Tools', 'Post Type General Name', 'itbz-pro-tools'),
        'singular_name' => _x('Exercise Tool', 'Post Type Singular Name', 'itbz-pro-tools'),
        'menu_name' => __('Exercise Tools', 'itbz-pro-tools'),
        'name_admin_bar' => __('Exercise Tools', 'itbz-pro-tools'),
        'archives' => __('Item Archives', 'itbz-pro-tools'),
        'attributes' => __('Item Attributes', 'itbz-pro-tools'),
        'parent_item_colon' => __('Parent Item:', 'itbz-pro-tools'),
        'all_items' => __('All Items', 'itbz-pro-tools'),
        'add_new_item' => __('Add New Item', 'itbz-pro-tools'),
        'add_new' => __('Add New', 'itbz-pro-tools'),
        'new_item' => __('New Item', 'itbz-pro-tools'),
        'edit_item' => __('Edit Item', 'itbz-pro-tools'),
        'update_item' => __('Update Item', 'itbz-pro-tools'),
        'view_item' => __('View Item', 'itbz-pro-tools'),
        'view_items' => __('View Items', 'itbz-pro-tools'),
        'search_items' => __('Search Item', 'itbz-pro-tools'),
        'not_found' => __('Not found', 'itbz-pro-tools'),
        'not_found_in_trash' => __('Not found in Trash', 'itbz-pro-tools'),
        'featured_image' => __('Featured Image', 'itbz-pro-tools'),
        'set_featured_image' => __('Set featured image', 'itbz-pro-tools'),
        'remove_featured_image' => __('Remove featured image', 'itbz-pro-tools'),
        'use_featured_image' => __('Use as featured image', 'itbz-pro-tools'),
        'insert_into_item' => __('Insert into item', 'itbz-pro-tools'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'itbz-pro-tools'),
        'items_list' => __('Items list', 'itbz-pro-tools'),
        'items_list_navigation' => __('Items list navigation', 'itbz-pro-tools'),
        'filter_items_list' => __('Filter items list', 'itbz-pro-tools'),
    );
    $args = array(
        'label' => __('Exercise Tools', 'itbz-pro-tools'),
        'description' => __('Exercise Tools', 'itbz-pro-tools'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail'),
        'hierarchical' => false,
        'public' => true,
        'show_in_rest' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 2,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'capability_type' => 'page',
        'taxonomies' => array( 'tools_lavel', 'tools_proops', 'tools_category' ),
    );
    register_post_type('exercise_tools', $args);
}

add_action('init', 'create_exercise_tools_post_type', 0);
