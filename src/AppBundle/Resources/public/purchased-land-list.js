$(function() {

    $("#landType").on('change',function () {

        var elm = $(this);
        var id = $(this).val();
        if(id=='PRIVATE'){
            $('#is_leased').val('');
            //jQuery("#is_leased").val('');
            jQuery('.govt_section').hide();
            jQuery('.purchased_section').show();
        }else{
            $('#is_purchased').val('');
            //jQuery("#is_purchased").val('');
            jQuery('.purchased_section').hide();
            jQuery('.govt_section').show();
        }
    }).change();

});