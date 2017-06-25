<?php include 'inc/header.php'; ?>

<?php
if (isset($_GET['deliveryInfoID']) && isset($_GET['submit']) && !empty($_POST)) {
    $DeliveryInfoID = $_GET['deliveryInfoID'];
    $deliveryInfo = $db->getDeliveryInfo($DeliveryInfoID);
    $deliveredGoods = $db->getAllDeliveredGoods($deliveryInfo->getDeliveryInfoID());

    $i = 0;
    foreach ($deliveredGoods as $element) {
        //now update stock amount
        //var_dump($_POST);
        $checkbox = $_POST['checkbox'];
        if ($checkbox[$i]) {
            $db->updateStockAmount($element->getGoodsID(), $element->getAmount());
        }
        $i++;
    }
    $db->updatePurchaseOrderStatus($deliveryInfo->getPurchaseOrderID(), "completed");
    ?>
    <div class="row nexx-container">
        <h1>Purchase Order Completed</h1><br>
        <div class="col-md-2"></div>
        <div class="col-md-7">
            <div class="alert alert-success" role="alert">
                <strong>Success!</strong> The storage location and the stockamount of <strong style="color: red;"><?php echo $i; ?></strong> goods has been successfuly updated!<br>
                Click <a href="OpenPurchaseOrder.php">here</a> to return to the Overview.
            </div>                       

        </div>

        <div class="col-md-3"></div>
    </div>
    <?php
} else {
    ?>



    <?php
    if (isset($_GET['purchaseOrderID'])) {
        $PurchaseOrderID = $_GET['purchaseOrderID']; //purchaseorder id kam als get parameter mit mit dieser info alleine...
        $deliveryInfo = $db->getDeliveryInfoByPurchaseOrderID($PurchaseOrderID); //...such ich die zugehörige deliveryinfo aus der datenbank und speicher sie in ein DeliveryInfo Objekt, mit diesem Objekt kann man nun auch...
        $deliveredGoods = $db->getAllDeliveredGoods($deliveryInfo->getDeliveryInfoID()); //...alle gelieferten Prudukte bei dieser einen Lieferung in einem Objekt array abspeichern. Diese beiden Variablen haben nun die gesammte benötigte Information aus beiden tabellen abgespeichert.

        function createStorageLocation($categoryID, $goodsID) { //pseudo storagelocation generator normallerweise viel umfangreicher und agenau aufs lager zugeschnitten
            $tmpCat = ($categoryID - 1) % 26;
            $StorageLocationLetter = chr(ord("A") + ($tmpCat));
            $StorageLocationNumer = sprintf('%003d', $goodsID);
            return $StorageLocationLetter . $StorageLocationNumer;
        }

        $actualGoods = array();
        foreach ($deliveredGoods as $element) {
            $actualGoods[] = $db->getOneGood($element->getGoodsID()); //jetzt noch jedes produkt das tatsächlich bestellt wurde komplett reinholen (ohne die sub tabellen category und taxes daher PlainGood) 
        }

        $storageLocation = array();
        foreach ($actualGoods as $element) {
            $storageLocation[] = createStorageLocation($element->getCategoryID(), $element->getGoodsID());
        }
    }
    ?>

    <div class="row nexx-container">

        <div class="col-md-12">

            <h1>Complete Purchase Order</h1>





            <form class="form-horizontal" method="post" action="?deliveryInfoID=<?php echo $deliveryInfo->getDeliveryInfoID() ?>&submit=1" onsubmit="return checkCompletePurchaseOrderForm();">

                <table class="table table-hover nexx">
                    <tr>
                        <th>GoodsID</th>
                        <th>Good Name</th>
                        <th>Current Stock Amount</th>
                        <th>Delivered Amount</th>
                        <th>Storage Location</th>
                        <th>Check when finished storing!</th>
                    </tr>


                    <?php
                    $i = 0;
                    foreach ($deliveredGoods as $element) {
                        ?>
                        <tr>
                            <td><?php echo $element->getGoodsID(); ?></td>
                            <td>€ <?php echo $actualGoods[$i]->getName(); ?></td>
                            <td><?php echo $actualGoods[$i]->getStockAmount(); ?></td>
                            <td><?php echo $element->getAmount(); ?></td>
                            <td><strong>
                                    <?php
                                    if (!$actualGoods[$i]->getStorageLocation()) {
                                        echo $storageLocation[$i];
                                        $db->updateStorageLocation($element->getGoodsID(), $storageLocation[$i]);
                                    } else {
                                        echo $actualGoods[$i]->getStorageLocation();
                                    }
                                    ?>
                                </strong>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="inputCheckbox[]" name="checkbox[]"> [good transfered to designated location]
                                        </label>
                                    </div>
                                </div>
                            </td>


                        </tr>
                        <?php
                        $i++;
                    }
                    ?>

                </table>

                <div class="form-group">
                    <label for="employeeID" class="col-md-2 control-label">Employee</label>
                    <div class="col-md-3">
                        <select class="form-control" id="employeeID" placeholder="Employee" name="employeeID" required>
                            <option disabled selected value> -- select your name -- </option>
                            <?php
                            $employees = $db->getAllEmployees();
                            foreach ($employees as $employee) {
                                echo "<option value='" . $employee->getEmployeeID() . "'>" . $employee->getPerson_FirstName() . " " . $employee->getPerson_LastName() . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-offset-7 col-md-3">
                    <button value="submit" type="submit" class="btn btn-primary nexx">Finished moving Goods to storage location</button>
                </div>
            </form>


        </div>
    </div>
<?php } ?>

<?php include 'inc/footer.php'; ?>