<?php 
function brb2_files()
{

    $labels = array(
        'name' => _x('BRB2 Files', 'Post Type General Name', 'itbz-access-code-management'),
        'singular_name' => _x('BRB2 File', 'Post Type Singular Name', 'itbz-access-code-management'),
        'menu_name' => __('BRB2 Files', 'itbz-access-code-management'),
        'name_admin_bar' => __('BRB2 Files', 'itbz-access-code-management'),
        'archives' => __('Item Archives', 'itbz-access-code-management'),
        'attributes' => __('Item Attributes', 'itbz-access-code-management'),
        'parent_item_colon' => __('Parent Item:', 'itbz-access-code-management'),
        'all_items' => __('All Items', 'itbz-access-code-management'),
        'add_new_item' => __('Add New Item', 'itbz-access-code-management'),
        'add_new' => __('Add New', 'itbz-access-code-management'),
        'new_item' => __('New Item', 'itbz-access-code-management'),
        'edit_item' => __('Edit Item', 'itbz-access-code-management'),
        'update_item' => __('Update Item', 'itbz-access-code-management'),
        'view_item' => __('View Item', 'itbz-access-code-management'),
        'view_items' => __('View Items', 'itbz-access-code-management'),
        'search_items' => __('Search Item', 'itbz-access-code-management'),
        'not_found' => __('Not found', 'itbz-access-code-management'),
        'not_found_in_trash' => __('Not found in Trash', 'itbz-access-code-management'),
        'featured_image' => __('Featured Image', 'itbz-access-code-management'),
        'set_featured_image' => __('Set featured image', 'itbz-access-code-management'),
        'remove_featured_image' => __('Remove featured image', 'itbz-access-code-management'),
        'use_featured_image' => __('Use as featured image', 'itbz-access-code-management'),
        'insert_into_item' => __('Insert into item', 'itbz-access-code-management'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'itbz-access-code-management'),
        'items_list' => __('Items list', 'itbz-access-code-management'),
        'items_list_navigation' => __('Items list navigation', 'itbz-access-code-management'),
        'filter_items_list' => __('Filter items list', 'itbz-access-code-management'),
    );
    $args = array(
        'label' => __('BRB2 Files', 'itbz-access-code-management'),
        'description' => __('BRB2 Files', 'itbz-access-code-management'),
        'labels' => $labels,
        'supports' => array('title', 'revisions',),
        'hierarchical' => false,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'capability_type' => 'page',
    );
    register_post_type('brb2-files', $args);
}

add_action('init', 'brb2_files', 0);