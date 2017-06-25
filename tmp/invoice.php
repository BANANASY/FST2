<?php
require_once("../utilities/DB.php");
$db = new DB();
$db->connectDB();

require_once("../models/Order.php");
require_once("../models/Good.php");

$SalesOrderID = $_GET['order'];
$PersonID = $_GET['user'];
$order = $db->getOrderInvoice($SalesOrderID);
$discount = $db->getDiscountPercentage($PersonID);

$customer = $db->getPerson($PersonID);

$paymentType = $db->getPaymentType($order->getPaymentID());
$paymentNumber = $db->getPaymentNumber($order->getPaymentID());

if ($paymentType == 2) {
    $type = "Bannkeinzug";
} elseif ($paymentType == 1) {
    $type = "Kreditkarte";
} else {
    $type = "Unbekannt";
}
?>
<link rel="stylesheet" href="../css/invoice.css">
<html>
<head>
    <meta charset="utf-8">
    <title>Digital Beauty - Rechnug </title>
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="../images/db_logo.png">
    </div>
    <h1>RECHNUNG - <?php echo $order->getSalesOrderID(); ?></h1>
    <div id="company" class="clearfix">
        <div>Digital Beauty</div>
        <div>Beautystreet 01<br/> 1010 Wien</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">digital@beauty.com</a></div>
    </div>
    <div id="project">
        <div><span>NAME</span><?php echo $customer->getFirstName();
            echo " ";
            echo $customer->getLastName(); ?></div>
        <div><span>ADRESSE</span><?php echo $customer->getAddress();
            echo "<br><span></span>";
            echo $customer->getZIP();
            echo " ";
            echo $customer->getCity();
            echo "<br><span></span>";
            echo $customer->getCountry(); ?></div>
        <div><span>EMAIL</span> <a href="mailto:john@example.com"><?php echo $customer->getEmail(); ?></a></div>
        <div><span>DATUM</span><?php echo $order->getDate(); ?></div>
    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th class="service">PRODUKT</th>
            <th class="desc">KATEGORIE -<br>BESCHREIBUNG</th>
            <th>PREIS<br>PRO STÜCK</th>
            <th>STÜCK</th>
            <th>STEUER</th>
            <th>GESAMTPREIS</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $goods = array();
        $goods = $order->getGoods();
        $result = count($goods);

        $cnt = 1;

        $total = 0;

        for ($i = 0; $i <= $result - 1; $i++) {

            $good = $goods[$i];
            $amount = $db->getGoodAmount($good->getGoodsID(), $SalesOrderID);
            $sum = number_format($good->getCurrentNetSalesPrice() * $amount, 2);
            $price = number_format($good->getCurrentNetSalesPrice(), 2);
            $total = number_format($total + $sum, 2);
            ?>
            <tr>
                <td class="service"><?php echo $good->getName(); ?></td>
                <td class="desc"><?php echo $good->getCategory();
                    echo " - ";
                    echo $good->getDescription(); ?></td>
                <td class="unit"><?php echo $price; ?>€</td>
                <td class="qty"><?php echo $amount; ?></td>
                <td><?php echo $good->getTax(); ?>%</td>
                <td class="total"><?php echo $sum; ?>€</td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="5">SUMME</td>
            <td class="total"><?php echo $total; ?>€</td>
        </tr>
        <tr>
            <td colspan="5">RABATT</td>
            <td class="total"><?php echo $discount ?>%</td>
        </tr>
        <tr>
            <?php
            if ($discount == 0 || $discount == null) {
                $totalDiscount = $total;
            } else {
                $totalDiscount = $total - ($total * ($discount / 100));
            }
            ?>
            <td colspan="5" class="grand total">SUMME NACH RABATT</td>
            <td class="grand total"><?php echo $totalDiscount; ?>€</td>
        </tr>
        </tbody>
    </table>
    <div id="notices">
        <div class="notice" align="center"><?php echo "ZAHLUNG: "; echo $type;
            echo " ";
            echo $paymentNumber; ?></div>
    </div>
</main>
</body>
</html>