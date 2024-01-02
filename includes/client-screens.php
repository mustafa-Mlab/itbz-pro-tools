<?php

function custom_login_form_shortcode() {
  ob_start(); 
  $custom_registration_url = get_permalink( get_option('custom_registration_page_slug') );
  unset($_POST['forgot_password_email']);
  // Get the deafult URL Parameters, if parameters are not set up perfectly user do not get access to this url
  $client_email = isset($_GET['client_email']) ? sanitize_email($_GET['client_email']) : '';
  $access_code = isset($_GET['access_code']) ? sanitize_text_field($_GET['access_code']) : '';
  if( isset($client_email) && isset($access_code) && !empty($client_email) && !empty($access_code)){
    
    /**
     * Now checking if user is logged in or not
     * if a user is logged in already we need to get the guess date, so we will run logout and bring back to this page
     */
    if (is_user_logged_in()) {
      if (!is_admin()) {
        wp_logout();
        $custom_login_url = get_parmalink(get_option('custom_login_page_slug') );
        wp_redirect(home_url('/'. $custom_login_url .'/?access_code=' . $access_code .'&client_email=' . $client_email)); 
        exit;
      }
    }
  }else{
    wp_redirect(home_url()); 
    exit;
  }
   
   $isClaimed = (isset($_GET['status']) && !empty($_GET['status']))? 1: 0;  
  //  $gessDateRequired = ($isClaimed)? '' : 'required'; 
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2 text-center">
        <h1 class="headline">Welcome to Body Ready Method®</h1>
        <p class="customer-message">Please complete the information below to gain access to the Body Ready Birth Student Pack.</p>
        <p class="costumer-message2">If you already have access to other Body Ready programs with a different email, complete the information below, click login and then email <a href="mailto:support@bodyreadymethod.com">support@bodyreadymethod.com</a> and ask them to merge your two accounts.</p>
      </div>
    </div>
  </div>
  <div class="container mt-5 login-container">
    <div class="row justify-content-center">
      <div class="col-sm-3 d-none .d-sm-block"></div>
      <div class="col-12 col-sm-6">
        <div class="notice"></div>
        <?php
          if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['access_code']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['access_code']) ) {
            $username = sanitize_user($_POST['username']);
            $password = $_POST['password'];

            $access_code = sanitize_text_field($_POST['access_code']);
            ($isClaimed )? $guess_date = '' : $guess_date = sanitize_text_field($_POST['guess_date']);

            $access_code_details = get_access_code_details_by_access_code($access_code);

            // Create an array with user credentials
            $credentials = array(
              'user_login' => $username,
              'user_password' => $password,
              'remember' => isset($_POST['remember_me']),
            );
            
            // Authenticate the user
            $user = wp_signon($credentials);

            if (is_wp_error($user)) {
              echo '<p class="alert alert-danger">Login failed. Please check your credentials.</p>';             
            } else {
              $user_id = $user->ID;

              if(!$isClaimed){
                // First create the order
                if ( ! function_exists( 'wc_create_order' ) ) {
                  require_once( ABSPATH . 'wp-content/plugins/woocommerce/includes/wc-core-functions.php' );
                }
                
                // Create a new order instance
                $order = wc_create_order();
                
                // Get the product by its ID
                $product = wc_get_product( $access_code_details->associate_product_ID );
                
                // Add the product and customer to the order
                $order->set_customer_id( $user_id );
                $order->add_product( $product );
                
                // Set the order status to 'completed'
                // $order->set_status( 'pending' );
                
                // Set the order total to zero
                $order->set_total( 0 );
                
                // Save the order
                $order_id = $order->save();
                update_post_meta($order_id, 'access_code', $access_code);

                // Now add the guess date to client meta
                
                update_user_meta( $user_id, 'guess_date', $guess_date );

                // Now change the claim status of the acccess_code
                $traning_db = get_training_db();
                $training_db_prefix = 'uvw_';
                $table_name = $training_db_prefix . ITBZ_ACCESS_CODE_TABLE;
                
                $updated = $traning_db->update(
                  $table_name, 
                  array('claim_status' => 'claimed', 'claim_date' => current_time('mysql')),
                  array('access_code' => $access_code),
                  array('%s', '%s'),
                  array('%s')
                );
                
                // $order->set_status( 'completed' );
                if ($updated !== false) {
                  // Row updated successfully
                  echo 'Access code claimed successfully.';
                  $orderDetail = new WC_Order( $order_id );
                  $orderDetail->update_status("wc-completed", 'Completed', TRUE);
                } else {
                  // Error occurred
                  echo 'Failed to claim access code.';
                }
              }
              
              //Now as the order has been place let's redirect the user to the home page
              // Redirect to the home page
              wp_redirect(home_url());
              exit;
            }
          }
        ?>
        <form action="#" name="login-form" method="post">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="form-group">
            <label for="access_code">Access Code</label>
            <input type="text" readonly class="form-control" id="access_code" name="access_code" required>
          </div>
          <?php if(! $isClaimed ):?>
          <div class="form-group">
            <label for="guess_date">Guess Date</label>
            <input type="date" class="form-control" id="guess_date" name="guess_date" required >
          </div>
          <?php endif; ?>
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
            <label class="form-check-label" for="remember_me">Remember Me</label>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
          <div class="form-group text-center">
            <a href="#" class="text-secondary forgot-password-button">Forgot Password?</a>
          </div>
        </form>
        <p class="text-center">Don't have an account? <a class="singup-link" href="<?= $custom_registration_url;?>?access_code=<?= $_GET['access_code'];?>&client_email=<?= $_GET['client_email'];?>">Sing up here</a></p>
      </div>
    </div>
  </div>
  <div class="container mt-5 forget-password-container">
    <button class='btn-link back-to-login-form'>Back to login</button>
    <h2 class="text-center">Forgot Password</h2>
    <div class="row justify-content-center">
      <div class="col-sm-3 d-none .d-sm-block"></div>
      <div class="col-12 col-sm-6">
        <form action="#" name="forget-password-form" id="custom_forget_password" method="post">
          <div class="form-group">
            <label for="forgot_password_email">Email</label>
            <input type="email" class="form-control" id="forgot_password_email" name="forgot_password_email" required>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">Reset Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const accessCode = urlParams.get('access_code');
    const clientEmail = urlParams.get('client_email');

    // Populate the form fields
    document.getElementById('access_code').value = accessCode;
    document.getElementById('username').value = clientEmail;
});
</script>
<?php return ob_get_clean(); // End and return the buffered content
}
add_shortcode('custom_login_form', 'custom_login_form_shortcode');


