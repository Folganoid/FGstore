/**
 * add item in basket
 */
$(document).ready(function () {

    $('#item_buy').click(function () {
        $.ajax({
            type: "POST",
            url: "/basket/add",
            data: {
                id: $(this).val(),
                sum: $(this).attr('sum')
            },
            cache: false,
            success: function () {
                getBasketCount();
                $('.close').click();
            }
        });
    });

    $('#arrow_left').click(function () {
        var itemsSum = +$('#sum').text() - 1;
        if (itemsSum > 0) {
            $('#sum').text(itemsSum);
            $('#item_buy').attr('sum', itemsSum);
        }
    });

    $('#arrow_right').click(function () {
        var itemsSum = +$('#sum').text() + 1;
        $('#sum').text(itemsSum);
        $('#item_buy').attr('sum', itemsSum);
    });

});
