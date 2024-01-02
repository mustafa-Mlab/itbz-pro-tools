<?php 

function brb2_exercise_category() {

    $labels = array(
        'name'                       => _x( 'BRB2 Exercise Categories', 'Taxonomy General Name', 'itbz-access-code-management' ),
        'singular_name'              => _x( 'BRB2 Exercise Category', 'Taxonomy Singular Name', 'itbz-access-code-management' ),
        'menu_name'                  => __( 'BRB2 Exercise Category', 'itbz-access-code-management' ),
        'all_items'                  => __( 'All Items', 'itbz-access-code-management' ),
        'parent_item'                => __( 'Parent Item', 'itbz-access-code-management' ),
        'parent_item_colon'          => __( 'Parent Item:', 'itbz-access-code-management' ),
        'new_item_name'              => __( 'New Item Name', 'itbz-access-code-management' ),
        'add_new_item'               => __( 'Add New Item', 'itbz-access-code-management' ),
        'edit_item'                  => __( 'Edit Item', 'itbz-access-code-management' ),
        'update_item'                => __( 'Update Item', 'itbz-access-code-management' ),
        'view_item'                  => __( 'View Item', 'itbz-access-code-management' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'itbz-access-code-management' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'itbz-access-code-management' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'itbz-access-code-management' ),
        'popular_items'              => __( 'Popular Items', 'itbz-access-code-management' ),
        'search_items'               => __( 'Search Items', 'itbz-access-code-management' ),
        'not_found'                  => __( 'Not Found', 'itbz-access-code-management' ),
        'no_terms'                   => __( 'No items', 'itbz-access-code-management' ),
        'items_list'                 => __( 'Items list', 'itbz-access-code-management' ),
        'items_list_navigation'      => __( 'Items list navigation', 'itbz-access-code-management' ),
    );
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
        'rewrite'           => false,
    );
    register_taxonomy( 'brb2_exercise_category', array( 'brb2-files' ), $args );
}

add_action( 'init', 'brb2_exercise_category', 0 );