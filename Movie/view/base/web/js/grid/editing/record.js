define([
    'Magento_Ui/js/grid/editing/record'
], function (Record) {
    'use strict';

    return Record.extend({
        defaults: {
            templates: {
                fields: {
                    // Add tag element
                    rating: {
                        component: 'Magenest_Movie/js/form/element/rating',
                        template: 'Magenest_Movie/form/element/rating',
                        options: '${ JSON.stringify($.$data.column.options) }'
                    }
                }
            },
        },
    });
});
