$(function() {

    if ($('#purchased_land').length) {

        $('#form_create_purchased_land').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules:{
               'purchased_land[landOwnerName]':{
                    required: {
                            depends: function (element) {
                                return isPurchased();
                            }
                        }
                },
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


        $('.land_type').on('change',function () {

            var elm = $(this);
            var id = $(this).val();
            if(id=='PRIVATE'){
                jQuery('.govt_section').hide();
                jQuery('.purchased_section').show();
            }else{
                jQuery('.purchased_section').hide();
                jQuery('.govt_section').show();
            }

        }).change();

        jQuery(".isPurchased input[type='radio']").on('click', function(){

            var isPurchased= jQuery(".isPurchased input[type='radio']:checked").val();
            if(isPurchased==1){
                jQuery('.is_purchased').show();
            }else{
                jQuery('.is_purchased').hide();
            }
        });

        var isLeased= jQuery(".isLeased input[type='radio']:checked").val();
        if(isLeased==1){
            jQuery('.is_leased').show();
        }
        jQuery(".isLeased input[type='radio']").on('click', function(){

            var isLeased= jQuery(".isLeased input[type='radio']:checked").val();
            if(isLeased==1){
                jQuery('.is_leased').show();
            }else{
                jQuery('.is_leased').hide();
            }
        });

        function isPurchased()
        {
            return jQuery(".isPurchased input[type='radio']:checked").val() == 1;
        }

    }

    $("#ajax").on('click','#mouza_add_button',function (e) {


        var data = $('#form_create_mouza').serializeArray();
        $.ajax({
            url: Routing.generate('mouza_add'),
            data: data,
            type: "POST",
            dataType : "html",
            success: function( response ) {
                if(response=="SUCCESS"){

                    $('#ajax').modal('hide');

                    return ;
                }

                $( '#mod-content' ).html( response );


            }
        });

        return false;
    });


    $('#purchased_land').on('change','.mouza_list',function () {

        var elm = $(this);
        var id = $(this).val();


        if(id == ''){
            $(this).closest('tr').find('.dag_number_list option').remove();
            $(this).closest('tr').find('.dag_number_list').append('<option value="">Select</option>');
            return false;
        }
        getDagNumberByMouza(id, elm);

    }).change();


    $('#purchased_land').on('change','.dag_number_list',function () {
        removeDuplicateRecord();
        $('#record-list-dag').find('tr').removeClass('active_record');
        var dag_number_id = $(this).val();
        var active_tr = $(this).closest('tr');
        var mouza_id = $(this).closest('tr').find('.mouza_list').val() ;

        if(dag_number_id=='-1'){
            var target = Routing.generate('dag_number_add',{mouzaId:mouza_id});
            $(active_tr).addClass('active_record');

            $("#ajax .modal-body").load(target, function() {

                $("#ajax").modal("show");
            });
        }
    }).change();


    $("#ajax").on('click','#dag_number_add_button',function (e) {


        var data = $('#form_create_dag_number').serializeArray();
        var mouza_id = $("#ajax").find("#dag_number_mouza").val();
        var elm = $('#record-list-dag').find('.active_record').find('.mouza_list');
        $.ajax({
            url: Routing.generate('dag_number_add',{mouzaId:mouza_id}),
            data: data,
            type: "POST",
            dataType : "html",
            success: function( response ) {
                var succ_search = response.search("succ");

                if(succ_search!=-1)
                {

                    var res_parse =  JSON.parse(response);
                    var dagId = res_parse.newDagNumber;
                    if(res_parse.succ=="SUCCESS"){

                        $('#record-list-dag').find('tr').removeClass('active_record');

                        $('#ajax').modal('hide');

                        getDagNumberByMouza(mouza_id,elm, dagId);

                        return ;

                    }
                }

                $( '#mod-content' ).html( response );


            }
        });

        return false;
    });

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


    function getDagNumberByMouza(id, elm, dagId){

        $.ajax({
            url:Routing.generate('get_dagnumber_by_mouza',{id: id, dagId:dagId}),
            dataType: 'json'
        }).success(function ($msg) {

            elm.closest('tr').find('.dag_number_list option').remove();
            var totalOption = $msg.length;
            elm.closest('tr').find('.dag_number_list').append('<option value="">Select</option>');
            for (var i = 0; i < totalOption; i++) {
                elm.closest('tr').find('.dag_number_list').append($msg[i]);
            }
            elm.closest('tr').find('.dag_number_list').append('<option value="-1">Not Listed/Make Own Dag Number</option>');
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