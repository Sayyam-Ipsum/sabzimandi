jQuery.validator.addMethod("phone", function(value, element) {
    return value.length < 11 || value.length > 11 ? false : true;
}, "Invalid Phone Number e.g. 03053609490");

jQuery.validator.addMethod("payableGreaterThanZero", function(value, element) {
    return this.optional(element) || (parseFloat(value) > 0);
}, "Amount must be greater than zero*");

jQuery.validator.addMethod("payableValueLessThanTotal", function(value, element) {
    var total = $("#total").val() || null;
    return value > total ? false : true;
}, "Payable amount should be less than Total amount*");


