/**
 * Created by fg on 11.05.17.
 */
/**
 * delete from basket
 */
$(document).ready(function () {

    var json;

    getBasketList();
    /**
     * get baket list
     */
    function getBasketList() {
        $.ajax({
            type: "POST",
            url: "/api/basket/list/" + $('#bsktvar').text(),
            cache: false,
            success: function (html) {
                json = JSON.parse(html);
                $('#basket_table').text(''); // clear
                drawBasketTable();

                $('.basket_remove').click(function () {

                    $.ajax({
                        type: "POST",
                        url: "/basket/del",
                        data: {id: $(this).val()},
                        cache: false,
                        success: function () {
                            getBasketCount();
                            getBasketList();
                        }
                    });
                });
            }
        });
    }

    /**
     * draw basket table
     */
    function drawBasketTable() {

        if (json.length > 0) {
            var headTable = "";
            var bodyTable = "";
            headTable = "<tr align='center'><td>" +
                "<b>Item name</b></td><td><b>Notice</b></td><td><b>Price</b></td></tr>";
            bodyTable = "";

            for (i = 0; i < json.length; i++) {
                bodyTable += "<tr class='basket_row'><td><a href='/item/"+ json[i]['item_id'] +"'>" +
                    json[i]['name'] +
                    "</a></td><td>" + json[i]['notice'] +
                    "</td><td><span class='price pull-right'>" +
                    json[i]['price'] +
                    " $</span></td><td><button class='basket_remove btn btn-danger btn-xs' title='Remove' value='" +
                    json[i]['id'] +
                    "'>X</button></td></tr>"+
                    "<tr><td></td></tr>";
            }
            $('#basket_table').append(headTable + bodyTable);
            $('#basket_send_but').attr('class', 'btn btn-primary');
        }

        else {
            $('#basket_msg').text('is empty...');
            $('#basket_send_but').attr('class', 'hidden');
        }

    }

});