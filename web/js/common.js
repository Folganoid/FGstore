/**
 * Created by fg on 11.05.17.
 */
/**
 * get cont of user orders in basket
 */
$(document).ready(function () {
    getBasketCount();

    $('#reg_pass_1').change(function () {
        confirmRegPass();
    });
    $('#reg_pass_2').change(function () {
        confirmRegPass();
    });

});

/**
 * get basket count by SESSION_id from basket
 */
function getBasketCount() {
    $.ajax({
        type: "POST",
        url: "/api/basket/" + $('#bsktvar').text(),
        cache: false,
        success: function (html) {
            $("#basket").html(html);
        }
    });
}
/**
 * check passwords match for registration
 */
function confirmRegPass() {
    var pass1 = $('#reg_pass_1').val();
    var pass2 = $('#reg_pass_2').val();

    if (pass1 == pass2) {
        $('#reg_pass_msg').text("\u00A0");
        document.getElementById('reg_but_submit').disabled = false;
    }
    else {
        $('#reg_pass_msg').text('Passwords does not match !!!');
        document.getElementById('reg_but_submit').disabled = true;
    }
}

