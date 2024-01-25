<?php
/**
 * @link    http://mkhossain.com/development/plugins/itbz-pro-tools
 * @package ITBZ_pro-tools
 * @since   1.0.0
 * @version 1.0.1
 * 
 * @wordpress-plugin
 * Plugin Name: ITBZ Pro Tools
 * Plugin URI: http://mkhossain.com/development/plugins/itbz-pro-tools
 * Description: This plugin will help to implement a feature inside our system that allows pro teachers to create, update, and share exercise tools with their clients using a credit system. 
 * Author: MD Mustafa Kamal Hossain	
 * Version: 1.0.1
 * Author URI: http://mkhossain.com
 * Text Domain: itbz-pro-tools
 * Domain Path: /languages
 */


 // Make sure we don't expose any info if called directly
if ( ! defined( 'ABSPATH' ) ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}


// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}

if ( ! defined( 'ITBZ_PRO_TOOLS_FILE' ) ) {
  define( 'ITBZ_PRO_TOOLS_FILE', __FILE__ );
}

if ( ! defined( 'ITBZ_PRO_TOOLS_PATH' ) ) {
  define( 'ITBZ_PRO_TOOLS_PATH', plugin_dir_path( ITBZ_PRO_TOOLS_FILE ));
}

if ( ! defined( 'ITBZ_PRO_TOOLS_DIR_URL' ) ) {
  define( 'ITBZ_PRO_TOOLS_DIR_URL',  plugin_dir_url( ITBZ_PRO_TOOLS_FILE ));
}


/**
 * Currently plugin version.
 */
define( 'ITBZ_PRO_TOOLS_VERSION', '1.0.1' );

/**
 * Define custom table name
 */
// define('ITBZ_PRO_TOOLS_TABLE', 'itbz_pro_tools_transactions');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/activator.php
 */
function activate_itbz_pro_tools() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/activator.php';
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/deactivator.php
 */
function deactivate_itbz_pro_tools() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/deactivator.php';
}

/**
 * The code that runs during plugin deletion.
 * This action is documented in includes/deletion.php
 */
function itbz_pro_tools_uninstall() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/deletion.php';
}

register_activation_hook( __FILE__, 'activate_itbz_pro_tools' );
register_deactivation_hook( __FILE__, 'deactivate_itbz_pro_tools' );
register_uninstall_hook(__FILE__, 'itbz_pro_tools_uninstall');

// Include necessary WordPress functions
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');



/** Add css and javascript file for frontend */
function enqueue_pro_tools_script() {
  wp_enqueue_style('pro-tools-styles', ITBZ_PRO_TOOLS_DIR_URL . 'assets/front-end.css', array(), '1.0');


  wp_enqueue_script('pro-tools-script', ITBZ_PRO_TOOLS_DIR_URL . 'assets/pro-tools.js' , array('jquery'), '1.0', true);

  // Localize the script to make 'ajaxurl' available in JavaScript
  wp_localize_script('pro-tools-script', 'essentialData', array(
    'ajaxurl' => admin_url('admin-ajax.php')
  ));
}
add_action('wp_enqueue_scripts', 'enqueue_pro_tools_script');

function enqueue_itbz_pro_tools_admin_js_css() {

  wp_enqueue_style('admin-part-css', ITBZ_PRO_TOOLS_DIR_URL . 'assets/admin-part.css', array(), '1.0');
  wp_enqueue_script('jquery');

  wp_enqueue_script('pro-tools-admin', ITBZ_PRO_TOOLS_DIR_URL . 'assets/admin-part.js' , array('jquery'), '1.0', true);

  // wp_enqueue_script('dataTables', 'https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js', array('jquery'), '1.10.24', true);
  // wp_enqueue_style('dataTables-css', 'https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css');
}
add_action('admin_enqueue_scripts', 'enqueue_itbz_pro_tools_admin_js_css');



