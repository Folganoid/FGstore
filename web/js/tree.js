$(document).ready(function () {
    $('.tree_link').click(function () {
        var value = $(this).attr('val');

        $.ajax({
            type: "GET",
            url: "/api/item/" + value,
            cache: false,
            success: function (html) {
                json = JSON.parse(html);

                var list = '';
                var price;

                var i = 0;
                while (json[i]) {

                    if (json[i][0] == 'Price') {
                        price = json[i][1];
                        i++;
                        continue;
                    }
                    list += '<li>' + json[i][0] + ': ' + json[i][1];
                    i++;
                }

                $('.star_red').attr('class', 'glyphicon glyphicon-star-empty');
                $('#star'+json.id).attr('class', 'glyphicon glyphicon-star star_red');

                $('#tree_item_show').attr('class', '');
                $('#tree_id').text(json.id);
                $('#tree_name').text(json.name);
                $('#tree_notice').text(json.notice);
                $('#tree_price').text(price);
                $('#tree_list').text(''); // clear
                $('#tree_list').append(list);

                var path = "../img/none.jpg";
                if (json.path) path = "../img/" + json.path;

                $('#tree_image').attr("src", path);
                $('#tree_edit').attr("href", "/item/edit/" + json.id);
                $('#item_buy').attr("value", json.id);
            }
        });
    });

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
