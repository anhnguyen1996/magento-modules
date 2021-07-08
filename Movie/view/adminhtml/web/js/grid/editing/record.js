define([
    'Magento_Ui/js/grid/editing/record'
], function (Record) {
    'use strict';

    return Record.extend({
        defaults: {
            templates: {
                fields: {
                    // Add tag element
                    tag: {
                        component: 'Magestore_OrderSuccess/js/form/element/tag',
                        template: 'Magestore_OrderSuccess/form/element/tag',
                        options: '${ JSON.stringify($.$data.column.options) }'
                    }
                }
            },
        },
    });
});