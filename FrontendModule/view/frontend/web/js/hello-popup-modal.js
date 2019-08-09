define([
        "jquery",
        'Magento_Ui/js/modal/alert'
    ],
    function($,alert) {
        "use strict";
        return function(config, element) {
            $( "#button4" ).click(function() {
                alert({
                    title: "Alert",
                    content: "Hello World",
                    autoOpen: true,
                    actions: {
                        always: function () {
                            console.log("modal closed");
                        }
                    }
                });
            });
        }
    }
);