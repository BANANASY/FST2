<?php
$SalesOrderID = $_GET['order'];
$order = $db->getOrder($SalesOrderID);

$PersonID = $user->getPersonID();
$CustomerID = $db->getCustomerID($PersonID);

$discount = $db->getDiscountPercentage($PersonID);

?>
<!-- order information form, with tables to give information to the user !-->
<form method="post">
    <div align="center">
        <h2>Bestellungsinformationen - <?php echo $order->getSalesOrderID(); ?></h2>
        <table class="table tablewidth">
            <h3>Käuferinformationen:</h3>
            <tr>
                <td><label>Anrede</label></td>
                <td><label>Vorname</label></td>
                <td><label>Nachname</label></td>
                <td><label>Straße</label></td>
                <td><label>PLZ</label></td>
                <td><label>Ort</label></td>
                <td><label>Land</label></td>
                <td><label>Telefonnummer</label></td>
                <td><label>E-Mail</label></td>
            </tr>
            <?php
            echo "<tr>";
            echo "<td>" . $user->getTitle() . "</td><td>" . $user->getFirstName() . "</td><td>" . $user->getLastName() . "</td><td>" . $user->getAddress() . "</td>";
            echo "<td>" . $user->getZIP() . "</td><td>" . $user->getCity() . "</td><td>" . $user->getCountry() . "</td><td>" . $user->getPhonenumber() . "</td><<td>" . $user->getEmail() . "</td>";
            echo "</tr>";
            ?>
        </table>
        <table class="table tablewidth">
            <h3>bestellte Produkte:</h3>
            <tr>
                <td><label>#</label></td>
                <td><label>Bezeichnung</label></td>
                <td><label>Beschreibung</label></td>
                <td><label>Kategorie</label></td>
                <td><label>Menge</label></td>
                <td><label>Preis pro Stück</label></td>
                <td><label>Steuersatz</label></td>
                <td><label>Gesamtpreis</label></td>
            </tr>
            <?php
            //get/show the orderd products
            $goods = array();
            $goods = $order->getGoods();
            $result = count($goods);
            //für die anzahl der verschiedenen Produkte
            $cnt = 1;

            //für die gesamtsumme der Bestellung
            $total = 0;

            for ($i = 0; $i <= $result - 1; $i++) {

                $good = $goods[$i];
                $amount = $db->getGoodAmount($good->getGoodsID(), $SalesOrderID);
                $sum = number_format($good->getCurrentNetSalesPrice() * $amount, 2);

                echo "<tr>";
                echo "<td>" . $cnt . "</td><td>" . $good->getName() . "</td><td>" . $good->getDescription() . "</td><td>" . $good->getCategory() . "</td>";
                echo "<td>" . $amount . " Stk.</td><td>" . $good->getCurrentNetSalesPrice() . " € </td><td>" . $good->getTax() . " % </td><td>" . $sum . " €</td>";
                echo "</tr>";
                $total = number_format($total + $sum, 2);
                $cnt++;
            }
            echo "<tr>";
            echo "<td></td><td></td><td></td><td></td><td></td><td></td><td><label>Summe: </label></td><td><label>" . $total . " €</label></td>";
            echo "</tr><tr>";
            echo "<td></td><td></td><td></td><td></td><td></td><td></td><td><label>Rabatt: </label></td><td><label>" . $discount . " %</label></td>";
            echo "</tr><tr>";
            if($discount == 0 || $discount == null){
                $totalDiscount = $total;
            }else{
                $totalDiscount = $total - ($total * ($discount/100));
            }
            echo "<td></td><td></td><td></td><td></td><td></td><td></td><td><label>Rabatt: </label></td><td><label>" . $totalDiscount . " €</label></td>";
            echo "</tr>";
            ?>
        </table>
        <table class="table tablewidth">
            <h3>Zahlungsinormationen: </h3>
            <?php
            $paymentType = $db->getPaymentType($order->getPaymentID());
            $paymentNumber = $db->getPaymentNumber($order->getPaymentID());
            ?>
            <tr>
                <td><label>Art</label></td>
                <td><label>Nummer/IBAN</label></td>
            </tr>

            <?php
            if($paymentType == 2){
                $type = "Bannkeinzug";
            }elseif ($paymentType == 1){
                $type = "Kreditkarte";
            }else{
                $type = "Unbekannt";
            }
            echo "<tr>";
            echo "<td>" . $type . "</td><td>" . $paymentNumber . "</td>";
            echo "</tr>";
            echo "</table>";

            //gives project_name in your case
            $url = $_SERVER['REQUEST_URI'];
            $url_parse = parse_url($url);
            $path = explode('/', $url_parse ['path']);

            $server_url = $_SERVER['SERVER_NAME'] . ":88/" . $path[1];
            echo "<a target='_blank' href='http://$server_url/sites/invoice.php?order=$SalesOrderID&user=$PersonID' class='btn btn-info'>Rechnung drucken</a>";
            ?>
    </div>
</form>
