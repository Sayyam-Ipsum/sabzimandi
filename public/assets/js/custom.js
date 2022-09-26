jQuery.validator.addMethod("phone", function(value, element) {
    if (value < 11 || value > 11) {
        return false;
    } else {
        return true;
    }
    console.log('value = ', value);
    console.log('element = ', element);
}, "Invalid Phone Number e.g. 03053609490");


