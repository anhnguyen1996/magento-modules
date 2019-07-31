define([
        "jquery"
    ], function($){
        "use strict";
        return function(config, element) {
            //alert('load complete');
            $( "#button1" ).click(function() {
                alert(config.message);
            });
            $( "#button2" ).click(function() {
                alert(config.message);
            });
            $( "#button3" ).click(function() {
                alert(config.message);
            });
        }
    }
)