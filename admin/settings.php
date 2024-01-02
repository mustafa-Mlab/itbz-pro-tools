<?php
if (isset($_POST['itbz_access_code_management_selected_products'])) {
    update_option('itbz_access_code_management_selected_products', implode(',' , $_POST['itbz_access_code_management_selected_products']));
}

?>
  <div class="wrap">
      <h1>Select Access Code Products</h1>
      <form method="post" action="#">
          <?php
          settings_fields('itbz_access_code_management_options');
          do_settings_sections('itbz_access_code_management_settings');
          submit_button();
          ?>
      </form>
  </div>
  <?php