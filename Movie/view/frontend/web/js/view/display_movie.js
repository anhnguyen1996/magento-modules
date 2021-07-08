define([
    'ko',
    'uiComponent',
    'mage/url',
    'mage/storage',
    'Magento_Customer/js/section-config',
    'Magento_Customer/js/customer-data'
], function (ko, Component, urlBuilder, storage, sectionConfig, customerData) {
    'use strict';
    var customerId = document.getElementById('hidden_movie_id').value;
    return Component.extend({

       /* defaults: {
            template: 'Magenest_Movie/show_movie',
        },*/
        initialize: function () {
            this._super();
            this.customsection = customerData.get('customsection');
            console.log(this.customsection);
        },
        movieList: ko.observableArray([]),
        searchMovieName: ko.observable(),
        firstName: ko.observable(),
        lastName: ko.observable(),
        customerId: ko.observable(customerId),
        getMovie: function () {
            var self = this;

            //reset Movie List search become Empty
            self.movieList([]);

            var serviceUrl = urlBuilder.build('movie/ko/searchmovie?name='+self.searchMovieName());
            return storage.post(
                serviceUrl,
                ''
            ).done(
                function (response) {
                    var arrResponse = response;
                    arrResponse = JSON.parse(arrResponse);
                    var length = arrResponse.length;
                    for(var i = 0;i < length; i++) {
                        self.movieList.push(JSON.parse(JSON.stringify(arrResponse[i])));
                    }
                }
            ).fail(
                function (response) {
                    alert(response);
                }
            );
        },
        changeInfor: function() {
            var self = this;
            alert('change infor');
            var serviceUrl = urlBuilder.build('movie/ko/savecustomer?id='+self.customerId()+"&firstname="+self.firstName()+"&lastname="+self.lastName());
            return storage.post(
                serviceUrl,
                ''
            ).done(
                function (response) {
                }
            ).fail(
                function (response) {
                    alert(response);
                }
            );
        }
    });
});