
//JavaScript
var error = false; //public damit alle funktionen die variable verändern können

function checkPurchaseOrderReviewForm() {
    error = false;

    var deliveredGoodsAmount = document.getElementsByName('deliveredGoodsAmount[]'); //knoten array funktioniert anscheinend nur mit ElementsByName nicht aber ElementsByID
    var qualityOKofGoods = document.getElementsByName('qualityOKofGoods[]');

    var length = deliveredGoodsAmount.length; //beide arrays haben die selbe länge, da beide textboxen in der form gleich oft erzeugt wurden

    //alert("testX" + length);

    for (var i = 0; i < length; i++) {
        //alert("test" + i);
        qualityOKofGoods[i].style.backgroundColor = "#85e085";
        if (qualityOKofGoods[i].value > deliveredGoodsAmount[i].value) {
            qualityOKofGoods[i].style.backgroundColor = "#ff9999";
            error = true;
            //alert("test" + i + "inner");
        }
    }

    if (error) {
        alert("Error: You cannot set the Quality OK for more goods than there were actually delivered.\nMake sure that the second value in each line is not greater than the actual amount of delivered goods!")
        return false; //submit wird nicht ausgeführt
    }

    return true; //submit wird ausgeführt
}

