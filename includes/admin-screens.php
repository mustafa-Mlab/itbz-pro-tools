<?php

// Hook into admin menu creation
add_action('admin_menu', 'itbz_access_code_management_create_admin_menu');

function itbz_access_code_management_create_admin_menu() {
  add_options_page(
    'Itbz Access Code Settings', // Page title
    'Itbz Access Code', // Menu title
    'manage_options', // Capability
    'itbz-access-code-settings', // Menu slug
    'itbz_access_code_settings_callback' // Callback function to display the settings page
  );
  add_submenu_page(
    'woocommerce',
    'Itbz Access code Mangement',
    'Itbz Access code management',
    'manage_options',
    'itbz_access_code_management',
    'itbz_access_code_management_render_page'
  );
}


function itbz_access_code_settings_callback() { ?>
<div class="wrap">
  <h2>Itbz Access Code Settings</h2>
  <form method="post" action="options.php">
    <?php
      settings_fields('itbz-access-code-settings-group');
      do_settings_sections('itbz-access-code-settings-group');
      submit_button();
    ?>
  </form>
</div>
<?php
}


function itbz_access_code_management_render_page() {
  require_once( ITBZ_ACCESS_CODE_MANAGEMENT_PATH . 'admin/management.php');
}


add_action('admin_init', 'itbz_access_code_settings_init');

function itbz_access_code_settings_init() {
  register_setting(
    'itbz-access-code-settings-group',
    'custom_login_page_slug'
  );

  register_setting(
    'itbz-access-code-settings-group',
    'custom_registration_page_slug'
  );

  add_settings_section(
    'itbz-access-code-section',
    'Itbz Access Code Settings',
    'itbz_access_code_section_callback',
    'itbz-access-code-settings-group'
  );

  add_settings_field(
    'itbz-access-code-login-field',
    'Select Custom Login Page',
    'itbz_access_code_login_field_callback',
    'itbz-access-code-settings-group',
    'itbz-access-code-section'
  );

  add_settings_field(
    'itbz-access-code-registration-field',
    'Select Custom Registration Page',
    'itbz_access_code_registration_field_callback',
    'itbz-access-code-settings-group',
    'itbz-access-code-section'
  );
}

function itbz_access_code_login_field_callback() {
  $login_page_slug = get_option('custom_login_page_slug');
  wp_dropdown_pages(array(
      'name' => 'custom_login_page_slug',
      'show_option_none' => 'Select a Page',
      'option_none_value' => '',
      'selected' => $login_page_slug,
  ));
}

function itbz_access_code_registration_field_callback() {
  $registration_page_slug = get_option('custom_registration_page_slug');
  wp_dropdown_pages(array(
      'name' => 'custom_registration_page_slug',
      'show_option_none' => 'Select a Page',
      'option_none_value' => '',
      'selected' => $registration_page_slug,
  ));
}




add_action('wp_ajax_deactivate_access_codes', 'deactivate_access_codes');
add_action('wp_ajax_nopriv_deactivate_access_codes', 'deactivate_access_codes');

function deactivate_access_codes() {
  // global $wpdb;
  $traning_db = get_training_db();
  $training_db_prefix = 'uvw_';
  $table_name = $training_db_prefix . ITBZ_ACCESS_CODE_TABLE;

  $access_code_ids = isset($_POST['access_code_ids']) ? $_POST['access_code_ids'] : array();

  if (empty($access_code_ids)) {
      wp_send_json_error('No access codes selected for deactivation.');
  }

  // Sanitize and prepare the access code IDs for the database query
  $access_code_ids = array_map('absint', $access_code_ids);

  // Update the 'access_code_status' field to 'deactivated' for the selected access codes
  // $table_name = $wpdb->prefix . 'itbz_access_code_transactions';

  foreach( $access_code_ids as $access_code_id){
    $updated_rows = $traning_db->update(
        $table_name,
        array('access_code_status' => 'deactivated'),
        array('ID' => $access_code_id),
        array('%s'),
        array('%d')
    );
  }
  wp_send_json_success('Access codes deactivated successfully.');
}

add_action('wp_ajax_activate_access_codes', 'activate_access_codes');
add_action('wp_ajax_nopriv_activate_access_codes', 'activate_access_codes');

function activate_access_codes() {
  // global $wpdb;
  $traning_db = get_training_db();
  $training_db_prefix = 'uvw_';
  $table_name = $training_db_prefix . ITBZ_ACCESS_CODE_TABLE;

  $access_code_ids = isset($_POST['access_code_ids']) ? $_POST['access_code_ids'] : array();

  if (empty($access_code_ids)) {
      wp_send_json_error('No access codes selected for activation.');
  }

  // Sanitize and prepare the access code IDs for the database query
  $access_code_ids = array_map('absint', $access_code_ids);

  // Update the 'access_code_status' field to 'active' for the selected access codes
  // $table_name = $wpdb->prefix . 'itbz_access_code_transactions';

  foreach( $access_code_ids as $access_code_id){
    $updated_rows = $traning_db->update(
        $table_name,
        array('access_code_status' => 'active'),
        array('ID' => $access_code_id),
        array('%s'),
        array('%d')
    );
  }
  wp_send_json_success('Access codes activated successfully.');
}