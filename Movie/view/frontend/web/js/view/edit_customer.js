define([
        "jquery"
    ], function($){
        "use strict";
        return function(config, element) {
            $(document).ready(function() {
                $('#btn').click(function(e) {
                    alert("ajax");
                    $.ajax({
                        type: "POST",
                        url: "http://magento2.local/movie/jquery/savecustomer",
                        data: {id: $('#hidden_movie_id').val(),firstname: $('#first-name-text').val(), lastname: $('#last-name-text').val()},
                        success: function (data) {
                            $('#notice').text("success");
                        }
                    });
                });
            });
        }
    }
);