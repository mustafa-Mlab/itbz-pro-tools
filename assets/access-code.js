"use strict";

(function($) {
  $(document).ready(function() {
    var ajaxurl = essentialData.ajaxurl;
    $('.regenarate-code').on('click', function(e){
        let accessCodeID = $(this).data('id');

        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'regenerate_access_code',
                access_code_id: accessCodeID
            },
            success: function(response) {
                // Handle the AJAX response
                location.reload();
            },
            error: function(error) {
                // Handle AJAX error
                console.log('Error: ' + error.statusText);
            }
        });
    })


    /**
     * When client click on forget password button
     */

    $('.forgot-password-button').on('click', function(e){
        e.preventDefault();
        $('.login-container').hide('slow');
        $('.forget-password-container').show('slow');
        $('.back-to-login-form').on('click', function(backEvent){
            backEvent.preventDefault();
            $('.login-container').show('slow');
            $('.forget-password-container').hide('slow');
        })
    });


    // Create an object to map checkbox values to column selectors
    const columnMap = {
        'order': '.order',
        'client_email': '.client_email',
        'sent_date': '.sent_date',
        'claimed_date': '.claimed_date',
    };
  
    const checkedColumns = {}; 
  
    $('.table-search-field #options .table_option input[type=checkbox]').change(function () {
        const checkboxValue = $(this).val();
        if (this.checked) {
            // Checkbox is checked, show the corresponding column
            $(`.code-management-table ${columnMap[checkboxValue]}`).show('slow');
            $(`.code-management-table ${columnMap[checkboxValue]}_data`).show('slow');
            checkedColumns[checkboxValue] = true; // Store the checked column
        } else {
            // Checkbox is unchecked, hide the corresponding column
            $(`.code-management-table ${columnMap[checkboxValue]}`).hide('slow');
            $(`.code-management-table ${columnMap[checkboxValue]}_data`).hide('slow');
            checkedColumns[checkboxValue] = false; // Store that the column is unchecked
        }
    });

    $('#search-input').on('input', function() {
        run_ajax_search_for_access_token();
    });
    

    function run_ajax_search_for_access_token(){
        var searchQuery = $('#search-input').val();

        let selectedOptions = $('.table-search-field #options .group_option input[type=checkbox]:checked');
        let search_by_params = "";
    
        selectedOptions.each(function () {
            search_by_params += $(this).val() + ",";
        });
        search_by_params = search_by_params.slice(0, -1);

        if (searchQuery.length >= 2 || searchQuery.length == 0) {
            $.ajax({
                url: ajaxurl, 
                type: 'POST',
                data: {
                    action: 'search_access_token',
                    search_query: searchQuery,
                    search_by : search_by_params,
                },
                success: function(response) {
                    if(response){
                        $('.code-management-table table tbody').html(response);
                        let tableOptons = $('.table-search-field #options .table_option input[type=checkbox]:checked');
                        tableOptons.each(function () {
                            let checkboxValue = $(this).val();
                            if (this.checked) {
                                $(`.code-management-table ${columnMap[checkboxValue]}`).show('slow');
                                $(`.code-management-table ${columnMap[checkboxValue]}_data`).show('slow');
                                checkedColumns[checkboxValue] = true; // Store the checked column
                            } else {
                                $(`.code-management-table ${columnMap[checkboxValue]}`).hide('slow');
                                $(`.code-management-table ${columnMap[checkboxValue]}_data`).hide('slow');
                                checkedColumns[checkboxValue] = false; // Store that the column is unchecked
                            }
                        });
                    
                    }
                }
            });
        } 
    }



    /**
     * For the repeter field
     */

    // Add new repeater field
    $('.add-repeater').on('click', function() {
        var $repeater = $(this).closest('.repeater-group');
        var $newRepeater = $repeater.clone();
        $newRepeater.find('select').val(''); // Clear the selected value
        $repeater.after($newRepeater);
    });

    // Remove repeater field
    $('body').on('click', '.remove-repeater', function() {
        $(this).closest('.repeater-group').remove();
    });

    $("#custom_forget_password").submit( function(e){
        e.preventDefault();
        let forgot_password_email = $("#forgot_password_email").val();
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
              action: 'reset_user_password',
              forgot_password_email: forgot_password_email,
            },
            success: function(response) {
              $('.notice').html(response);
              $('.login-container').show('slow');
              $('.forget-password-container').hide('slow');
            },
            
          });
    });


    if( $('.brb2-make-active').length){
        setTimeout(function() {
            if( ! $('.brb2-make-active a.osm-tab-active').length){
                $('.brb2-make-active>a:first').trigger('click');
            }
        }, 1000);
    }


  })
})(jQuery);