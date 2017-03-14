(function($) {
    'use strict';
    $(document).ready(function(){
        $('#btn-submit').click(function(){
            var src = urlPrint+"?redacteur=Manda";
            var ifr = document.createElement('iframe');
            ifr.src = urlPrint;
            ifr.name = "frame";
            document.body.appendChild(ifr);
        });
    });
})(jQuery);