require_once plugin_dir_path( __FILE__ ) . 'includes/pro-tools-post-type.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/pro-tools-taxonomy.php';
// require_once plugin_dir_path( __FILE__ ) . 'includes/pro-tools-page-meta-field.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/pro-tools-meta-fields.php';
// require_once plugin_dir_path( __FILE__ ) . 'includes/admin-screens.php';
// require_once plugin_dir_path( __FILE__ ) . 'includes/client-screens.php';


// Redirect Tools managers to home page while login
function redirect_tools_manager() {
  if ( current_user_can('tools_manager') && !is_admin() ) {
    wp_redirect( home_url() );
    exit;
  }
}

// Prevent Tools manager to login on admin panel
add_action( 'login_redirect', 'redirect_tools_manager' );
function prevent_tools_manager_admin_access() {
  if ( current_user_can('tools_manager') && is_admin() ) {
    wp_redirect( home_url() );
    exit;
  }
}
add_action( 'admin_init', 'prevent_tools_manager_admin_access' );

// making classic editor as deafult editor for exxercise tools post type

add_filter( 'gutenberg_use_widgets_block_editor_for_post_type', '__return_false', 10, 2 );

function pro_tools_classic_editor( $result, $post_type ) {
  if ( $post_type === 'exercise_tools' ) {
    return false;
  }
  return $result;
}
add_filter( 'gutenberg_use_widgets_block_editor_for_post_type', 'pro_tools_classic_editor', 10, 2 );


// function thelog($message) {
//   // Define the log file path
//   $log_file = WP_CONTENT_DIR . '/custom-log.txt';

//   // Create or open the log file for appending
//   $file_handle = fopen($log_file, 'a');

//   // Check if the file was opened successfully
//   if ($file_handle) {
//       // Create a timestamp
//       $timestamp = date('Y-m-d H:i:s');

//       // Format the log message with timestamp
//       $log_message = "[$timestamp] $message\n";

//       // Write the log message to the file
//       fwrite($file_handle, $log_message);

//       // Close the file
//       fclose($file_handle);
//   } else {
//       // Handle any errors, e.g., unable to open the file
//       error_log("Failed to open or create the log file: $log_file");
//   }
// }



// function get_training_db(){
//   return new wpdb(WP_OMT_DATABASE_USER, WP_OMT_DATABASE_PASSWORD, WP_OMT_DATABASE_NAME, WP_OMT_DATABASE_HOST);
// }


