<?php
$PersonID = $user->getPersonID();
$CustomerID = $db->getCustomerID($PersonID);

$orders = $db->getOrdersNew($CustomerID);
$result = count($orders);
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=orderInformation">
    <table class="table tablewidth">
        <h2>Bestellungen</h2>
        <tr>
            <td><label>#</label></td>
            <td><label>Bestellungsnummer</label></td>
            <td><label>Datum</label></td>
            <td></td>
        </tr>
        <?php

        $order = new Order();

        for ($i = 0; $i <= $result - 1; $i++) {

            $order = $orders[$i];
            $salesOrderID = $order->getSalesOrderID();
            $cnt = $i + 1;
            echo "<tr>";
            echo "<td>" . $cnt . "</td><td>" . $order->getSalesOrderID() . "</td><td>" . $order->getDate() . "</td>";
            echo "<td><a href='?page=orderInformation&order=$salesOrderID' class='btn btn-default'>Bestellungsdetails</a></td>";
            echo "</tr>";
        }
        ?>

    </table>
</form>
