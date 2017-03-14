(function($) {
    'use strict';
    //only for event
    if(typeof evenementcategorieIds === 'undefined'){
        return ;
    }  
    $(document).ready(function(){
        $('.file-download').each(function(){
            $(this).remove();
        });
        // Get the ul that holds the collection of evtActionProgres (readonly)
        appEvent.buildTable(true);
        $('#btn-modal').click(function(e){
            e.preventDefault();
            /**
             * Populate modal
             */
            appEvent.updateModalAbstractView();
            $('#modalAbstractEvent').modal('show');         
            return false;   
        });
        if(typeof evenementCategorieId !== 'undefined'){
            appEvent.updateViewForm(evenementCategorieId);
        } 
        $('.number').each(function(){
            $(this).parent().find('a').each(function(){
               $(this).hide();
            });
        });
        $('.decimal').each(function(){
            $(this).parent().find('a').each(function(){
               $(this).hide();
            });
        });
    });
    
})(jQuery);