// Ensure WooCommerce is loaded
function check_woocommerce_for_pro_tools_product() {
  if (class_exists('WooCommerce')) {

    /**
     * Adding Custom product type for credit product
    */
    class WC_Product_Credit extends WC_Product_Simple {
      public function __construct($product) {
        $this->product_type = 'credit';
        $this->purchasable = true;
        $this->downloadable = false;
        $this->virtual = true;
        $this->sold_individually = true;
        $this->manage_stock = false;
        $this->supports[]   = 'ajax_add_to_cart';
        parent::__construct($product);
      }

      public function get_type() {
        return 'credit';
      }

      public function is_purchasable() {
        return true;  
      }

    }


    add_filter('product_type_selector', 'add_pro_tools_product_type');
    // add_filter('product_type_options', 'add_pro_tools_product_type');

    function add_pro_tools_product_type($types) {
        $types['credit'] = __('Credit', 'woocommerce');
        return $types;
    }

    function install_taxonomy_for_pro_tools_credit() {
      if ( ! get_term_by( 'slug', 'credit', 'product_type' ) ) {
        wp_insert_term( 'credit', 'product_type' );
      }
    }
    register_activation_hook( __FILE__, 'install_taxonomy_for_pro_tools_credit');

    /**
     * Adding associate_product field to keep track with credit amount
     */
    function add_credit_amount_field() {
      global $product_object;

      echo "<div class='options_group show_if_credit'>";
      woocommerce_wp_text_input(
        array(
          'id'          => '_credit_amount',
          'label'       => __( 'Credit Amount', 'itbz-pro-tools' ),
          'placeholder' => '10', 
          'desc_tip'    => true,
          'description' => __( 'Enter the number of credits to be added when this product is purchased.', 'your-plugin-textdomain' )
        )
      );
      echo "</div>";
    }

    add_action( 'woocommerce_product_options_pricing', 'add_credit_amount_field');

    // Generl Tab not showing up
    add_action( 'woocommerce_product_options_general_product_data', function(){
      echo '<div class="options_group show_if_credit clear"></div>';
    } );


    // add show_if_advanced calass to options_group
    function enable_product_js_for_credit_product() {
      global $post, $product_object;

      if ( ! $post ) { return; }

      if ( 'product' != $post->post_type ) :
        return;
      endif;

      $is_credit = $product_object && 'credit' === $product_object->get_type() ? true : false;

      ?>
      <script type='text/javascript'>
      jQuery(document).ready(function() {
          //for Price tab
          jQuery('#general_product_data .pricing').addClass('show_if_credit');
          jQuery('ul.product_data_tabs .inventory_options').addClass('show_if_credit');

          <?php if ( $is_credit ) { ?>
          jQuery('#general_product_data .pricing').show();
          jQuery('ul.product_data_tabs .inventory_options').show();
          <?php } ?>
      });
      </script>
      <?php
    }
    add_action( 'admin_footer', 'enable_product_js_for_credit_product');
    

    // Save the access code product data
    // function save_custom_product_data($product_id) {
    //   if (isset($_POST['_associated_product_id'])) {
    //       update_post_meta($product_id, '_associated_product_id', sanitize_text_field($_POST['_associated_product_id']));
    //   }
    // }
    // add_action('woocommerce_process_product_meta', 'save_custom_product_data');


    // Modify the product data tabs for the 'access_code' product type
    function credit_product_tabs($tabs) {

      global $post, $product_object;
      if ($product_object->is_type('credit')) {
        unset($tabs['shipping']);
        unset($tabs['attribute']);
        unset($tabs['advanced']);
        // unset($tabs['inventory']);
        unset($tabs['linked_product']);
        unset($tabs['Variations']);
      }
      return $tabs;
    }
    
    add_filter('woocommerce_product_data_tabs', 'credit_product_tabs');

    
    add_action( 'woocommerce_single_product_summary', 'credit_product_front' );

    // function credit_product_front () {
    //   global $product;
    //   if ( 'credit' == $product->get_type() ) { 
    //     echo( get_post_meta( $product->get_id(), '_associated_product_id' )[0] );
    //   }
    // }

    function add_pro_tools_product_type_support($product_types) {
      $product_types[] = 'credit';
      return $product_types;
    } 
  
    add_filter('woocommerce_product_supported_types', 'add_pro_tools_product_type_support');
  

  }
}
add_action('init', 'check_woocommerce_for_pro_tools_product');

/**
 * Creating a function which will fire while a order completed
 * This function meant to create access code and store it to database
 * @param int $order_id
 * @return void
 */
// function itbz_pro_tools_order_completed($order_id) {
//   // Get the order object
//   $order = wc_get_order($order_id);
//   $items = $order->get_items();

//   // Check if the order is valid and completed
//   if ($order && $order->get_status() === 'completed') {
//     foreach($items as $item){
//       $quantity = 0;
//       $product = $item->get_product();
//       if( $product->is_type('access_code') ){
//         $product_id = $item->get_product_id();
//         $quantity = $item->get_quantity();
//         $associate_product = get_post_meta($product_id, '_associated_product_id', true);
//         for ( $i =1; $i<= $quantity; $i++){
//           $teacher_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
//           $completed_date_time = $order->get_date_completed();
//           $access_code = md5('access code ' . $order_id . ' ' . $teacher_name . ' ' . $completed_date_time . ' ' . $i);

//           itbz_pro_tools_insert_coupon($access_code, $order_id, $associate_product);
//         }
//       }
//     }
//   }
// }


/**
 * Creating a helper function to insert new access code in database
 * @param string $access_code
 * @param int $order_id
 * @param int $associate_product
 * @return void
 */
// function itbz_pro_tools_insert_coupon($access_code, $order_id, $associate_product) {
//   global $wpdb;
//   $traning_db = get_training_db();
//   $training_db_prefix = 'uvw_';
//   $table_name = $training_db_prefix . ITBZ_PRO_TOOLS_TABLE;

