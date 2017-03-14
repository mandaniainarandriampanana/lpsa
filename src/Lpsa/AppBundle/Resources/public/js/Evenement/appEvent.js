var appEvent = {
    buildTable : function(disabled){
        // Get the ul that holds the collection of evtActionProgres
        collectionHolder = $('table#table-evtActionProgres');
        //add tr
        this.addEvtActionProgres(collectionHolder,disabled);
    },
    addEvtActionProgres : function(collectionHolder,disabled) {

        // get the new index
        var index = collectionHolder.data('number');
        if((parseInt(index) < 5) && (parseInt(index) !== 4)){
            // Get the data-prototype
            var prototype = collectionHolder.data('prototype');
            // Replace '__name__' in the prototype's HTML to
            // instead be a number based on how many items we have
            var newForm = prototype.replace(/__name__/g, index);

            // increase the index with one for the next item
            collectionHolder.data('number', index + 1);  
            // Display the form in the page in an tr
            var newFormTr = $('<tr></tr>').append(newForm);
            if(disabled){
                newFormTr.find('select').each(function(){
                    $(this).find('option').each(function(){
                        $(this).not(":selected").attr("disabled", "disabled");                
                    });   
                });
                newFormTr.find('input').each(function(){
                    $(this).on('keydown paste', function(e){
                        e.preventDefault();
                        return false;
                    });
                });
            }
            collectionHolder.append(newFormTr);  
            this.addEvtActionProgres(collectionHolder,disabled);
        }
    },
    updateModalAbstractView : function(){
        $('#tdUserDeclarant').text($('.user-declarant').siblings('input:first').val());
        $('#tdCategorie').text($('.event-categorie').find('input:checked').parent().text());
        $('#tdCategorieComm').text($('.input-descriptionFait').val());
        $('#tdDepot').text($('.select-depot').siblings('span').find('.ui-selectmenu-text').text());
        $('#tdNumeroEnregistrement').text($('.numero-enregistrement').val());
        $('#tdDateDesFaits').text($('.input-dateDesFaits').val());
        $('#tdDateAction').text($('.input-dateAction').val());
        $('#tdNarration').text($('.input-narration').val());
        $('#tdCorporelLabel').text($('.select-typeCorporel').siblings('label:first').text() + ':');
        $('#tdCorporel').text($('.select-typeCorporel').siblings('span').find('.ui-selectmenu-text').text() + ' - ' +$('.select-corporel').siblings('span').find('.ui-selectmenu-text').text());
        var corporelValueHtml = '';
        $('#numberInput').children('div').each(function(){
            if($(this).is(':visible')){
                corporelValueHtml += '<table>';
                $(this).find('input').each(function(){
                    corporelValueHtml += '<tr>';
                    corporelValueHtml += '<td>' + $(this).parent().siblings('label').text() + ':</td>';
                    corporelValueHtml += '<td>' + $(this).val() + '</td>';
                    corporelValueHtml += '</tr>';
                });
                corporelValueHtml += '</table>';
            }
        });
        $('#tdCorporelValue').empty().html(corporelValueHtml);
        $('#tdMaterielLabel').text($('.select-typeMateriel').siblings('label:first').text() + ':');
        $('#tdMateriel').text($('.select-typeMateriel').siblings('span').find('.ui-selectmenu-text').text() + ' - ' + $('.select-materiel').siblings('span').find('.ui-selectmenu-text').text());
        $('#tdEnvironnementLabel').text($('.select-typeEnvironnement').siblings('label:first').text() + ':');
        $('#tdEnvironnement').text($('.select-typeEnvironnement').siblings('span').find('.ui-selectmenu-text').text() + ' - ' + $('.select-environnement').siblings('span').find('.ui-selectmenu-text').text());
        $('#tdEnvironnementValue').text($('.input-nbreEnvironnement').val());
        $('#tdMediatiqueLabel').text($('.select-impactmediatique').siblings('label:first').text() + ':');
        $('#tdMediatique').text($('.select-impactmediatique').siblings('span').find('.ui-selectmenu-text').text());
        $('#tdQualiteLabel').text($('.select-impactclient').siblings('label:first').text() + ':');
        $('#tdQualite').text($('.select-impactclient').siblings('span').find('.ui-selectmenu-text').text());
        $('#tdDysfonctionnementLabel').text($('.select-dysfonctionnement').siblings('label:first').text() + ':');
        $('#tdDysfonctionnement').text($('.select-dysfonctionnement').siblings('span').find('.ui-selectmenu-text').text());
        var gravityLabel = '';
        var gravityValue = '';
        if($('#consequencePotentielle').is(':visible')){
            gravityLabel = $('#consequencePotentielle').find('h3:first').text();
            gravityValue = $('#consequencePotentielle').find('p:first').text();
        } else {
            gravityLabel = $('#consequenceReelle').find('h3:first').text();
            gravityValue = $('#consequenceReelle').find('p:first').text();
        }
        $('#tdGraviteLabel').text(gravityLabel + ':');
        $('#tdGravite').text(gravityValue);
        $('#tdEvenementEnqueteDate').text($('.evenementEnquete-date').val());
        $('#tdEvenementEnqueteComm').text($('.evenementEnquete-commentaire').val());
        $('#tdEvenementEnqueteCausesImmediates').text($('.evenementEnquete-causesImmediates').val());
        $('#tdEvenementEnqueteCausesFondamentales').text($('.evenementEnquete-causesFondamentales').val());
        var evtActionProgresHtml = '';
        $('#table-evtActionProgres').find('tbody tr').each(function(){
            var action = $(this).find('.actionProgres-action:first').val();
            var responsableService = $(this).find('.actionProgres-responsableService').siblings('span').find('.ui-selectmenu-text').text();
            var delai = $(this).find('.actionProgres-delai:first').val();
            var avancement = $(this).find('.actionProgres-avancement:first').val();
            var observation = $(this).find('.actionProgres-observation:first').val();
            var evenementActionProgresStatus = $(this).find('.actionProgres-evenementActionProgresStatus').siblings('span').find('.ui-selectmenu-text').text();
            if(action.trim() !== '' || responsableService.trim() !== '' || delai.trim() !== '' || avancement.trim() !== '' || observation.trim() !== '' || evenementActionProgresStatus.trim() !== ''){
                evtActionProgresHtml += '<tr>';
                evtActionProgresHtml += '<td>' + action + '</td>';
                evtActionProgresHtml += '<td>' + responsableService + '</td>';
                evtActionProgresHtml += '<td>' + delai + '</td>';
                evtActionProgresHtml += '<td>' + avancement + '%</td>';
                evtActionProgresHtml += '<td>' + observation + '</td>';
                evtActionProgresHtml += '<td>' + evenementActionProgresStatus + '</td>';
                evtActionProgresHtml += '</tr>';
            }
        });
        $('#tdActionProgres').empty().html(evtActionProgresHtml);
    },
    updateViewForm : function(index){
        var self = this;
        if(typeof evenementCategorieTables[index] !== 'undefined'){
            var array = evenementCategorieTables[index];
            $('#event-form').find('.row').each(function(){
                if($(this).attr('id')){
                    if(!self.inArray($(this).attr('id'),array)){
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                }
            });
        }
    },
    inArray : function(needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (haystack[i] === needle)  return true;
        }
        return false;
    }
}