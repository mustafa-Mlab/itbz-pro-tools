<?php
/**
 * @link    http://mkhossain.com/development/plugins/itbz-pro-tools
 * @package ITBZ_pro-tools
 * @since   1.0.0
 * @version 1.2.0
 * 
 * @wordpress-plugin
 * Plugin Name: ITBZ Pro Tools
 * Plugin URI: http://mkhossain.com/development/plugins/itbz-pro-tools
 * Description: This plugin will help to implement a feature inside our system that allows pro teachers to create, update, and share exercise tools with their clients using a credit system. 
 * Author: MD Mustafa Kamal Hossain	
 * Version: 1.2.0
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


// Hook your custom function to the custom hook
add_action('create_tools_manager_role_hook', 'create_tools_manager_role');
add_action('create_credit_transactions_table_hook', 'create_credit_transactions_table');

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

  function get_training_db_for_pro_tools(){
    return new wpdb(WP_OMT_DATABASE_USER, WP_OMT_DATABASE_PASSWORD, WP_OMT_DATABASE_NAME, WP_OMT_DATABASE_HOST);
  }


  // require_once plugin_dir_path( __FILE__ ) . 'includes/pro-tools-post-type.php';
// require_once plugin_dir_path( __FILE__ ) . 'includes/pro-tools-taxonomy.php';
// require_once plugin_dir_path( __FILE__ ) . 'includes/pro-tools-page-meta-field.php';
// require_once plugin_dir_path( __FILE__ ) . 'includes/pro-tools-meta-fields.php';
// require_once plugin_dir_path( __FILE__ ) . 'includes/admin-screens.php';
// require_once plugin_dir_path( __FILE__ ) . 'includes/client-screens.php';


// Register REST API endpoint for checking pro teacher status
add_action('rest_api_init', function () {
  register_rest_route('pro-tools-fc/v1', '/check_pro_teacher_status/', array(
      'methods' => 'GET',
      'callback' => 'check_pro_teacher_status_endpoint',
      'args' => array(
          'user_email' => array(
              'validate_callback' => function ($param, $request, $key) {
                  return is_email($param);
              },
              'required' => true,
          ),
      ),
  ));
});

// Callback function for the pro teacher status REST API endpoint
function check_pro_teacher_status_endpoint($data) {
  $user_email = sanitize_email($data['user_email']);
  $pro_teacher_status = check_if_pro_teachers_callback($user_email);

  return array(
      'user_email' => $user_email,
      'is_pro_teacher' => $pro_teacher_status,
  );
}

// Function to check if the user is a pro teacher
if (!function_exists('check_if_pro_teachers_callback')) {
  function check_if_pro_teachers_callback($user_email) {
    $pro_teacher = false;

    if (is_plugin_active('wp-fusion/wp-fusion.php')) {
        $user = get_user_by('email', $user_email);
        
        if ($user && in_array('[STATUS] Certified: BRM Pro', wpf_get_tags($user->ID)) || in_array('[STATUS] Eligible: BRM C1 Certification', wpf_get_tags($user->ID))) {
            $pro_teacher = true;
        }
    }

    return $pro_teacher;
  }
}


/**
 * A helper function to find out is the logged in user is a Pro teacher or not
 * @param void
 * @return bool 
 */

if (!function_exists('check_if_pro_teachers')) {
  function check_if_pro_teachers(){
    $pro_teacher = false;
    if (is_plugin_active('wp-fusion/wp-fusion.php')) {
      if (is_user_logged_in()) {
        // $user_id = get_current_user_id();
        $tags = wpf_get_tags();
        if(in_array('[STATUS] Certified: BRM Pro', $tags) || in_array('[STATUS] Eligible: BRM C1 Certification', $tags)){
          $pro_teacher = true;
        }
      }
      else{
        wp_redirect(home_url());
        exit();
      }
      return $pro_teacher;
    }
    
  }
}

// Register REST API endpoint for checking tools manager status
add_action('rest_api_init', function () {
  register_rest_route('pro-tools-fc/v1', '/check_tools_manager_status/', array(
      'methods' => 'GET',
      'callback' => 'check_tools_manager_status_endpoint',
      'args' => array(
          'user_email' => array(
              'validate_callback' => function ($param, $request, $key) {
                  return is_email($param);
              },
              'required' => true,
          ),
      ),
  ));
});

// Callback function for the tools manager status REST API endpoint
function check_tools_manager_status_endpoint($data) {
  $user_email = sanitize_email($data['user_email']);
  $tools_manager_status = if_tools_manager_callback($user_email);

  return $tools_manager_status;
}

