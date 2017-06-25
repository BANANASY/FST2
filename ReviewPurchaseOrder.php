<?php include 'inc/header.php'; ?>

<?php
$purchaseOrderID = null;
if (isset($_GET['purchaseOrderID'])) {
    $purchaseOrderID = $_GET['purchaseOrderID'];
    $purchaseOrder = $db->getOnePurchaseOrder($purchaseOrderID);

    if (isset($_GET['submit']) && !empty($_POST)) {
        $error = false;

        //var_dump($_POST);
        //hier schreib die tabelle delivered_info voll 

        $EmployeeID = $_POST['employeeID']; //die ware übernimmt natürlich ein andere employee als der, der die ware bestellt hat
        $SupplierID = $purchaseOrder->getSupplierID(); //sollte wohl hoffentlich der selbe supplier seib bei dem auch bestellt wurde
        $PurchaseOrderID = $purchaseOrder->getPurchaseOrderID();
        $DeliverySlipScanID = null; //noch keine scan funktion eingebaut daher bleibt das mal auf null
        $date = new DateTime();
        $IncomeDateTime = $date->format('Y-m-d H:i:s');
        $DeliveryInformation = $_POST['deliveryInformation'];

        $deliveryInfo = new DeliveryInfo(null, $EmployeeID, $SupplierID, $PurchaseOrderID, $DeliverySlipScanID, $IncomeDateTime, $DeliveryInformation);

        $DeliveryInfoID = $db->insertDeliveryInfo($deliveryInfo);


        $purchasedGoods = $db->getAllPurchasedGoods($PurchaseOrderID);

        if (!$DeliveryInfoID || !$purchasedGoods) {
            $error = true;
        }

        $deliveredGoodsAmount = $_POST['deliveredGoodsAmount'];
        $qualityOKofGoods = $_POST['qualityOKofGoods'];

        $length = count($deliveredGoodsAmount);

        if (!$error) {
            for ($i = 0; $i < $length; $i++) {
                $deliveredGood = new DeliveredGoods($DeliveryInfoID, $purchasedGoods[$i]->getGoodsID(), $deliveredGoodsAmount[$i], $qualityOKofGoods[$i]);
                if (!$db->insertOneDeliveredGood($deliveredGood)) {
                    $error = true;
                } else {
                    if (!$db->updatePurchaseOrderStatus($PurchaseOrderID, "reviewed")) {
                        $error = true;
                    }
                }
            }
        }
        if (!$error) {
            ?>
            <div class="row nexx-container">
                <h1>Review Purchase Order Nr. <?php echo $purchaseOrder->getPurchaseOrderID(); ?></h1><br>
                <div class="col-md-2"></div>
                <div class="col-md-7">
                    <div class="alert alert-success" role="alert">
                        <strong>Success!</strong> A new Delivery Information entry was created!<br>
                        Click <a href="OpenPurchaseOrder.php">here</a> to return to the Overview.
                    </div>                       

                </div>

                <div class="col-md-3"></div>
            </div>
            <?php
        } else {
            ?>
            <div class="row nexx-container">
                <h1>Review Purchase Order Nr. <?php echo $purchaseOrder->getPurchaseOrderID(); ?></h1><br>
                <div class="col-md-2"></div>
                <div class="col-md-7">
                    <div class="alert alert-danger" role="alert">
                        <strong>Failure!</strong> No Delivery Information entry created!<br>
                        Click <a href="OpenPurchaseOrder.php">here</a> to return to the Overview.
                    </div>                       

                </div>

                <div class="col-md-3"></div>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="row nexx-container">

            <div class="col-md-12">

                <h1>Review Purchase Order Nr. <?php echo $purchaseOrder->getPurchaseOrderID(); ?></h1>

                <form class="form-horizontal" method="post" action="?purchaseOrderID=<?php echo $purchaseOrderID ?>&submit=1" onsubmit="return checkPurchaseOrderReviewForm();">




                    <table class="table table-hover nexx">
                        <tr>
                            <th>GoodsID</th>
                            <th>PurchasedPrice</th>
                            <th>Ordered Amount</th>
                            <th>Delivered Amount</th>
                            <th>Quality is OK</th>
                        </tr>


                        <?php
                        $purchaseOrderHasGoods = $db->getAllPurchasedGoods($purchaseOrder->getPurchaseOrderID());

                        foreach ($purchaseOrderHasGoods as $good) {
                            ?>
                            <tr>
                                <td><?php echo $good->getGoodsID(); ?></td>
                                <td>€ <?php echo $good->getPurchasePrice(); ?></td>
                                <td><?php echo $good->getAmount(); ?></td>
                                <td>
                                    <div class="form-group">
                                        <input type="number" class="form-control nexx" id="deliveredGoodsAmount[]" name="deliveredGoodsAmount[]" required value="0" min="0">
                                    </div>
                                </td> 
                                <td>
                                    <div class="form-group">
                                        <input type="number" class="form-control nexx" id="qualityOKofGoods[]" name="qualityOKofGoods[]" required value="0" min="0">
                                    </div>
                                </td> 

                            </tr>
                            <?php
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
                    <div class="form-group">
                        <label for="deliveryInformation" class="col-md-2 control-label">Delivery Information</label>
                        <div class="col-md-4">
                            <textarea class="form-control" rows="3" id="deliveryInformation" placeholder="Additional Information of the Delivery" name="deliveryInformation"></textarea>
                        </div>
                    </div>

                    <div class="col-md-offset-8 col-md-2">
                        <button value="submit" type="submit" class="btn btn-primary nexx">Submit</button>
                    </div>
                </form>

            </div>



        </div>
        <?php
    }
}
?>

<?php include 'inc/footer.php'; ?>