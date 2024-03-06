<?php

function itbz_pro_tools_activate() {
  // create_credit_transactions_table();
  // as_enqueue_async_action( 'create_tools_manager_role_hook' );
  // as_enqueue_async_action( 'create_credit_transactions_table_hook' );
  
}

function create_tools_manager_role() {
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


// Create custom table for credit transactions
// function create_credit_transactions_table() {
//   global $wpdb;

//   // $table_name = $wpdb->prefix . 'credit_transactions';
//   $table_name = $wpdb->prefix . 'itbz_pro_tools_credit_transactions';

//   $charset_collate = $wpdb->get_charset_collate();

//   $sql = "CREATE TABLE $table_name (
//       transaction_id bigint(20) NOT NULL AUTO_INCREMENT,
//       user_email varchar(100) NOT NULL,
//       credits_amount int NOT NULL,
//       transaction_date datetime NOT NULL,
//       transaction_type varchar(20) NOT NULL, 
//       PRIMARY KEY  (transaction_id)
//   ) $charset_collate;";

//   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
//   dbDelta($sql);
// }



itbz_pro_tools_activate();