// Function to check if the user is a tools manager
if (!function_exists('if_tools_manager_callback')) {
  function if_tools_manager_callback($user_email) {
    $is_tools_manager = false;

    $user = get_user_by('email', $user_email);

    if ($user && in_array('tools_manager', (array) $user->roles)) {
        $is_tools_manager = true;
    }

    return $is_tools_manager;
  }
}


/**
 * A helper function to find out is the logged in user is a tools managet or not
 * @param void
 * @return bool 
 */

 if (!function_exists('if_tools_manager')) {
  function if_tools_manager() {
    global $current_user;
    $user_id = get_current_user_id();
    if ( in_array( 'tools_manager', (array) $current_user->roles ) ) {
      return true; 
    } else {
      return false; 
    }
  }
}

// Redirect Tools managers to home page while login
function redirect_tools_manager() {
  if ( if_tools_manager() && !is_admin() ) {
    wp_redirect( home_url() );
    exit;
  }
}

// Prevent Tools manager to login on admin panel
add_action( 'login_redirect', 'redirect_tools_manager' );
function prevent_tools_manager_admin_access() {
  if ( if_tools_manager() && is_admin() ) {
    wp_redirect( home_url() );
    exit;
  }
}
add_action( 'admin_init', 'prevent_tools_manager_admin_access' );


// Ensure WooCommerce is loaded
function check_woocommerce_for_pro_tools_product() {
  if (class_exists('WooCommerce')) {

    /**
     * Adding Custom product type for credit product and packages
    */
    class WC_Product_Credit extends WC_Product_Simple {
      public function __construct($product) {
        parent::__construct($product);
        $this->product_type = 'credit';
      }
    
      public function get_type() {
        return 'credit';
      }
    
      public function is_purchasable() {
        return true;
      }
    
      // Add custom fields and data handling methods here
    }
    
    class WC_Product_Packages extends WC_Product_Simple {
      public function __construct($product) {
        parent::__construct($product);
        $this->product_type = 'packages';
      }
    
      public function get_type() {
        return 'packages';
      }
    
      public function is_purchasable() {
        return true;
      }
    
      // Add custom fields and data handling methods here
    }

    add_filter('product_type_selector', 'add_pro_tools_product_type');

    add_filter('woocommerce_get_product_types', function ($product_types) {
      $product_types['packages'] = __('Packages', 'itbz-access-code-management');
      $product_types['credit'] = __('Credit', 'itbz-access-code-management');
      return $product_types;
    });
    
    add_filter('woocommerce_product_object_class', function ($class, $product) {
      if ($product->get_type() === 'packages') {
        return 'WC_Product_Packages'; 
      }
      if ($product->get_type() === 'credit') {
        return 'WC_Product_Credit'; 
      }
      return $class;
    }, 10, 2);

    function add_pro_tools_product_type($types) {
        $types['credit'] = __('Credit', 'woocommerce');
        $types['packages'] = __('Packages', 'woocommerce');
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

    function install_taxonomy_for_packages_product_unique() {
      if (!get_term_by('slug', 'packages', 'product_type')) {
          wp_insert_term('packages', 'product_type');
      }
    }
    register_activation_hook(__FILE__, 'install_taxonomy_for_packages_product_unique');

      /**
      * Adding package_details field to keep track of package details
      */
      function add_package_details_field_unique() {
        global $product_object;

        echo "<div class='options_group show_if_packages'>";
        woocommerce_wp_text_input(
            array(
                'id' => '_package_details',
                'label' => __('Package Details', 'itbz-pro-tools'),
                'placeholder' => __('Enter package details', 'itbz-pro-tools'),
                'desc_tip' => true,
                'description' => __('Enter the details of the package.', 'your-plugin-textdomain')
            )
        );
        echo "</div>";
      }

    // add_action('woocommerce_product_options_pricing', 'add_package_details_field_unique');

    // General Tab not showing up
    add_action('woocommerce_product_options_general_product_data', function () {
      echo '<div class="options_group show_if_packages clear"></div>';
    });

    // Add show_if_packages class to options_group
    function enable_product_js_for_packages_product_unique() {
      global $post, $product_object;

      if (!$post) {
          return;
      }

      if ('product' != $post->post_type) :
          return;
      endif;

      $is_packages = $product_object && 'packages' === $product_object->get_type() ? true : false;

      ?>
      <script type='text/javascript'>
          jQuery(document).ready(function () {
              // for Price tab
              jQuery('#general_product_data .pricing').addClass('show_if_packages');

              <?php if ($is_packages) { ?>
              jQuery('#general_product_data .pricing').show();
              <?php } ?>
          });
      </script>
      <?php
    }
    add_action('admin_footer', 'enable_product_js_for_packages_product_unique');

    // Save the package_details product data
    function save_custom_product_data_unique($product_id) {
      if (isset($_POST['_package_details'])) {
          update_post_meta($product_id, '_package_details', sanitize_text_field($_POST['_package_details']));
      }
    }
    // add_action('woocommerce_process_product_meta', 'save_custom_product_data_unique');

    // Modify the product data tabs for the 'packages' product type
    function packages_product_tabs_unique($tabs) {
      global $post, $product_object;
      if ($product_object->is_type('packages')) {
          unset($tabs['shipping']);
          unset($tabs['attribute']);
          unset($tabs['advanced']);
          unset($tabs['linked_product']);
          unset($tabs['Variations']);
      }
      return $tabs;
    }
    add_filter('woocommerce_product_data_tabs', 'packages_product_tabs_unique');

    // add_action('woocommerce_single_product_summary', 'packages_product_front_unique');

    function packages_product_front_unique() {
      global $product;
      if ('packages' == $product->get_type()) {
          echo(get_post_meta($product->get_id(), '_package_details', true));
      }
    }

    function add_pro_tools_product_type_support_unique($product_types) {
      $product_types[] = 'packages';
      return $product_types;
    }
    add_filter('woocommerce_product_supported_types', 'add_pro_tools_product_type_support_unique');

  

  }
}
add_action('init', 'check_woocommerce_for_pro_tools_product');


// REST API endpoint to get all package products
add_action('rest_api_init', function () {
  register_rest_route('pro-tools-fc/v1', '/get_package_products/', array(
      'methods' => 'GET',
      'callback' => 'get_package_products_endpoint',
  ));
});

// Callback function for the get_package_products REST API endpoint
function get_package_products_endpoint() {
  $args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'tax_query' => array(
      array(
        'taxonomy' => 'product_type',
        'field' => 'slug',
        'terms' => array( 'packages' ),
      ),
    ),
  );

  $loop = new WP_Query( $args );
  $products_data = [];
  foreach( $loop->posts as $post){
    // $product = wc_get_product( $post->ID );
    $product_data = array(
        'id' => $post->ID,
        'name' => get_the_title($post->ID),
        'price' => get_post_meta($post->ID, '_price', true),
    );

    $products_data[] = $product_data;
  }

  return $products_data;
  
}

