(function($) {
    'use strict';
    $(document).ready(function(){
        if(typeof objDirection !== 'undefined'){
            fillDepartementSelect(objDirection);
            onChangeDirection(objDirection);
        }
        if(typeof objDepartement!== 'undefined'){
            onChangeDepartement(objDepartement);
        }
    });
    
    /**
     * ajax select on change Direction
     * 
     * @param {objDirection} objTypeAjax
     * @returns {undefined}
     */
    function onChangeDirection(objTypeAjax){
        $(objTypeAjax.js_selector).selectmenu({
            change: function( event, ui ) {
                $.ajax({
                    url: objTypeAjax.ajax_url + '?id=' + ui.item.value,
                    dataType: 'json',
                    type: 'GET'
                }).done(function(data){
                    var options = '<option value=""></option>';
                    for( var i = 0; i < data.length ; i++){
                        options += '<option value="' + data[i].id + '">' + data[i].value + '</option>';
                    }
                    $('.select-departement').empty().html(options);
                    $('.select-departement').selectmenu("refresh");
                    $('.select-service').empty().html('<option value=""></option>');
                    $('.select-service').selectmenu("refresh");
                });
            }
        });
        if(objTypeAjax.js_data){
            $(objTypeAjax.js_selector).val(objTypeAjax.js_data);  
            $(objTypeAjax.js_selector).selectmenu("refresh");            
        }
    }
    function onChangeDepartement(objTypeAjax){
        $(objTypeAjax.js_selector).selectmenu({
            change: function( event, ui ) {
                $.ajax({
                    url: objTypeAjax.ajax_url + '?id=' + ui.item.value,
                    dataType: 'json',
                    type: 'GET'
                }).done(function(data){
                    var options = '<option value=""></option>';
                    for( var i = 0; i < data.length ; i++){
                        options += '<option value="' + data[i].id + '">' + data[i].value + '</option>';
                    }
                    $('.select-service').empty().html(options);
                    $('.select-service').selectmenu("refresh");
                });
            }
        });
        if(objTypeAjax.js_data){
            $(objTypeAjax.js_selector).val(objTypeAjax.js_data);  
            $(objTypeAjax.js_selector).selectmenu("refresh");            
        }
    }
    function fillDepartementSelect(objDirection){
        var idDirection=$('.select-direction').val();
        var idDepartement=$('.select-departement').val();
        if(idDepartement==='undefined' || idDepartement===null || idDepartement===""){
            $.ajax({
                    url: objDirection.ajax_url + '?id=' +idDirection,
                    dataType: 'json',
                    type: 'GET'
                }).done(function(data){
                    var options = '<option value=""></option>';
                    for( var i = 0; i < data.length ; i++){
                        options += '<option value="' + data[i].id + '">' + data[i].value + '</option>';
                    }
                    $('.select-departement').empty().html(options);
                    $('.select-departement').selectmenu("refresh");
                    $('.select-service').empty().html('<option value=""></option>');
                    $('.select-service').selectmenu("refresh");
                });
            }
    }
})(jQuery);