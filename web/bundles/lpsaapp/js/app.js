(function($,window) {
    'use strict';
    
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;console.log(charCode);
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    
    function isDecimal(evt){
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((parseInt(charCode) === 44) || (parseInt(charCode) === 46)){
            return true;
        }
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    
    $(document).ready(function () {  
        $('.select-readonly').each(function(){
            var val = $(this).find(':selected').val();
            if(val || $(this).hasClass('select-readonly-strict')){
                $(this).find('option').each(function(){
                    $(this).not(":selected").attr("disabled", "disabled");                
                });                
            }
        });
        $('.datepicker-disable').each(function(){
            $(this).datepicker({
                showOn: "off"
            });
        });
        //can't press any button
        $(".readonly").on('keydown paste', function(e){
            e.preventDefault();
            return false;
        });
        //add attr required
        $(".select-required").attr('required',true);
        //default config
        $.datepicker.regional['fr'] = {
            closeText: 'Fermer',
            prevText: '&#x3c;Préc',
            nextText: 'Suiv&#x3e;',
            currentText: 'Aujourd\'hui',
            monthNames: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin',
                'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun',
                'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
            dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: '',
            numberOfMonths: 1,
            showButtonPanel: true,
            autoSize: true
        };
        $.datepicker.setDefaults($.datepicker.regional[ "fr" ]);
        //init datepicker
        $('.datepicker').datepicker();
    });
    //Icon calendar click
    $(document).on('click', '.calendar-datepicker', function () {
        if(!$(this).siblings('input').hasClass('datepicker-disable')){
            $(this).siblings('.datepicker').datepicker('show');            
        }
    });
    
    $(document).on('keypress','.number',function(e){
        return isNumber(e);
    });
    
    $(document).on('keypress','.decimal',function(e){
        return isDecimal(e);
    });
    
    $(document).on('keydown','.percent', function(e) {
        var field = $(this);
        var prevValue = field.val();
        setTimeout(function() {
            var value = field.val();
            // check if new value is more to 100 and less to 0
            if ((value < 0) || (value > 100)) {
                // fill with previous value
                field.val(prevValue);
            }

        }, 1);
    });
})(jQuery,window);