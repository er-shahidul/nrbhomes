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
                    console.log(response);
                    $('#ajax').modal('hide');
                    //$('#ajax').dialog('close');
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
        //alert($(this).closest('tr').find('.dag_number_list option'));
        if(id == ''){
            $(this).closest('tr').find('.dag_number_list option').remove();
            $(this).closest('tr').find('.dag_number_list').append('<option value="">Select</option>');
            return false;
        }
        $.ajax({
            url:Routing.generate('get_dagnumber_by_mouza',{id: id}),
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
    }).change();


});