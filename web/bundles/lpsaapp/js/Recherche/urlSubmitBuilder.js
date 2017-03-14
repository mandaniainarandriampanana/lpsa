(function($) {
    'use strict';
    $(document).ready(function(){
        $('.datepicker').on('change',function(){
            buildUrl(urlTemp);
        });
        $('#site').selectmenu({
            change: function( event, ui ) {
                buildUrl(urlTemp);
            }
        });
        $('#statut').selectmenu({
            change: function( event, ui ) {
                buildUrl(urlTemp);
            }
        });
        $('#evenementCategorie').selectmenu({
            change: function( event, ui ) {
                buildUrl(urlTemp);
            }
        });
        $('#responsableservice').selectmenu({
            change: function( event, ui ) {
                buildUrl(urlTemp);
            }
        });
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