//   $order = wc_get_order($order_id);

//   if ($order) {
//     // Get the customer ID associated with the order
//     $customer_id = $order->get_user_id();

//     if ($customer_id) {
//       $user = get_user_by('ID', $customer_id);
//       if ($user) {
//         $customer_email = $user->user_email;
//       }else{
//         $customer_email = 'demo@email.com';
//       }
//     }else{
//       $customer_id = 0;
//       $customer_email = 'demo@email.com';
//     }
//   }

  
  
  // Insert access code data into our custom table which is itbz_pro_tools_transactions
  // $newAccessCode = $traning_db->insert(
  //     $table_name,
  //     array(
  //         'access_code' => $access_code,
  //         'teacher_user_email' => $customer_email, 
  //         'access_code_creation_date' => current_time('mysql'),
  //         'order_ID' => $order_id,
  //         'associate_product_ID' => $associate_product
  //     ),
  //     array('%s', '%s', '%s', '%d', '%d')
  // );
  // $orderMeta = update_post_meta($order_id, 'access_code', $wpdb->insert_id);
// }

// Hook into WooCommerce order completed action
// add_action('woocommerce_order_status_completed', 'itbz_pro_tools_order_completed', 10, 1);


/** 
 * Creating a function to modify query vars
 * a custom param will be added in query vars as acode
 * @param array $vars
 * @return array $vars
 */
// function add_custom_query_var($vars) {
//   $vars[] = 'acode';
//   return $vars;
// }
// add_filter('query_vars', 'add_custom_query_var');


/** 
 * Creating a function to redirect client to login or registration page
 * The redirection will be happen depending on email existance in database
 * @param void
 * @return void
 */
// function handle_custom_registration_or_login() {
//   if (get_query_var('acode')) {
//     $access_code = sanitize_text_field(get_query_var('acode'));
    
//     $result = get_pro_tools_details_by_access_code($access_code);
//     $custom_login_url = get_permalink( get_option('custom_login_page_slug') );
    
//     if ($result) {
//       $client_email = $result->client_email;
//       $client_name = $result->client_name;
//       $sent_status = $result->sent_status;
//       $claim_status = $result->claim_status;
//       $access_code_status = $result->access_code_status;

//       $params = array(
//         'access_code' => $access_code,
//         'client_email' => $client_email,
//       );
//       $redirect_url = add_query_arg($params, $custom_login_url);  

//       if($sent_status === 'sent' && $claim_status == 'pending' && $client_name && $client_email && $access_code_status == 'active'){
//         $user_id = email_exists($client_email);
//         wp_redirect($redirect_url);
//         exit();
//       }elseif($sent_status === 'sent' && $claim_status == 'claimed'  && $client_name && $client_email && $access_code_status == 'active' ){
//         $params['status'] = 'claimed';
//         $redirect_url = add_query_arg($params, $custom_login_url);  
//         $user_id = email_exists($client_email);
//         wp_redirect($redirect_url);
//         exit();
//       }
//     } else {
//       wp_redirect($custom_login_url);
//     }
     
//   }
// }
// add_action('template_redirect', 'handle_custom_registration_or_login');


/**
 * Function to handle regestration form submission
 * @param void
 * @return void
 */
// function handle_custom_registration_form_submission() {
//   if (isset($_POST['custom_registration_submit'])) {
//       // Retrieve user input from the form
//       $first_name = sanitize_text_field($_POST['first_name']);
//       $last_name = sanitize_text_field($_POST['last_name']);
//       $email = sanitize_email($_POST['email']);
//       $username = sanitize_text_field($_POST['username']);
//       $password = sanitize_text_field($_POST['password']);
//       $confirm_password = sanitize_text_field($_POST['confirm_password']);
//       $access_code = sanitize_text_field($_POST['access_code']);
//       $guess_date = sanitize_text_field($_POST['guess_date']);

//       $access_code_details = get_pro_tools_details_by_access_code($access_code);

