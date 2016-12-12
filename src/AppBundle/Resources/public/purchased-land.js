$(function() {

    if ($('#purchased_land').length) {

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
});