function create_custom_login_page() {
// Generate a unique slug for the login page
$login_page_slug = 'custom-login-' . uniqid();

// Create the login page with the shortcode
$login_page_title = 'Custom Login Page';
$login_page_content = '[custom_login_form]';

$page_id = wp_insert_post(array(
'post_title' => $login_page_title,
'post_content' => $login_page_content,
'post_status' => 'publish',
'post_type' => 'page',
'post_name' => $login_page_slug,
));

// Save the page slug as an option
update_option('custom_login_page_slug', $login_page_slug);

// Return the URL of the custom login page
return get_permalink($page_id);
}


function custom_registration_form_shortcode() {
  $custom_login_url = get_permalink( get_option('custom_login_page_slug') );
  $form_html = '<div class="container mt-5">
    <h2 class="text-center">Registration</h2>
    <div class="row justify-content-center">
    <div class="col-sm-3 d-none .d-sm-block"></div>
      <div class="col-12 col-sm-6">
        <form action="" method="post">
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
          </div>
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
          </div>
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" readonly class="form-control" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
          </div>
          <div class="form-group">
            <label for="access_code">Access Code</label>
            <input type="text" readonly class="form-control" id="access_code" name="access_code" required>
          </div>
          <div class="form-group">
            <label for="guess_date">Guess Date</label>
            <input type="date" class="form-control" id="guess_date" name="guess_date" required>
          </div>
          <div class="form-group text-center">
            <button type="submit" name="custom_registration_submit" class="btn btn-primary">Register</button>
          </div>
        </form>
        <p class="text-center">Already have an account? <a class="singup-link" href="'. home_url() . '/login?acode=' .  $_GET['access_code'].'">Login here</a></p>
      </div>
    </div>
</div>';
$form_html .= "<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const accessCode = urlParams.get('access_code');
    const clientName = urlParams.get('client_name');
    const clientEmail = urlParams.get('client_email');

    // Populate the form fields
    document.getElementById('access_code').value = accessCode;
    document.getElementById('first_name').value = clientName;
    document.getElementById('email').value = clientEmail;
});
</script>";
return $form_html;
}
add_shortcode('custom_registration_form', 'custom_registration_form_shortcode');


function create_custom_registration_page() {
// Generate a unique slug for the registration page
$registration_page_slug = 'custom-registration-' . uniqid();

// Create the registration page with the shortcode
$registration_page_title = 'Custom registration Page';
$registration_page_content = '[custom_registration_form]';

$page_id = wp_insert_post(array(
'post_title' => $registration_page_title,
'post_content' => $registration_page_content,
'post_status' => 'publish',
'post_type' => 'page',
'post_name' => $registration_page_slug,
));

// Save the page slug as an option
update_option('custom_registration_page_slug', $registration_page_slug);

// Return the URL of the custom registration page
return get_permalink($page_id);
}

function reset_user_password(){
  $forgot_password_email = sanitize_email($_POST['forgot_password_email']);
  $new_password = wp_generate_password(12); // Generate a new password
  $user = get_user_by('email', $forgot_password_email);

  if ($user) {
    wp_set_password($new_password, $user->ID); // Set the new password
    // Send the new password to the user's email
    $to = $forgot_password_email;
    $subject = 'Password Reset';
    $message = 'Your new password: ' . $new_password;
    wc_mail($to, $subject, $message);
    echo '<p class="alert alert-success">Password reset successful. Check your email for the new password.</p>';
  } else {
    echo '<p class="alert alert-danger">No user found with that email address.</p>';
  }
  exit;
}

add_action('wp_ajax_reset_user_password', 'reset_user_password');
add_action('wp_ajax_nopriv_reset_user_password', 'reset_user_password');