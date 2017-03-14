(function($) {
    'use strict';
    //only for event
    if(typeof evenementcategorieIds === 'undefined'){
        return ;
    }    
    
    try{
        //force novalidate html5
        var form = $('#form-event');
        form.noValidate = true;
    } catch(e) {
        console.log(e);
    }
    var collectionHolder;
    var canSubmitForm = false;
    var nbTiers = 0;
    var isValid = false;  
    var originalValueIsPaq3se = 0;  
    $(document).ready(function(){
        originalValueIsPaq3se = $('#evenement_isPaqssse').is(':checked') ? 1 : 0;
        $('.actionProgres-action').each(function(){
            var val = $(this).text();
            if(!val){
                $(this).removeAttr('readonly');
                $(this).parents('tr').find('select').each(function(){
                    $(this).find('option').each(function(){
                        $(this).removeAttr("disabled", "disabled");                
                    });     
                });
            }
        });
        $('.number').each(function(){
            if($(this).parent().parent().hasClass('has-error')){
                $(this).parent().parent().parent().show();
            }
        });
        //manage files upload
        $('#filesNarrationList').children('li').each(function() {
            if($(this).find('input:first').length > 0 || $(this).find('ul').length > 0){
                addDeleteLink($(this),'delete-narrationPj');                
            }
        });
        $('#filesDescriptionFaitList').children('li').each(function() {
            if($(this).find('input:first').length > 0 || $(this).find('ul').length > 0){
                addDeleteLink($(this),'delete-descriptionFaitPj');                
            }
        });
        $('#filesEvenementEnqueteList').children('li').each(function() {
            if($(this).find('input:first').length > 0 || $(this).find('ul').length > 0){
                addDeleteLink($(this),'delete-evenementEnquetePj');                
            }
        });
        $('.files-label-narration').click(function(){
            if(typeof narrationPJsCount === 'undefined') return;
            var filesNarrationList = $('#filesNarrationList');
            var newLiFileNarration = filesNarrationList.find('#newLiFileNarration');
            if(newLiFileNarration && (newLiFileNarration.length > 0)){
                $(newLiFileNarration).find('.lpsa-file').trigger('click');
                return;
            }
            if(narrationPJsCount >= nbMaxFileUpload){
                var inputFile = $('#filesNarrationList li').last().find('.lpsa-file');
                if(inputFile){
                    inputFile.trigger('click');                    
                }
                return;
            }
            // grab the prototype template
            var newWidget = filesNarrationList.attr('data-prototype');
            newWidget = newWidget.replace(/__name__/g, narrationPJsCount);
            narrationPJsCount++;

            // create a new list element and add it to the list
            var newLi = $('<li id="newLiFileNarration" style="display:none;" class="narration-li"></li>').html(newWidget);
            newLi.appendTo(filesNarrationList);
            newLi.find('.lpsa-file').addClass('lpsa-file-narration').trigger('click');
            addDeleteLink(newLi,'delete-narrationPj');
        });
        $('.files-label-description').click(function(){
            if(typeof descriptionFaitPJsCount === 'undefined') return;
            var filesNarrationList = $('#filesDescriptionFaitList');
            var newLiFileNarration = filesNarrationList.find('#newLiFileDescription');
            if(newLiFileNarration && (newLiFileNarration.length > 0)){
                $(newLiFileNarration).find('.lpsa-file').trigger('click');
                return;
            }
            if(descriptionFaitPJsCount >= nbMaxFileUpload){
                var inputFile = $('#filesDescriptionFaitList li').last().find('.lpsa-file');
                if(inputFile){
                    inputFile.trigger('click');                    
                }
                return;
            }
            // grab the prototype template
            var newWidget = filesNarrationList.attr('data-prototype');
            newWidget = newWidget.replace(/__name__/g, descriptionFaitPJsCount);
            descriptionFaitPJsCount++;

            // create a new list element and add it to the list
            var newLi = $('<li id="newLiFileDescription" style="display:none;" class="description-li"></li>').html(newWidget);
            newLi.appendTo(filesNarrationList);
            newLi.find('.lpsa-file').addClass('lpsa-file-description').trigger('click');
            addDeleteLink(newLi,'delete-descriptionFaitPj');
        });
        $('.files-label-enquete').click(function(){
            if(typeof evenementEnquetePJsCount === 'undefined') return;
            var filesEnqueteList = $('#filesEvenementEnqueteList');
            var newLiFileEnquete = filesEnqueteList.find('#newLiFileEnquete');
            if(newLiFileEnquete && (newLiFileEnquete.length > 0)){
                $(newLiFileEnquete).find('.lpsa-file').trigger('click');
                return;
            }
            if(evenementEnquetePJsCount >= nbMaxFileUpload){
                var inputFile = $('#filesDescriptionFaitList li').last().find('.lpsa-file');
                if(inputFile){
                    inputFile.trigger('click');                    
                }
                return;
            }
            // grab the prototype template
            var newWidget = filesEnqueteList.attr('data-prototype');
            newWidget = newWidget.replace(/__name__/g, evenementEnquetePJsCount);
            evenementEnquetePJsCount++;

            // create a new list element and add it to the list
            var newLi = $('<li id="newLiFileEnquete" style="display:none;" class="enquete-li"></li>').html(newWidget);
            newLi.appendTo(filesEnqueteList);
            newLi.find('.lpsa-file').addClass('lpsa-file-enquete').trigger('click');
            addDeleteLink(newLi,'delete-evenementEnquetePj');
        });
        $(document).on('click','.delete-narrationPj',function(){
            if(typeof narrationPJsCount !== 'undefined'){
                narrationPJsCount--;
            }
        });
        $(document).on('click','.delete-evenementEnquetePj',function(){
            if(typeof evenementEnquetePJsCount !== 'undefined'){
                evenementEnquetePJsCount--;
            }
        });
        $(document).on('click','.delete-descriptionFaitPj',function(){
            if(typeof descriptionFaitPJsCount !== 'undefined'){
                descriptionFaitPJsCount--;
            }
        });
        $(document).on('change','.lpsa-file',function(){
            var fullPath = $(this).val();
            var filename = $(this).val();
            if (fullPath) {
                var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                var filename = fullPath.substring(startIndex);
                if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                    filename = filename.substring(1);
                }
            }
            if($(this).hasClass('lpsa-file-narration')){
                $(this).siblings('span').text(filename).parents('#newLiFileNarration').removeAttr('id','newLiFileNarration').show();                
            }
            if($(this).hasClass('lpsa-file-description')){
                $(this).siblings('span').text(filename).parents('#newLiFileDescription').removeAttr('id','newLiFileDescription').show();                
            }
            if($(this).hasClass('lpsa-file-enquete')){
                $(this).siblings('span').text(filename).parents('#newLiFileEnquete').removeAttr('id','newLiFileEnquete').show();                
            }
        });
        //end manage files upload
        //saved number, when we change select corporel this number is set by 0 so store this before
        nbTiers = $('.input-nbreTiers').val();
        // Get the ul that holds the collection of evtActionProgres
        appEvent.buildTable(false);
        //init datepicker after load TR
        $('.datepicker').datepicker();
        if(typeof evenementCategorieId !== 'undefined'){
            appEvent.updateViewForm(evenementCategorieId);
        } 
        if(typeof ajaxUrlNumeroEnregistrement !== 'undefined'){
            $('.select-depot').selectmenu({
                change: function( event, ui ) {
                    $.ajax({
                        url: ajaxUrlNumeroEnregistrement + '?id=' + ui.item.value + '&event=' + evenementId,
                        dataType: 'json',
                        type: 'GET'
                    }).done(function(data){
                        $('.numero-enregistrement').val(data.value);
                    });
                }
            });            
        }
            
        //start get gravity
        $('.select-corporel').selectmenu({
            change: function( event, ui ) {
                updateAbstractGravityLabel();
            }
        });    
        $('.select-materiel').selectmenu({
            change: function( event, ui ) {
                updateAbstractGravityLabel();
            }
        }); 
        $('.select-environnement').selectmenu({
            change: function( event, ui ) {
                updateAbstractGravityLabel();
                if(typeof environment1m3Ids !== 'undefined'){
                    if(!inArray(parseInt(ui.item.value),environment1m3Ids)){
                        $('.input-nbreEnvironnement').val(0).parents('.nolabel').hide();
                    } else {
                        $('.input-nbreEnvironnement').parents('.nolabel').show();
                    }
                }
            }
        }); 
        $('.select-impactmediatique').selectmenu({
            change: function( event, ui ) {
                updateAbstractGravityLabel();
            }
        }); 
        $('.select-impactclient').selectmenu({
            change: function( event, ui ) {
                updateAbstractGravityLabel();
            }
        }); 
        $('.select-dysfonctionnement').selectmenu({
            change: function( event, ui ) {
                updateAbstractGravityLabel();
            }
        }); 
        //end get gravity
        
        //ajax select
        if(typeof objTypeCorporel !== 'undefined'){
            onChangeTypeCorporel(objTypeCorporel);
        }
        if(typeof objTypeMateriel !== 'undefined'){
            onChangeTypeMateriel(objTypeMateriel);
        }
        if(typeof objTypeEnvironnement !== 'undefined'){
            onChangeTypeEnvironnement(objTypeEnvironnement);
        }
        if(typeof objDepotCategorie !== 'undefined'){
            onChangeDepotCategorie(objDepotCategorie);
        }
        if(typeof objDirection !== 'undefined'){
            onChangeDirection(objDepotCategorie);
        }
        //end ajax select
        //ajax search
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
        //end ajax search
        //progressBar 
        $(document).on('click','.progress-bar-container-avancement',function(){
            $(this).toggle().siblings('.input-avancement-td').toggle();
        });
        $(document).on('click', '.cancel_icon', function(e)
        {
            e.preventDefault();
            
            var $this = $(this);
            
            $this.parents('.avancement-td').find('.input-avancement-td, .progress-bar-container-avancement').toggle();
        });
        $(document).on('change','.input-avancement',function(){
            var progressBar = $(this).parent().siblings('.progress-bar-container-avancement').find('.progress-bar-avancement:first');
            var value = $(this).val();
            progressBar.text(value + '%');
            progressBar.attr('aria-valuenow',value);
            progressBar.width(value + '%');   
        }); 
        $(document).on('click','.ui-spinner-button .ui-button-icon',function(){
            if($(this).parent().siblings('.input-avancement').length > 0){
                var progressBar = $(this).parent().parent().siblings('.progress-bar-container-avancement').find('.progress-bar-avancement:first');
                var value = $(this).parent().siblings('.input-avancement:first').val();
                progressBar.text(value + '%');
                progressBar.attr('aria-valuenow',value);
                progressBar.width(value + '%');                   
            }
        }); 
        //end progressBar        
        
        //submit form
        $('#btn-submit').click(function(e){
            isValid = isValidForm();
            if(!canSubmitForm || !isValid){
                e.preventDefault();
                if(isValid){
                    /**
                     * Populate modal
                     */
                    appEvent.updateModalAbstractView();
                    if(abstractGravityValue >= paq3seGravity){
                        if($('#evenement_isPaqssse').is(':checked')){
                            $('#wantAddPassseContainer').hide();
                            $('#infoPaqsse').hide();
                        } else {
                            if($('#evenement_paq3se_anomalieConstate').val() == '' || $('#evenement_paq3se_frequence').val() == '' || $('#evenement_paq3se_realisation').val() == ''){
                                $('#infoPaqsse').show();
                                $('.btn-modal-hide').hide();
                                $('#evenement_paq3se_realisation').addClass('required');
                                $('#evenement_paq3se_frequence').addClass('required');
                                $('#evenement_paq3se_anomalieConstate').addClass('required');
                            } else {
                                $('#wantAddPassseContainer').show();
                                $('.btn-modal-hide').show();
                                $('#infoPaqsse').hide();
                                $('#evenement_paq3se_realisation').removeClass('required');
                                $('#evenement_paq3se_frequence').removeClass('required');
                                $('#evenement_paq3se_anomalieConstate').removeClass('required');
                            }
                        }
                    } else {
                        $('#wantAddPassseContainer').hide();
                        $('.btn-modal-hide').show();
                        $('#infoPaqsse').hide();
                        $('#evenement_paq3se_realisation').removeClass('required');
                        $('#evenement_paq3se_frequence').removeClass('required');
                        $('#evenement_paq3se_anomalieConstate').removeClass('required');
                    }
                    $('#modalAbstractEvent').modal('show'); 
                }
                return false;                
            }
            cleanBeforeSending();
        });
        $('#btn-closeModal').click(function(){
            canSubmitForm = false;            
            $('#modalAbstractEvent').modal('hide');
            if(parseInt(originalValueIsPaq3se) === 1){
                $('#evenement_isPaqssse').prop('checked', true);
                $('.formular_paqssse').show();
            } else {
                $('#evenement_isPaqssse').prop('checked', false);
            }
            if(abstractGravityValue >= paq3seGravity){
                $('.formular_paqssse').show();
                isValidForm();
            }
        });
        $('#btn-okModal').click(function(){
            canSubmitForm = true;
            if(canSubmitForm && (typeof btnSavedForm !== 'undefined')){
                $('#btn-submit').val(btnSavedForm);
            }      
            if($('#evenement_isPaqssse').is(':checked')){
                $('.formular_paqssse').show();
            }      
        });
         //end submit form
         
         
        //on change input-dateDesFaits
        $('.input-dateDesFaits').datepicker()
            .on("change", function (e) {
            var objDateFaits = $(this).datepicker("getDate");
            if((typeof messageDateFait !== 'undefined') && (($('.input-dateAction').val() != '') || ($('.evenementEnquete-date').val() != ''))){
                alert(messageDateFait);
            }
            $('.input-dateAction').datepicker('option', 'minDate', objDateFaits);
            $('.evenementEnquete-date').datepicker('option', 'minDate', objDateFaits);
        });
        //end on change input-dateDesFaits
        //on change input-dateAction
        $('.input-dateAction').datepicker()
            .on("change", function (e) {
            if((typeof messageDateAction !== 'undefined') && ($('.evenementEnquete-date').val() != '')){
                alert(messageDateAction);
            }
            var objDateAction = $(this).datepicker("getDate");
            $('.evenementEnquete-date').datepicker('option', 'minDate', objDateAction);
        });
        //end on change input-dateAction
    });    
    

    /**
     * update gravity label (abstract)
     * 
     * @returns {undefined}
     */
    function updateAbstractGravityLabel(){
        var corporel = $('.select-corporel').val();
        var materiel = $('.select-materiel').val();
        var environnement = $('.select-environnement').val();
        var impactMediatique = $('.select-impactmediatique').val();
        var impactClient = $('.select-impactclient').val();
        var dysfonctionnement = $('.select-dysfonctionnement').val();
        $.ajax({
            url: ajaxUrlGetGravity + '?corporel=' + corporel + '&materiel=' + materiel + '&environnement=' + environnement + '&impactmediatique=' + impactMediatique + '&impactclient=' + impactClient + '&dysfonctionnement=' + dysfonctionnement,
            dataType: 'json',
            type: 'GET'
        }).done(function(data){
            $('#consequenceGraviteReelle').text(data.value);
            $('#consequenceGravitePotentielle').text(data.value);
            $('#evenement_paq3se_gravite option[value="'+data.gravityValue+'"]').attr('selected', true);
            if(data.gravityValue){
                abstractGravityValue = parseInt(data.gravityValue);
            } else {
                abstractGravityValue = 0;
            }
            $('#evenement_paq3se_gravite').selectmenu("refresh");
            completePaqssse();
        });
    }    

    //depot event
    $(document).on('change','.event-depot',function(){
        resetDepot(this);
    });
    
    /**
     * Update select Depot
     * 
     * @param {String} elem
     * @returns {undefined}
     */
    function resetDepot(elem){
        var selectors = ['event-depot-s','event-depot-n','event-depot-o'];
        for( var i in selectors){
            if(!$(elem).hasClass(selectors[i])){
                $('.' + selectors[i]).val('');
            }
        }
    }
    
    //category select event
    $(document).on('click','.event-categorie input',function(){
        appEvent.updateViewForm($(this).val());
        if(typeof evenementcategorieIds !== 'undefined'){
            for(var key in evenementcategorieIds){                
                if(inArray(parseInt($(this).val()),evenementcategorieIds[key].values)){
                    $('#' + evenementcategorieIds[key].selector).show();
                    updateMatrixGravityLabel(evenementcategorieIds[key].labels);
                } else {
                    $('#' + evenementcategorieIds[key].selector).hide();
                }
            }            
        }
        if(typeof categoriesId !== 'undefined'){console.log(categoriesId);
            for(var key in categoriesId){                
                if(parseInt($(this).val()) === categoriesId[key].id){
                    $('.' + categoriesId[key].selector).show();
                } else {
                    $('.' + categoriesId[key].selector).hide();
                }
            }   
        }
    });
    
    function updateMatrixGravityLabel(selectors){
        for(var selector in selectors){
            $('.' + selector).siblings('label').text(selectors[selector]);
        }
    }    

    /**
     * Check if value exist in array
     * 
     * @param {String} needle
     * @param {Array} haystack
     * @returns {Boolean}
     */
    function inArray(needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (haystack[i] === needle)  return true;
        }
        return false;
    }
    
    /**
     * ajax select on change typeCorporel
     * @param {objTypeCorporel} objTypeAjax
     * @returns {undefined}
     */
    function onChangeTypeCorporel(objTypeAjax){
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
                    $('.select-corporel').empty().html(options);
                    $('.select-corporel').selectmenu("refresh");
                });
                var val = ui.item.value;
                if(val && typeof typecorporelIds !== 'undefined'){
                    for(var key in typecorporelIds){
                        if((val === key) && (typecorporelIds[key] === 'fatalite')){
                            $('.' + typecorporelIds[key]).show();
                            $('.input-nbreTiers').val(nbTiers);
                            break;
                        } else {
                            $('.input-nbreTiers').val(0);
                            $('.' + typecorporelIds[key]).hide();
                        }
                    }
                } 
            }
        });
        if(objTypeAjax.js_data){
            $(objTypeAjax.js_selector).val(objTypeAjax.js_data);  
            $(objTypeAjax.js_selector).selectmenu("refresh");            
        }
    }
    
    /**
     * ajax select on change typeMateriel
     * @param {objTypeMateriel} objTypeAjax
     * @returns {undefined}
     */
    function onChangeTypeMateriel(objTypeAjax){
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
                    $('.select-materiel').empty().html(options);
                    $('.select-materiel').selectmenu("refresh");
                });
            }
        });
        if(objTypeAjax.js_data){
            $(objTypeAjax.js_selector).val(objTypeAjax.js_data);  
            $(objTypeAjax.js_selector).selectmenu("refresh");            
        }
    }
    
    /**
     * ajax select on change typeEnvironnement
     * @param {objTypeEnvironnement} objTypeAjax
     * @returns {undefined}
     */
    function onChangeTypeEnvironnement(objTypeAjax){
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
                    $('.select-environnement').empty().html(options);
                    $('.select-environnement').selectmenu("refresh");
                });
            }
        });
        if(objTypeAjax.js_data){
            $(objTypeAjax.js_selector).val(objTypeAjax.js_data);  
            $(objTypeAjax.js_selector).selectmenu("refresh");            
        }
    }
    
    /**
     * ajax select on change depotCategorie
     * @param {objDepotCategorie} objTypeAjax
     * @returns {undefined}
     */
    function onChangeDepotCategorie(objTypeAjax){
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
                    $('.select-depot').empty().html(options);
                    $('.select-depot').selectmenu("refresh");
                });
            }
        });
        if(objTypeAjax.js_data){
            $(objTypeAjax.js_selector).val(objTypeAjax.js_data);  
            $(objTypeAjax.js_selector).selectmenu("refresh");            
        }
    }
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
                });
            }
        });
        if(objTypeAjax.js_data){
            $(objTypeAjax.js_selector).val(objTypeAjax.js_data);  
            $(objTypeAjax.js_selector).selectmenu("refresh");            
        }
    }
    
    function isValidForm(){
        var valid  = true;
        var target = null;
        var msgError = (typeof msgErrorsForm !== 'undefined') ? msgErrorsForm.blank : 'Cette valeur ne doit pas être vide.';
        var errorMsgHtml = '<span class="help-block msg-error"><ul class="list-unstyled"><li><span class="glyphicon glyphicon-exclamation-sign"></span>'+ msgError + '</li></ul></span>';
        $('.required').each(function(){
            if($(this).is('input')){
                var val = $(this).val().trim();
                if(val === ''){
                    var parent = $(this).parent();
                    if(parent.hasClass('form-group')){
                        $(this).parent().removeClass('has-error').find('.msg-error:first').remove();                    
                        $(this).parent().addClass('has-error').append(errorMsgHtml);
                    } else {
                        $(this).parent().parent().removeClass('has-error').find('.msg-error:first').remove();                    
                        $(this).parent().parent().addClass('has-error').append(errorMsgHtml);
                    }
                    valid  = false;  
                    if(!target){
                        target = $(this);
                    }
                } else {
                    var parent = $(this).parent();
                    if(parent.hasClass('form-group')){
                        $(this).parent().removeClass('has-error').find('.msg-error:first').remove();                    
                    } else {
                        $(this).parent().parent().removeClass('has-error').find('.msg-error:first').remove();   
                    }
                }
            }
            if($(this).is('select')){
                var val = $(this).val().trim();
                if(val === ''){
                    $(this).siblings('span').removeClass('span-has-error').parent().removeClass('has-error').find('.msg-error:first').remove();                    
                    $(this).siblings('span').addClass('span-has-error').parent().addClass('has-error').append(errorMsgHtml);
                    valid  = false;     
                    if(!target){
                        target = $(this);
                    }
                } else {
                    $(this).siblings('span').removeClass('span-has-error').parent().removeClass('has-error').find('.msg-error:first').remove();                    
                }
            }
            if($(this).is('div')){
                var checked = false;
                $(this).find("input[type='radio']").each(function(){
                    if($(this).is(':checked')){
                        checked = true;
                    }
                });
                if(!checked){
                    $(this).parent().parent().removeClass('has-error').find('.msg-error:first').remove();                    
                    $(this).parent().parent().addClass('has-error').append(errorMsgHtml);                    
                    valid  = false;
                    if(!target){
                        target = $(this);
                    }
                } else {
                    $(this).parent().parent().removeClass('has-error').find('.msg-error:first').remove();                    
                }
            }
            if($(this).is('textarea')){
                var val = $(this).val().trim();
                if(val === ''){console.log($(this));
                    $(this).parent().find('.msg-error:first').remove();
                    $(this).parent().addClass('has-error').append().append(errorMsgHtml);
                    valid  = false;     
                    if(!target){
                        target = $(this);
                    }
                } else {
                    $(this).parent().removeClass('has-error');
                    $(this).parent().find('.msg-error:first').remove();
                }
            }
        });
        if(target){
            $('html,body').animate({scrollTop: target.offset().top}, 'slow');
        }
        return valid;
    }
    
    function addDeleteLink(li,selector) {
        var removeA = $('<a href="#" class="delete-file ' + selector + '"><i class="fa fa-close"></i></a>');
        li.append(removeA);
        removeA.on('click', function(e) {
            // prevent the link 
            e.preventDefault();
            // remove the li 
            li.remove();
        });
    }
    
    function cleanBeforeSending(){
        var lastFileNarr = $('#newLiFileNarration').find('input:first').val();
        if(!lastFileNarr && isValid){
            $('#newLiFileNarration').remove();
            if(typeof narrationPJsCount !== 'undefined'){
                narrationPJsCount--;
            }
        }
        var lastFileEnq = $('#newLiFileEnquete').find('input:first').val();
        if(!lastFileEnq  && isValid){
            $('#newLiFileEnquete').remove();
            if(typeof evenementEnquetePJsCount !== 'undefined'){
                evenementEnquetePJsCount--;
            }
        }
        var lastFileDesc = $('#newLiFileDescription').find('input:first').val();
        if(!lastFileDesc && isValid){
            $('#newLiFileDescription').remove();
            if(typeof descriptionFaitPJsCount !== 'undefined'){
                descriptionFaitPJsCount--;
            }
        }
    }
    //call after change consequence
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