// REST API endpoint to purchase a package product
add_action('rest_api_init', function () {
  register_rest_route('pro-tools-fc/v1', '/purchase_package_product/', array(
      'methods' => 'POST',
      'callback' => 'purchase_package_product_endpoint',
      'args' => array(
          'user_email' => array(
              'validate_callback' => function ($param, $request, $key) {
                  return is_email($param);
              },
              'required' => true,
          ),
          'product_id' => array(
              'validate_callback' => 'is_numeric',
              'required' => true,
          ),
      ),
  ));
});

// Callback function for the purchase_package_product REST API endpoint
function purchase_package_product_endpoint($data) {
  $user_email = sanitize_email($data['user_email']);
  $product_id = intval($data['product_id']);

  $purchase_result = purchase_package_product($user_email, $product_id);

  return $purchase_result;
}


// Function to purchase a package product
function purchase_package_product($user_identifier, $product_id) {
  // Check if the function is called through the API or from inside the site
  $is_api_call = strpos($_SERVER['REQUEST_URI'], '/wp-json/pro-tools-fc/v1/') !== false;

  if ($is_api_call) {
      // If called through API, get user by email
      $user = get_user_by('email', $user_identifier);
  } else {
      // If called from inside the site, check the current user
      $user = is_user_logged_in() ? wp_get_current_user() : null;
  }

  if ($user) {
      $product = wc_get_product($product_id);

      // Check if the product is a package product
      if ($product && get_post_meta($product_id, '_package_product', true) === 'yes') {
          $credit_amount = $product->get_price(); // Assuming the price is the credit amount

          // Check if the user has enough credits
          $user_credits = get_user_meta($user->ID, '_user_credits', true);

          if ($user_credits >= $credit_amount) {
              // Create an order for the package product
              $order = wc_create_order(array(
                  'customer_id' => $user->ID,
                  'status' => 'completed',
              ));

              $order->add_product($product, 1); // Assuming quantity is 1
              $order->set_total(0); // Set the order total to zero
              $order->calculate_totals();

              // Update user credits
              update_user_meta($user->ID, '_user_credits', $user_credits - $credit_amount);
              update_user_meta($user->ID, '_package_name', get_the_title($product_id));
              update_user_meta($user->ID, '_package_purchase_date', current_time('mysql'));
              update_user_meta($user->ID, '_package_id', $product_id);

              // Add a transaction record for the purchase
              add_credit_transaction($user->user_email, $credit_amount, 'purchase', 'Package Purchase');

              return array(
                  'success' => true,
                  'message' => 'Package purchased successfully!',
              );
          } else {
              return array(
                  'success' => false,
                  'message' => 'Insufficient credits to purchase the package.',
              );
          }
      } else {
          return array(
              'success' => false,
              'message' => 'Invalid package product.',
          );
      }
  } else {
      return array(
          'success' => false,
          'message' => 'User not found.',
      );
  }
}


