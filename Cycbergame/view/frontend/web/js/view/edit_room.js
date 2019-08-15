define([
        "jquery"
    ], function($){
        "use strict";
        /*return function(config, element) {*/
        $(document).ready(function() {
            $('#btn').click(function(e) {
                alert("ajax");
                $.ajax({
                    type: "POST",
                    url: "http://magento2.local/cycbergame/room/saveroom",
                    data: {id: $('#hidden_room_id').val(), number_pc: $('#number-pc-text').val(), address: $('#address-text').val(), food_price: $('#food-price-text').val(), drink_price: $('#drink-price-text').val()},
                    success: function (data) {
                        $('#notice').text("success");
                    }
                });
            });
        });
        /*}*/
    }
);