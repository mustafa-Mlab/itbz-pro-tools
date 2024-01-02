<?php

$traning_db = get_training_db();
$training_db_prefix = 'uvw_';
$table_name = $training_db_prefix . ITBZ_ACCESS_CODE_TABLE;

// Retrieve data from the custom table
$data = $traning_db->get_results("SELECT * FROM $table_name");

echo '<table class="widefat dataTable" data-page-length="30">';
echo '<thead>';
echo '<tr>';
echo '<th></th>';
echo '<th>ID</th>';
echo '<th>Access Code</th>';
echo '<th>Access Code Status</th>';
echo '<th>Teacher User</th>';
echo '<th>Access Code Creation Date</th>';
echo '<th>Sent Status</th>';
echo '<th>Sent Date</th>';
echo '<th>Client Email</th>';
echo '<th>Client Name</th>';
echo '<th>Claim Status</th>';
echo '<th>Claim Date</th>';
echo '<th>Order ID</th>';
echo '<th>Client ID</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

foreach ($data as $row) {
    echo '<tr>';
    echo '<td><input type="checkbox" name="access_code_ids[]" value="' . $row->ID . '"></td>';
    echo '<td>' . $row->ID . '</td>';
    echo '<td>' . $row->access_code . '</td>';
    echo '<td class="sorting">' . $row->access_code_status . '</td>';
    $teacher_data = get_user_by('email', $row->teacher_user_email);
    echo '<td><a href="' . get_edit_user_link($teacher_data->ID) . '">' . $teacher_data->display_name . '</a></td>';
    echo '<td>' . $row->access_code_creation_date . '</td>';
    echo '<td>' . $row->sent_status . '</td>';
    echo '<td>' . $row->sent_date . '</td>';
    echo '<td>' . $row->client_email . '</td>';
    echo '<td>' . $row->client_name . '</td>';
    echo '<td>' . $row->claim_status . '</td>';
    echo '<td>' . $row->claim_date . '</td>';
    echo '<td><a href="' . admin_url('post.php?post=' . $row->order_ID . '&action=edit') . '">' . $row->order_ID . '</a></td>';
    echo '<td>' . $row->client_ID . '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

echo '<button id="deactivate-button">Deactivate Selected</button>&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<button id="activate-button">Activate Selected</button>';

?>
<script>
    jQuery(document).ready(function($) {
    // Handle the "Deactivate" button click event
    $('#deactivate-button').on('click', function() {
        // Get the selected access code IDs
        var selectedIds = $('input[name="access_code_ids[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        // Check if any checkboxes are selected
        if (selectedIds.length === 0) {
            alert('Please select access codes to deactivate.');
            return;
        }

        // Send an AJAX request to deactivate the selected access codes
        $.ajax({
            url: ajaxurl, // Use the WordPress AJAX URL
            type: 'POST',
            data: {
                action: 'deactivate_access_codes',
                access_code_ids: selectedIds
            },
            success: function(response) {
              location.reload();
            },
        });
    });

    $('#activate-button').on('click', function() {
        var selectedIds = $('input[name="access_code_ids[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        // Check if any checkboxes are selected
        if (selectedIds.length === 0) {
            alert('Please select access codes to activate.');
            return;
        }

        // Send an AJAX request to deactivate the selected access codes
        $.ajax({
            url: ajaxurl, // Use the WordPress AJAX URL
            type: 'POST',
            data: {
                action: 'activate_access_codes',
                access_code_ids: selectedIds
            },
            success: function(response) {
              location.reload();
            },
        });
    });
});

    jQuery(document).ready(function($) {
    $('.dataTable').DataTable();
    });
</script>
<?php