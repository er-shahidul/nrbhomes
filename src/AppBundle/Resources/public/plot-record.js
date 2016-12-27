$(function() {

    if ($('#plot_record').length) {

        $('#form_create_plot').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules:{
                'plot_record[plotName]':"required",
                'plot_record[plotNumber]':"required",
                'purchased_land[paidAmount]': {
                    lessThan: '#purchased_land_totalAmount'
                }

            },
            highlight: function (element) {
                $(element)
                    .closest('.form-group').addClass('has-error');
            },

            unhighlight: function (element) {
                $(element)
                    .closest('.form-group').removeClass('has-error');
            },

            submitHandler: function (form) {
                form.submit();
            }
        });

        $("#add_more_owner").click(function(){
            $(".owner_info_panel").children().clone().appendTo(".add_owner_info_panel");
            $('.add_owner_info_panel .owner_panel_remove').removeClass('hidden');
        });

        $('.add_owner_info_panel').on('click','.owner_panel_remove',function(){
            $(this).parent().parent().remove();
        });

        $("#add_more_plot").click(function(){
            $(".plot_info_panel").children().clone().appendTo(".add_plot_info_panel");
            $('.add_plot_info_panel .plot_panel_remove').removeClass('hidden');
        });

        $('.add_plot_info_panel').on('click','.plot_panel_remove',function(){
            $(this).parent().parent().remove();
        });

        $('#add-dag').click(function (e) {
            e.preventDefault();
            addDag();
        });

        $('#record-list-dag').on('click', '.remove', function() {
            $(this).closest('tr').remove()
        });


        function addDag() {

            var newWidget = jQuery('#table-dag').attr('data-prototype').replace(/__name__/g, dagCount);
            dagCount++;
            jQuery('<tr></tr>').html(newWidget).appendTo($('#record-list-dag'));
        }


    }

    $('#plot_record').on('change','.mouza_list',function () {

        var elm = $(this);
        var id = $(this).val();


        if(id == ''){
            $(this).closest('tr').find('.dag_number_list option').remove();
            $(this).closest('tr').find('.dag_number_list').append('<option value="">Select</option>');
            return false;
        }
        getDagNumberByMouzaId(id, elm);

    }).change();


  /*  new SFileInput('doc_file',{
        button:'fileinput-new',
        allowedType:'image',
        selectedFileLabel:'selected_doc_file1',
        multipleFile:true,
        selectedFileClass:'selectedFileClass'
    });
*/
    $('.remove_document').on('click', function(e){
        e.preventDefault();
        var elm= $(this);
       var url = $(this).attr('href');
        $.ajax({
            url:url,
            dataType: 'json'
        }).success(function (response) {

            if(response.status=='SUCCESS'){

                elm.closest('tr').remove();
            }

            return false;
        });
    });


    function getDagNumberByMouzaId(id, elm){
//console.log('dad');
        $.ajax({
            url:Routing.generate('get_dagnumber_mouza_id',{id: id}),
            dataType: 'json'
        }).success(function ($msg) {

            elm.closest('tr').find('.dag_number_list option').remove();
            var totalOption = $msg.length;
            elm.closest('tr').find('.dag_number_list').append('<option value="">Select</option>');
            for (var i = 0; i < totalOption; i++) {
                elm.closest('tr').find('.dag_number_list').append($msg[i]);
            }
            //elm.closest('tr').find('.dag_number_list').append('<option value="-1">Not Listed/Make Own Dag Number</option>');
        });
    }
});