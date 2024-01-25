<?php 

function create_exercise_tools_category_taxonomy() {

    $labels = array(
        'name'                       => _x( 'Tools Category', 'Taxonomy General Name', 'itbz-pro-tools' ),
        'singular_name'              => _x( 'Tools Category', 'Taxonomy Singular Name', 'itbz-pro-tools' ),
        'menu_name'                  => __( 'Tools Category', 'itbz-pro-tools' ),
        'all_items'                  => __( 'All Items', 'itbz-pro-tools' ),
        'parent_item'                => __( 'Parent Item', 'itbz-pro-tools' ),
        'parent_item_colon'          => __( 'Parent Item:', 'itbz-pro-tools' ),
        'new_item_name'              => __( 'New Item Name', 'itbz-pro-tools' ),
        'add_new_item'               => __( 'Add New Item', 'itbz-pro-tools' ),
        'edit_item'                  => __( 'Edit Item', 'itbz-pro-tools' ),
        'update_item'                => __( 'Update Item', 'itbz-pro-tools' ),
        'view_item'                  => __( 'View Item', 'itbz-pro-tools' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'itbz-pro-tools' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'itbz-pro-tools' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'itbz-pro-tools' ),
        'popular_items'              => __( 'Popular Items', 'itbz-pro-tools' ),
        'search_items'               => __( 'Search Items', 'itbz-pro-tools' ),
        'not_found'                  => __( 'Not Found', 'itbz-pro-tools' ),
        'no_terms'                   => __( 'No items', 'itbz-pro-tools' ),
        'items_list'                 => __( 'Items list', 'itbz-pro-tools' ),
        'items_list_navigation'      => __( 'Items list navigation', 'itbz-pro-tools' ),
    );
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
        'rewrite'           => false,
    );
    register_taxonomy( 'tools_category', array( 'exercise_tools' ), $args );

    $labels = array(
        'name'                       => _x( 'Tools Proops', 'Taxonomy General Name', 'itbz-pro-tools' ),
        'singular_name'              => _x( 'Tools Proops', 'Taxonomy Singular Name', 'itbz-pro-tools' ),
        'menu_name'                  => __( 'Tools Proops', 'itbz-pro-tools' ),
        'all_items'                  => __( 'All Items', 'itbz-pro-tools' ),
        'parent_item'                => __( 'Parent Item', 'itbz-pro-tools' ),
        'parent_item_colon'          => __( 'Parent Item:', 'itbz-pro-tools' ),
        'new_item_name'              => __( 'New Item Name', 'itbz-pro-tools' ),
        'add_new_item'               => __( 'Add New Item', 'itbz-pro-tools' ),
        'edit_item'                  => __( 'Edit Item', 'itbz-pro-tools' ),
        'update_item'                => __( 'Update Item', 'itbz-pro-tools' ),
        'view_item'                  => __( 'View Item', 'itbz-pro-tools' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'itbz-pro-tools' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'itbz-pro-tools' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'itbz-pro-tools' ),
        'popular_items'              => __( 'Popular Items', 'itbz-pro-tools' ),
        'search_items'               => __( 'Search Items', 'itbz-pro-tools' ),
        'not_found'                  => __( 'Not Found', 'itbz-pro-tools' ),
        'no_terms'                   => __( 'No items', 'itbz-pro-tools' ),
        'items_list'                 => __( 'Items list', 'itbz-pro-tools' ),
        'items_list_navigation'      => __( 'Items list navigation', 'itbz-pro-tools' ),
    );
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
        'rewrite'           => false,
    );
    register_taxonomy( 'tools_proops', array( 'exercise_tools' ), $args );

    $labels = array(
        'name'                       => _x( 'Tools Lavel', 'Taxonomy General Name', 'itbz-pro-tools' ),
        'singular_name'              => _x( 'Tools Lavel', 'Taxonomy Singular Name', 'itbz-pro-tools' ),
        'menu_name'                  => __( 'Tools Lavel', 'itbz-pro-tools' ),
        'all_items'                  => __( 'All Items', 'itbz-pro-tools' ),
        'parent_item'                => __( 'Parent Item', 'itbz-pro-tools' ),
        'parent_item_colon'          => __( 'Parent Item:', 'itbz-pro-tools' ),
        'new_item_name'              => __( 'New Item Name', 'itbz-pro-tools' ),
        'add_new_item'               => __( 'Add New Item', 'itbz-pro-tools' ),
        'edit_item'                  => __( 'Edit Item', 'itbz-pro-tools' ),
        'update_item'                => __( 'Update Item', 'itbz-pro-tools' ),
        'view_item'                  => __( 'View Item', 'itbz-pro-tools' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'itbz-pro-tools' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'itbz-pro-tools' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'itbz-pro-tools' ),
        'popular_items'              => __( 'Popular Items', 'itbz-pro-tools' ),
        'search_items'               => __( 'Search Items', 'itbz-pro-tools' ),
        'not_found'                  => __( 'Not Found', 'itbz-pro-tools' ),
        'no_terms'                   => __( 'No items', 'itbz-pro-tools' ),
        'items_list'                 => __( 'Items list', 'itbz-pro-tools' ),
        'items_list_navigation'      => __( 'Items list navigation', 'itbz-pro-tools' ),
    );
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
        'rewrite'           => false,
    );
    register_taxonomy( 'tools_lavel', array( 'exercise_tools' ), $args );
}

add_action( 'init', 'create_exercise_tools_category_taxonomy', 0 );