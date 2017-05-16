/**
 * Created by fg on 11.05.17.
 */
$(document).ready(function () {
    /**
     * when click FILL SEND button
     */
    $('#but_fill_send').click(function () {
        $('#order_send_date').val(today());
        $('#order_status').val('Sent');
    });
    /**
     * when click FILL RECEIVE button
     */
    $('#but_fill_rec').click(function () {
        $('#order_rec_date').val(today());
        $('#order_status').val('Delivered');
    });

});
/**
 * get today date
 * @returns {Date}
 */
function today() {
    var td = new Date();
    var dd = td.getDate();
    var mm = td.getMonth() + 1;
    var yyyy = td.getFullYear();

    if (dd < 10) {
        dd = '0' + dd
    }

    if (mm < 10) {
        mm = '0' + mm
    }

    td = yyyy + '-' + mm + '-' + dd;
    return td;
}