//       //check if email already exist 
//       $email_exist = email_exists($email);
//       $username_exists = email_exists($username);
//       if($email_exist || $username_exists){
//         return 0;
//       }else{
//         // $username = sanitize_user(current(explode('@', $email)), true);
//         // Generate a random password If needed
//         // $password = wp_generate_password();
  
//         // Create user data array
//         $user_data = array(
//           'first_name'    => $first_name,
//           'last_name'    => $last_name,
//           'user_email'    => $email,
//           'user_login'    => $username,
//           'user_pass'     => $password,
//         );
  
//         // Register the new user
//         $user_id = wp_insert_user($user_data);
  
//         if (!is_wp_error($user_id)) {
//           // Registration successful, log in the user
//           // wp_set_current_user($user_id);
//           // wp_set_auth_cookie($user_id);

//           // here we need to check the user_id is associate with the access code or not
//           //will do that later

//           // First create the order
//           if ( ! function_exists( 'wc_create_order' ) ) {
//             require_once( ABSPATH . 'wp-content/plugins/woocommerce/includes/wc-core-functions.php' );
//           }
          
//           // Create a new order instance
//           $order = wc_create_order();
          
//           // Get the product by its ID
//           $product = wc_get_product( $access_code_details->associate_product_ID );
          
//           // Add the product and customer to the order
//           $order->set_customer_id( $user_id );
//           $order->add_product( $product );
          
//           // Set the order status to 'completed'
//           // $order->set_status( 'completed' );
          
//           // Set the order total to zero
//           $order->set_total( 0 );
          
//           // Save the order
//            $order_id =$order->save();

//           //Add the access code in order meta to keep track which access code have been used to create this order.
//           update_post_meta($order_id, 'access_code', $access_code);


//           // Now add the guess date to client meta

//           update_user_meta( $user_id, 'guess_date', $guess_date );

//           // Now change the claim status of the acccess_code
//           $traning_db = get_training_db();
//           $training_db_prefix = 'uvw_';
//           $table_name = $training_db_prefix . ITBZ_PRO_TOOLS_TABLE;
          
//           $updated = $traning_db->update(
//             $table_name, 
//             array('claim_status' => 'claimed', 'claim_date' => current_time('mysql'), 'client_ID' => $user_id),
//             array('access_code' => $access_code),
//             array('%s', '%s', '%d'),
//             array('%s')
//           );
          
          
//           if ($updated !== false) {
            
//             echo 'Access code claimed successfully.';
//           } else {
//             // Error occurred
//             echo 'Failed to claim access code.';
//           }
//           $orderDetail = new WC_Order( $order_id );
//           $orderDetail->update_status("wc-completed", 'Completed', TRUE);
//           wp_redirect(home_url()); // Redirect to the home page
//           exit;
//         } else {
//           // Registration failed, display an error message
//           echo '<p class="text-danger">' . $user_id->get_error_message() . '</p>';
//         }

//       }

//   }
// }

// add_action('init', 'handle_custom_registration_form_submission');


/**
 * A helper function to get access code details by access code id
 * @param int Access code id
 * @return array that access code row from database
 */

// function get_pro_tools_details($access_code_id){
//   $traning_db = get_training_db();
//   $training_db_prefix = 'uvw_';
//   $table_name = $training_db_prefix . ITBZ_PRO_TOOLS_TABLE;
//   $query = $traning_db->prepare("
//       SELECT *
//       FROM $table_name
//       WHERE ID = %d
//   ", $access_code_id);
//   return $traning_db->get_row($query);
// }


// /**
//  * A helper function to get access code details by access_code
//  * @param string $access_code
//  * @return array That access code row from database table
//  */

// function get_pro_tools_details_by_access_code($access_code){
//   $traning_db = get_training_db();
//   $training_db_prefix = 'uvw_';
//   $table_name = $training_db_prefix . ITBZ_PRO_TOOLS_TABLE;
//   $query = $traning_db->prepare("
//       SELECT *
//       FROM $table_name
//       WHERE access_code = %s
//   ", $access_code);
//   return $traning_db->get_row($query);
// }


