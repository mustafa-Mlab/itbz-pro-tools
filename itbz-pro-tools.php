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
function itbz_pro_tools_uninstall_for_traning() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/deletion.php';
}

register_activation_hook( __FILE__, 'activate_itbz_pro_tools' );
register_deactivation_hook( __FILE__, 'deactivate_itbz_pro_tools' );
register_uninstall_hook(__FILE__, 'itbz_pro_tools_uninstall_for_traning');

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
}
add_action('admin_enqueue_scripts', 'enqueue_itbz_pro_tools_admin_js_css');


function itbz_pro_tools_get_training_db(){
  return new wpdb(WP_OMT_DATABASE_USER, WP_OMT_DATABASE_PASSWORD, WP_OMT_DATABASE_NAME, WP_OMT_DATABASE_HOST);
}



// Redirect Tools managers to home page while login
// function redirect_tools_manager() {
//   if ( if_tools_manager() && !is_admin() ) {
//     wp_redirect( home_url() );
//     exit;
//   }
// }

// // Prevent Tools manager to login on admin panel
// add_action( 'login_redirect', 'redirect_tools_manager' );
// function prevent_tools_manager_admin_access() {
//   if ( if_tools_manager() && is_admin() ) {
//     wp_redirect( home_url() );
//     exit;
//   }
// }
// add_action( 'admin_init', 'prevent_tools_manager_admin_access' );


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
          'placeholder' => '', 
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

    function credit_product_front () {
      global $product;
      if ( 'credit' == $product->get_type() ) { 
        echo( get_post_meta( $product->get_id(), '_credit_amount', true ) );
      }
    }

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

    // Save the credit amount 
    function save_custom_product_data_unique($product_id) {
      if (isset($_POST['_credit_amount'])) {
          update_post_meta($product_id, '_credit_amount', sanitize_text_field($_POST['_credit_amount']));
      }
    }
    add_action('woocommerce_process_product_meta', 'save_custom_product_data_unique');

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



/**
 * Creating a function which will fire while a order completed
 * This function meant to to add credit to user account by updating databse
 * @param int $order_id
 * @return void
 */

 // Hook to execute when an order is completed
 add_action('woocommerce_order_status_completed', 'itbz_pro_tools_record_credit_purchase', 10, 1);

 // Function to record credit purchase transaction
 function itbz_pro_tools_record_credit_purchase($order_id) {
     $order = wc_get_order($order_id);
 
     // Check if the order is valid and completed
     if ($order) {
         // Loop through order items
         foreach ($order->get_items() as $item_id => $item) {
             // Get product ID and quantity
             $product_id = $item->get_product_id();
             $quantity = $item->get_quantity();
             
             $credit_amount = get_post_meta($product_id, '_credit_amount', true);
 
             // Check if the product is a credit product (adjust product type or other conditions as needed)
             if (itbz_pro_tools_is_credit_product($product_id)) {
                 // Add entry to credit transactions table
                 /**we will call the api to entry this transection, transection will be recored in traning site. */
                 $traning_db = itbz_pro_tools_get_training_db();
                 $training_db_prefix = 'uvw_';
                 $table_name = $training_db_prefix . 'itbz_pro_tools_credit_transactions';
                 $result = $traning_db->insert(
                  $table_name,
                  array(
                      'user_email' => $order->get_billing_email(),
                      'credits_amount' => $credit_amount,
                      'transaction_date' => current_time('mysql'),
                      'transaction_type' => 'purchase',
                      'order_id' => $order->ID,
                  ),
                  array('%s', '%d', '%s', '%s', '%d')
                );
                if($result == false){
                  return false;
                }
                
             }
         }
     }
 }
 
 // Function to check if a product is a credit product (modify as needed)
 function itbz_pro_tools_is_credit_product($product_id) {
     $product = wc_get_product($product_id);
     return $product && $product->is_type('credit');
 }


 add_action('woocommerce_order_status_completed', 'itbz_pro_tools_record_package_purchase', 10, 1);

 function itbz_pro_tools_record_package_purchase($order_id) {
  $order = wc_get_order($order_id);

  // Check if the order is valid and completed
  if ($order) {
      // Loop through order items
      foreach ($order->get_items() as $item_id => $item) {
          // Get product ID and quantity
          $product_id = $item->get_product_id();

          if (itbz_pro_tools_is_package_product($product_id)) {
            $traning_db = itbz_pro_tools_get_training_db();
            $training_db_prefix = 'uvw_';
            $table_name = $training_db_prefix . 'itbz_pro_tools_package_track';

            $today = date('Y-m-d'); 
            $package_exp_date = date('Y-m-d', strtotime('+1 year', strtotime($today)));
            $success = $traning_db->insert(
              $table_name,
              array(
                'user_email' => $order->get_billing_email(),
                'package_id' => $product_id,
                'package_exp_date' => $package_exp_date,
                'order_id' => $order->ID,
                'package_status' => 1
              ),
              array(
                '%s',
                '%d',
                '%s',
                '%d',
                '%d',
              )
            );
          }
      }
  }
}

function itbz_pro_tools_is_package_product($product_id) {
  $product = wc_get_product($product_id);
  return $product && $product->is_type('packages');
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
 