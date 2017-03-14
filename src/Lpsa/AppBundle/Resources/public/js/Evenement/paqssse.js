(function($) {
    'use strict';
    $(document).ready(function(){
        //traitement affichage de la formulaire Paqssse
        if(!$('#evenement_isPaqssse').is(':checked')){
            $('.formular_paqssse').hide();
        }
        if(abstractGravityValue >= paq3seGravity && isEditEvent){
            $('.formular_paqssse').show();
            $('#evenement_paq3se_realisation').addClass('required');
            $('#evenement_paq3se_frequence').addClass('required');
            $('#evenement_paq3se_anomalieConstate').addClass('required');
        }
        $('#evenement_isPaqssse').on('click',function(){            
            if(!$('#evenement_isPaqssse').is(':checked')){
                $('.formular_paqssse').hide();
            } else {
                $('.formular_paqssse').show();
            }
        });
        // remplissage gravité,priorité et niveau de risque
        $('#evenement_paq3se_frequence').keyup(function(){
            completePaqssse();
        });
        $('#evenement_paq3se_gravite').selectmenu({
            change: function( event, ui ) {
                completePaqssse();
            }
        });
        //desactivation ajout paqssse si cloturé
        $('#evenement_evenementStatut').selectmenu({
            change: function( event, ui ) {
                if(ui.item.value == 2){ //evenement cloturé: id=2
                    if($('#evenement_isPaqssse').is(':checked')){
                        $('#evenement_isPaqssse').trigger('click');
                    }
                    $('#evenement_isPaqssse').attr('disabled','disabled');
                }else{
                    $('#evenement_isPaqssse').removeAttr('disabled');
                }
            }
        });
        //traitement ajout classe requiered
        addRequired();
        $('#evenement_isPaqssse').on('click',function(){
            addRequired();
        });

        //wantAddPassse
        $(document).on('click','.wantAddPassse',function(){
            if(parseInt($(this).val()) === 1){
                $('#evenement_isPaqssse').prop('checked', true);
            } else {
                $('#evenement_isPaqssse').prop('checked', false);
            }
            addRequired();
        });
        //end wantAddPassse
    });
    function addRequired(){
        if($('#evenement_isPaqssse').is(':checked')){
                $('#evenement_paq3se_realisation').addClass('required');
                $('#evenement_paq3se_frequence').addClass('required');
                $('#evenement_paq3se_anomalieConstate').addClass('required');
            }
        if(!$('#evenement_isPaqssse').is(':checked')){
                $('#evenement_paq3se_realisation').removeClass('required');
                $('#evenement_paq3se_frequence').removeClass('required');
                $('#evenement_paq3se_anomalieConstate').removeClass('required');
            }
    }
    function completePaqssse(){
        var frequence = $('#evenement_paq3se_frequence').val();
        var gravite = $('#evenement_paq3se_gravite option:selected').val();
        if(gravite == null || frequence == null || frequence < 0){
            $('#evenement_paq3se_niveauRisque').val(0);
        }else{
           $('#evenement_paq3se_niveauRisque').val(gravite*frequence);
           var priorite = prioriteVal(gravite*frequence);
           $('#evenement_paq3se_priorite').val(priorite);
        }
    }
    function prioriteVal(niveauRisque){
        if(niveauRisque<5){return "Basse";}
        if(niveauRisque>=5 && niveauRisque<12 ){return "Moyenne";}
        if(niveauRisque>=12){return "Haute";}
    }
})(jQuery);