// function parseUserInputToDate($userInput) {
//   // Define an array of regular expressions to match common date formats
//   $dateFormats = array(
//       '/(\d{2}\/\d{2}\/\d{4})/',             // Format: DD/MM/YYYY
//       '/(\d{4}-\d{2}-\d{2})/',             // Format: YYYY-MM-DD
//       '/(\d{1,2}\/\d{1,2}\/\d{4})/',       // Format: D/M/YYYY or DD/M/YYYY or D/MM/YYYY
//       '/(\d{1,2}:\d{2}[apm]{2})/i',        // Format: H:MMam/pm
//       '/(\d{1,2}:\d{2})/'                  // Format: H:MM
//   );

//   // Define the corresponding date format for conversion
//   $dateFormat = array(
//       'Y-m-d',                            // Standardized format: YYYY-MM-DD
//       'm-d-Y',
//       'd/m/Y',                            // Standardized format: DD/MM/YYYY
//       'H:iA',                             // Standardized format: H:MMam/pm
//       'H:i'
//   );

  // Loop through the regular expressions and attempt to match them
  // foreach ($dateFormats as $index => $pattern) {
  //     if (preg_match($pattern, $userInput, $matches)) {
  //         // Use the matched date format for conversion
  //         $standardizedDate = date($dateFormat[$index], strtotime($matches[0]));
  //         return $standardizedDate;
  //     }
  // }

  // If no match is found, return an empty string or handle as needed
//   return '';
// }

/**
 * This part will define a new coupon code in woocomerce
 * the discount will be 100%
 * and the client email will be added in coupon's meta field
 * and it will be also associate with a access code
 * So that whenever a client sing up with a access code, the access code will be claimed
 * and a new woocomerce order will be placed with a kit as product, that time the associate coupon code will be applied in that order so that the total price of that order will be 0 and we will complete it automatically
 */

//  function create_custom_coupon() {
//   $coupon_code = $access_code ; 
//   $discount_type = 'percent';
//   $coupon_amount = 100; // 100% discount
//   $individual_use = true;
//   $coupon = array(
//       'post_title' => $coupon_code,
//       'post_content' => '',
//       'post_status' => 'publish',
//       'post_author' => 1, // Set to your desired author ID
//       'post_type' => 'shop_coupon',
//   );
//   $new_coupon_id = wp_insert_post($coupon);
//   update_post_meta($new_coupon_id, 'discount_type', $discount_type);
//   update_post_meta($new_coupon_id, 'coupon_amount', $coupon_amount);
//   update_post_meta($new_coupon_id, 'individual_use', $individual_use);
//   update_post_meta($new_coupon_id, 'client_email', $client_email);
//   update_post_meta($new_coupon_id, 'associate_access_code', $access_code_id);
// }
// add_action('init', 'create_custom_coupon');

/**Now check once the access code claimed 
 * I am not sure here if the cart hook is needded or not
 * i will fix that once i started on that part
*/
// function apply_custom_coupon($cart) {
//   if (is_admin() && !defined('DOING_AJAX')) return;

//   $coupon_code = 'CUSTOM100'; 
//   $expected_email = 'example@email.com';

//   $current_user = wp_get_current_user();
//   $user_email = $current_user->user_email;

//   // Check if the coupon code is applied and the email matches
//   if ($cart->has_discount($coupon_code) && $user_email === $expected_email) {
//       return;
//   }

//   // Apply the coupon if the email matches
//   if ($user_email === $expected_email) {
//       $cart->add_discount($coupon_code);
//   } else {
//       // Remove the coupon if the email doesn't match
//       $cart->remove_coupon($coupon_code);
//   }
// }
// add_action('woocommerce_before_calculate_totals', 'apply_custom_coupon');


/**
 * This part will be used in future
 */

 function remove_role_and_users($role_name) {

  // Get all users with the specified role
  $users = get_users(array('role' => $role_name));

  // Delete each user with the role
  foreach ($users as $user) {
    wp_delete_user($user->ID);
  }

  // Remove the role itself
  remove_role($role_name);

  echo 'Role ' . $role_name . ' and its users have been removed.';
}

// remove_role_and_users('exercise_tools_manager');  // the possible calling function 
