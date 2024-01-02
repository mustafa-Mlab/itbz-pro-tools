"use strict";

(function($) {
  $(document).ready(function() {
    /**
     * For the repeter field
     */
    
    function showHideRepeterField(){
        if($('.edit-post-post-template__dropdown button.edit-post-post-template__toggle').length || $("#page_template").length  ){
            let template = '';
            if( !$('.edit-post-post-template__dropdown button.edit-post-post-template__toggle').length){
                template = $("#page_template").val();
            }else{
                template = $('.edit-post-post-template__dropdown button.edit-post-post-template__toggle').text();
            }
            if( template === "BR Birth Two" || template === 'page-br-birth-2-10-10-2023.php'){
                $('#brb_2_page_meta').show();
            }else{
                $('#brb_2_page_meta').hide();
            }
        }else{
            setTimeout(showHideRepeterField, 1000)
        }
        
    }
    function showRemoveButton(){
        if ( $('.remove-repeater'). length >1){
            $('.remove-repeater').show();
        }else{
            $('.remove-repeater').hide();
        }
    }
    $('.add-repeater').on('click', function() {
        let targetClass= $(this).data('object');
        var $repeaterContainer = $('.repeater-container.' + targetClass);
        var $newRepeaterGroup = $repeaterContainer.find('.repeater-group').first().clone();
        $newRepeaterGroup.find('select').val(''); // Clear the selected value
        $repeaterContainer.append($newRepeaterGroup);
        showRemoveButton();
    });


    // Remove repeater field
    $('body').on('click', '.remove-repeater', function() {
        $(this).closest('.repeater-group').remove();
        showRemoveButton();
    });

    showRemoveButton();
    showHideRepeterField();

  })
})(jQuery);