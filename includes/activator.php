<?php

function itbz_pro_tools_activate() {
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

  if ($result) {
    // Role created successfully
    echo 'Tools Manager role created successfully!';
  } else {
    // Role already exists
    echo 'Tools Manager role already exists.';
  }
}


itbz_pro_tools_activate();