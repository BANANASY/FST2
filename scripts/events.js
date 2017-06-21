$(document).ready(function () {
    var incoming_goods_sort = "ascending";
    var outgoing_goods_sort = "ascending";
    

    $(".goodCage").click(function () {
        var id = $(this).find(".good_id").html();
        window.location.href = '../FST2/ArticleMovement.php?product=' + id;
    });

    $(".goods-incdate").click(function () {
        var elems = $.makeArray($(this).parent().parent().parent().parent().find(".goods-entries"));
        
        if(incoming_goods_sort === "ascending"){
            incoming_goods_sort = "descending";
            $(".goods-incdate").wrapInner("");
            $(".goods-incdate").wrapInner('<span title="Data sorted in ' + incoming_goods_sort + ' order"/>');
            elems.sort(function (a, b) {
                return parseDate($(a).find(".goods-inc-deliverydate").text()) < parseDate($(b).find(".goods-inc-deliverydate").text());
            });
            $(".movement-incoming-table").find(".movement-incoming-table-body").html(elems);
        }else{
            incoming_goods_sort = "ascending";
            elems.sort(function (a, b) {
                return parseDate($(a).find(".goods-inc-deliverydate").text()) > parseDate($(b).find(".goods-inc-deliverydate").text());
            });
            $(".movement-incoming-table").find(".movement-incoming-table-body").html(elems);
        }
            
    });
    
    $(".goods-outdate").click(function () {
        var elems = $.makeArray($(this).parent().parent().parent().parent().find(".goods-entries"));
        
        if(outgoing_goods_sort === "ascending"){
            outgoing_goods_sort = "descending";

            elems.sort(function (a, b) {
                return parseDate($(a).find(".goods-out-deliverydate").text()) < parseDate($(b).find(".goods-out-deliverydate").text());
            });
            $(".movement-outgoing-table").find(".movement-outgoing-table-body").html(elems);
        }else{
            outgoing_goods_sort = "ascending";
            elems.sort(function (a, b) {
                return parseDate($(a).find(".goods-out-deliverydate").text()) > parseDate($(b).find(".goods-out-deliverydate").text());
            });
            $(".movement-outgoing-table").find(".movement-outgoing-table-body").html(elems);
        }
            
    });
});

    function parseDate(input) {
        var parts = input.match(/(\d+)/g);
        // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
        return new Date(parts[0], parts[1] - 1, parts[2], parts[3], parts[4], parts[5]); //     months are 0-based
    }