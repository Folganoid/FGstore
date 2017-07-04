/**
 * Created by fg on 22.05.17.
 */
$(document).ready(function () {
    $('.attribute_edit').click(function () {

        var value = $(this).attr('value');

        var valArr = value.split("@");

        $('.attr_id').text('ID#' + valArr[0]);
        $('.attr_id').attr('value', valArr[0]);
        $('#attr_name').attr('value', valArr[1]);
        $('#attr_unit').attr('value', valArr[2]);
        $('#attr_type').text('type: ' + valArr[3]);
    });

    $('.cat_edit').click(function () {
        var value = $(this).attr('value');
        var valArr = value.split("@");

        $('.cat_id').text('ID#' + valArr[0]);
        $('.cat_id').attr('value', valArr[0]);
        $('#cat_name').attr('value', valArr[1]);
        $('#cat_parent').attr('value', valArr[2]);
        $('#cat_notice').attr('value', valArr[3]);
    });
});