<?php

function itbz_pro_tools_activate() {
  itbz_pro_tools_create_tools_manager_role();
  // create_credit_transactions_table();
  // as_enqueue_async_action( 'create_tools_manager_role_hook' );
  // as_enqueue_async_action( 'create_credit_transactions_table_hook' );
  
}

function itbz_pro_tools_create_tools_manager_role() {
  global $wp_roles;

  if (!isset($wp_roles->roles['tools_manager'])) {
    $result = add_role(
      'tools_manager',  
      'Tools Manager',  
      array(
        'read' => true,
        'edit_posts' => true,
        'delete_posts' => true,
        'publish_posts' => true,
        'edit_others_posts' => true,
        'delete_others_posts' => true,
        'manage_categories' => true,
        'manage_exercise_tools' => true,  
      )
    );
  }
}


itbz_pro_tools_activate();
