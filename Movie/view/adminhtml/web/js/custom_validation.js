require(
    [
        'Magento_Ui/js/lib/validation/validator',
        'jquery',
        'mage/translate'
    ],
    function(validator, $) {
        validator.addRule(
            'custom-validation',
            function (value) {
                value =  parseInt(value);
                if (Number.isInteger(value)) {
                    if (value < 0 || value > 10) {
                        return false;
                    }
                } else {
                    return false;
                }
                return true;
            }
            ,$.mage.__('Rating not suitable for data structure.')
        );
    }
);