/**
 * Creating a function which will fire while a order completed
 * This function meant to to add credit to user account by updating databse
 * @param int $order_id
 * @return void
 */

 // Hook to execute when an order is completed
 add_action('woocommerce_order_status_completed', 'record_credit_purchase', 10, 1);

 // Function to record credit purchase transaction
 function record_credit_purchase($order_id) {
     $order = wc_get_order($order_id);
 
     // Check if the order is valid and completed
     if ($order && $order->is_completed()) {
         // Loop through order items
         foreach ($order->get_items() as $item_id => $item) {
             // Get product ID and quantity
             $product_id = $item->get_product_id();
             $quantity = $item->get_quantity();
 
             // Check if the product is a credit product (adjust product type or other conditions as needed)
             if (is_credit_product($product_id)) {
                 // Add entry to credit transactions table
                 add_credit_transaction($order->get_billing_email(), $quantity, 'purchase');
                 add_user_credits($order->get_billing_email(),  $quantity );
             }
         }
     }
 }
 
 // Function to check if a product is a credit product (modify as needed)
 function is_credit_product($product_id) {
     $product = wc_get_product($product_id);
     return $product && $product->is_type('credit');
 }
 
 // Function to add entry to credit transactions table
 function add_credit_transaction($user_email, $credits_amount, $transaction_type) {
     global $wpdb;
 
     $table_name = $wpdb->prefix . 'credit_transactions';
 
     // Insert new transaction record
     $wpdb->insert(
         $table_name,
         array(
             'user_email' => $user_email,
             'credits_amount' => $credits_amount,
             'transaction_date' => current_time('mysql'),
             'transaction_type' => $transaction_type,
         ),
         array('%s', '%d', '%s', '%s')
     );
 }
 
// Function to record credit expenditure transaction
function record_credit_expenditure($user_email, $credits_amount) {
  GLOBAL $wpdb;

  $table_name = $wpdb->prefix . 'credit_transactions';

  // Insert new expenditure transaction record
  $wpdb->insert(
      $table_name,
      array(
          'user_email' => $user_email,
          'credits_amount' => -$credits_amount, // Negative value for expenditure
          'transaction_date' => current_time('mysql'),
          'transaction_type' => 'expenditure',
      ),
      array('%s', '%d', '%s', '%s')
  );
  subtract_user_credits($user_email, $credits_amount );
}


// Function to subtract user credits
function subtract_user_credits($user_email, $credit_amount) {
  $user = get_user_by('email', $user_email);

  if ($user) {
      $user_credits = get_user_meta($user->ID, '_user_credits', true);

      // If user_credits meta doesn't exist, create it
      if ($user_credits === '') {
          add_user_meta($user->ID, '_user_credits', 0);
      } else {
          update_user_meta($user->ID, '_user_credits', max(0, $user_credits - $credit_amount));
      }

      return true;
  } else {
      return false;
  }
}

// Function to add user credits
function add_user_credits($user_email, $credit_amount) {
  $user = get_user_by('email', $user_email);

  if ($user) {
      $user_credits = get_user_meta($user->ID, '_user_credits', true);

      // If user_credits meta doesn't exist, create it
      if ($user_credits === '') {
          add_user_meta($user->ID, '_user_credits', $credit_amount);
      } else {
          update_user_meta($user->ID, '_user_credits', $user_credits + $credit_amount);
      }

      return true;
  } else {
      return false;
  }
}





/**
 * This part will be used in future
 */

//  function remove_role_and_users($role_name) {
//   $users = get_users(array('role' => $role_name));

//   // Delete each user with the role
//   foreach ($users as $user) {
//     wp_delete_user($user->ID);
//   }

//   // Remove the role itself
//   remove_role($role_name);

//   echo 'Role ' . $role_name . ' and its users have been removed.';
// }

// remove_role_and_users('exercise_tools_manager');  // the possible calling function 
 