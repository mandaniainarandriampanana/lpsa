(function($) {
    'use strict';
    $(document).ready(function(){
        $('#zone').selectmenu({
            change: function( event, ui ) {
                buildUrl(urlTemp);
                $.ajax({
                    url: (ui.item.value)?(urlAjaxWithId + '?id=' + ui.item.value):urlAjaxNoId,
                    dataType: 'json',
                    type: 'GET'
                }).done(function(data){
                    var options = '<option value=""></option>';
                    for( var i = 0; i < data.length ; i++){
                        options += '<option value="' + data[i].id + '">' + data[i].value + '</option>';
                    }
                    $('#site').empty().append(options);
                    $('#site').selectmenu("refresh");
                    
                });
            }
        });
        //ajax user declarant
        if(typeof objUserDeclarant !== 'undefined'){
            $('input[data-id=' + objUserDeclarant.data_id  + ']').autocomplete({
                source:function (request, response) {
                    var search = $("input[data-id=" + objUserDeclarant.data_id + "]").val();
                    var objData = 'search=' + search;
                    var url = objUserDeclarant.ajax_url;
                    $.ajax({
                        url: url,
                        dataType: "json",
                        data : objData,
                        type: 'POST',
                        success: function (data) {
                            response($.map(data, function (item) {
                                return item;
                            }));
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                },
                select: function( event, ui ){ 
                    $(objUserDeclarant.hidden_target).val(ui.item.id);
                }
            });
        }
    });
    function buildUrl(url){
        /* pour les champ dates */
            var $ChampDate=$("input.dateSearch");
            $ChampDate.each(function(){
                var name=$(this).attr('name');
                url+=name+"="+$(this).val()+"&";
            });
            
            /* pour les champ select */
            var $select=$("select option:selected");
            var lenSelect=$select.length;
            $select.each(function (k) {
                var name=$(this).parents('select').attr('name');
                if(k==lenSelect-1){
                    url+=name+"="+$(this).val();
                }else{
                    url+=name+"="+$(this).val()+"&";
                }
                });
            $("#submitForm").removeAttr("href");
            $("#submitForm").attr('href',url);
        }
})(jQuery);


