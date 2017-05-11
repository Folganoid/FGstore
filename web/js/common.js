/**
 * Created by fg on 11.05.17.
 */
/**
 * get cont of user orders in basket
 */
$(document).ready(function(){
    getBasketCount();
});

function getBasketCount() {
    $.ajax({
        type: "POST",
        url: "/api/basket/" + $('#bsktvar').text(),
        cache: false,
        success: function(html){
            $("#basket").html(html);
        }
    });
}

