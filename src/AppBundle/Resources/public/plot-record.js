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


    $('#plot_record').on('change','.dag_number_list',function () {
        removeDuplicateRecord();
    }).change();

    new SFileInput('doc_file',{
        button:'fileinput-new',
        allowedType:'image',
        selectedFileLabel:'selected_doc_file1',
        multipleFile:true,
        selectedFileClass:'selectedFileClass'
    });

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


    function removeDuplicateRecord(){
        var el = {};
        $("#table-dag tr").each(function() {
            // get row
            var row = $(this);
            // get first and second td
            var first = row.find('td').find('.mouza_list').val();
            var second = row.find('td').find('.dag_number_list').val();
            // if exists, remove the tr
            if(el[first + second]) {

                alert('This row value is duplicate. So this row has been removed.');
                $(this).remove()
            }
            else {
                // if it does not exist, add it with some random val
                el[first + second] = 1;
            }
        });
    }
});