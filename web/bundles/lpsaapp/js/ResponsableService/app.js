(function($) {
    'use strict';
    
    $(document).ready(function(){
        if(typeof objDirection !== 'undefined'){
            onChangeDirection(objDirection);
        }
        if(typeof objDepartment !== 'undefined'){
            onChangeDepartement(objDepartment);
        }
    });
    
    /**
     * ajax select on change direction
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
                    $('.select-department').empty().html(options);
                    $('.select-department').selectmenu("refresh");
                });
            }
        });
    }
    
    /**
     * ajax select on change department
     * @param {objDirection} objTypeAjax
     * @returns {undefined}
     */
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
    }
})(jQuery);