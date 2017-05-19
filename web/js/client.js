/**
 * get cont of user orders in basket
 */
$(document).ready(function () {

    $('#edit_pass_1').change(function () {
        confirmEditPass();

    });
    $('#edit_pass_2').change(function () {
        confirmEditPass();
    });
});

/**
 * check passwords match for edit
 */
function confirmEditPass() {

    if ($('#edit_pass_1').val() == $('#edit_pass_2').val()) {
        $('#edit_pass_msg').text("\u00A0");
        document.getElementById('edit_but_submit').disabled = false;
    }
    else {
        $('#edit_pass_msg').text('Passwords does not match !!!');
        document.getElementById('edit_but_submit').disabled = true;
    }
}
