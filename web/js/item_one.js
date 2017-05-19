/**
 * add item in basket
 */
$(document).ready(function () {

    $('#item_buy').click(function () {
        $.ajax({
            type: "POST",
            url: "/basket/add",
            data: {id: $(this).val()},
            cache: false,
            success: function () {
                getBasketCount();
                $('.close').click();
            }
        });
    });
});
