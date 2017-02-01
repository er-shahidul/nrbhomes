var MouzaOption = function (){

    var multipleMouza = true;
    var multipleDagNumber = true;

    function init(param)
    {
        /*if (param !== undefined) {
            if ( param.hasOwnProperty('multipleMouza') ) {
                multipleMouza = param.multipleMouza;
            }
        }*/
        if (param !== undefined) {
            if ( param.hasOwnProperty('multipleDagNumber') ) {
                multipleDagNumber = param.multipleDagNumber;
            }
        }
        var select2UpozilaData = [];
        var select2Upozila = $('#dag_number_use_plot').select2(
            {
                id: function(e) {return e.id; },
                data:{results: select2UpozilaData, text:'text'},
                placeholder: 'নির্বাচন করুণ',
                formatSelection: formatResult,
                formatResult: formatResult,
                multiple: multipleDagNumber,
                allowClear: true
            });

        /*var select2MouzaData = [];
        var select2Mouza = $('.mo-mouza').select2(
            {
                id: function(e) {return e.id; },
                data:{results: select2MouzaData, text:'text'},
                //placeholder: 'নির্বাচন করুণ',
                formatSelection: formatResult,
                formatResult: formatResult,
                multiple: multipleMouza,
                allowClear: true
            });*/

        $("#mouza_use_plot").change(function() {

            $("#dag_number_use_plot").select2("val", "");
            var mouzaId = $(this).val();
            clearSelect2Fields([select2UpozilaData]);

            if(mouzaId != "") {

                $.ajax({
                    url: Routing.generate('get_dagnumber_uses_plot', {'mouzaId': mouzaId}),
                    type: "GET",
                    dataType : "json",
                    success: function( response ) {
                        unBlockContent();
                        for (var k in response) {
                            console.log(k, response[k]);
                            select2UpozilaData.push(response[k]);
                        }
                    },
                    error: function(){
                        unBlockContent();
                    },
                    beforeSend: function() {
                        blockContent();
                    }
                });
            }

            $("#dag_number_use_plot").change();
        }).change();

/*
        $(".mo-upozila").change(function(){

            if(!$(".mo-mouza").length) {
                return;
            }

            $(".mo-mouza").select2("val", "");
            var upozilaId = $(this).val();

            clearSelect2Fields([select2MouzaData]);
            if(upozilaId != "") {

                $.ajax({
                    url: Routing.generate('combo_mouza', {'type': 'upozila', 'id': upozilaId}),
                    type: "GET",
                    dataType : "json",
                    success: function( response ) {
                        unBlockContent();
                        for (var k in response) {
                            select2MouzaData.push(response[k]);
                        }
                    },
                    error: function() {
                        unBlockContent();
                    },
                    beforeSend: function() {
                        blockContent();
                    }
                });
            }

            $(".mo-mouza").change();

        }).change();*/

      /*  $(".mo-mouza").change(function() {

            if(!$(".mo-jlnumber").length && !$(".mo-survey-type").length) {
                return;
            }

            $("#jlno").val('');
            $("#jlnumberId").val('');
            var mouzaId = $(this).val();
            var surveyType = $(".mo-survey-type").select2("val");

            if(mouzaId != "") {
                $.get(Routing.generate('jlnumber_by_mouza', {'mouzaId': mouzaId, 'surveyType': surveyType}), function (response) {
                    if (response) {
                        $("#jlno").val(response.name);
                        $("#jlnumberId").val(response.id);
                    }
                });
            }

            if ($('#past-info').length) {
                $.get(Routing.generate('past_mouza_info', {'surveyType': surveyType, 'mouzaId' : mouzaId}), function (response) {
                    if (response) {
                        $('#past-thana').text(response)
                    }
                });
            }
        }).change();
*/
        function blockContent()
        {
            if ($('.block-group').length) {
                Metronic.blockUI({
                    target: $('.block-group'),
                    animate: true,
                    overlayColor: 'black'
                });
            }
        }

        function unBlockContent()
        {
            if ($('.block-group').length) {
                Metronic.unblockUI($('.block-group'));
            }
        }

        function clearSelect2Fields(fieldData) {
            for(var k in fieldData) {
                var last = fieldData[k].length;
                fieldData[k].splice(0, last);
            }
        }

        function formatResult(state) {
            if (!state.id) return state.text;
            return state.text;
        }
    }

    return {
        'init': init
    };
}();