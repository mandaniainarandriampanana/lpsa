/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    $('#evenement_nbreEnvironnement , #numberInput input').spinner();
    $(".title-toggle").click(function () {
        $(".content-toggle").toggle();
    });
    
//    $('#dataTables-lastincident').fixedHeaderTable({ 
//	footer: true,
//	cloneHeadToFoot: true,
//	altClass: 'odd',
//	autoShow: false
//});
//    
    
});
$(window).on('load', function ()
{
    setTimeout(function ()
    {
        $(".form-group select, select.form-control").selectmenu();
    }, 1);

});

