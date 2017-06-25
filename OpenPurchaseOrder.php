<?php include 'inc/header.php'; ?>


<?php
if (empty($_GET['filter'])) {
    $load = 1;
} else {
    $load = $_GET['filter'];
}



$purchaseOrder = $db->getAllPurchaseOrder();
$seperatePurchaseOrder = array();



switch ($load) {
    case 1:
        foreach ($purchaseOrder as $element) {
            if ($element->getStatus() == "open") {
                $seperatePurchaseOrder[] = $element;
            }
        }
        break;
    case 2:
        foreach ($purchaseOrder as $element) {
            if ($element->getStatus() == "reviewed") {
                $seperatePurchaseOrder[] = $element;
            }
        }
        break;
    case 3:
        foreach ($purchaseOrder as $element) {
            if ($element->getStatus() == "completed") {
                $seperatePurchaseOrder[] = $element;
            }
        }
        break;
}
?>


<div class="row nexx-container">

    <div class="col-md-12">

        <h1>Open Purchase Order</h1>
        <nav class="navbar  navbar-inverse">
            <div class="container">
                <div id="navbar" class="navbar-collapse collapse">
                    <ul id="menu" class="nav navbar-nav">
                        <li><a href = "OpenPurchaseOrder.php?filter=1">Open</a></li>
                        <li><a href = "OpenPurchaseOrder.php?filter=2">Reviewed</a></li>
                        <li><a href = "OpenPurchaseOrder.php?filter=3">Completed</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

            <?php
            $cnt = 1;
            foreach ($seperatePurchaseOrder as $element) {
                ?>

                <div class="panel panel-default">
                    <div class="panel-heading nexx" role="tab" id="heading_<?php echo $cnt; ?>">
                        <h4 class="panel-title">
                            <a style="text-align:left !important" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $cnt; ?>" aria-expanded="false" aria-controls="collapse_<?php echo $cnt; ?>">
                                Purchase Order <?php echo $element->getPurchaseOrderID(); ?> from <?php echo $element->getDateTime(); ?> | status: <span class="<?php echo $element->getStatus(); ?>"><?php echo $element->getStatus(); ?></span>
                            </a>

                            <?php
                            switch ($load) {
                                case 1:
                                    ?>
                                    <button onclick="location.href = 'ReviewPurchaseOrder.php?purchaseOrderID=<?php echo $element->getPurchaseOrderID() ?>'"  class="btn btn-primary nexx2"> review this purchase order</button>
                                    <?php
                                    break;
                                case 2:
                                    ?>
                                    <button onclick="location.href = 'CompletePurchaseOrder.php?purchaseOrderID=<?php echo $element->getPurchaseOrderID() ?>'"  class="btn btn-primary nexx2"> complete this reviewed purchase order</button>
                                    <?php
                                    break;
                                case 3:

                                    break;
                            }
                            ?>
                        </h4>

                    </div>

                    <div id="collapse_<?php echo $cnt; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_<?php echo $cnt; ?>">
                        <div class="panel-body">
                            <table class="table table-hover nexx">
                                <tr>
                                    <th>PurchaseOrderID</th>
                                    <th>GoodsID</th>
                                    <th>PurchasedPrice</th>
                                    <th>Amount</th>
                                </tr>

                                <?php
                                $purchaseOrderHasGoods = $db->getAllPurchasedGoods($element->getPurchaseOrderID());
                                foreach ($purchaseOrderHasGoods as $good) {
                                    ?>
                                    <tr>
                                        <td><?php echo $good->getPurchaseOrderID() ?></td>
                                        <td><?php echo $good->getGoodsID(); ?></td>
                                        <td>€ <?php echo $good->getPurchasePrice(); ?></td>
                                        <td><?php echo $good->getAmount(); ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </table>
                        </div>
                    </div>
                </div>
                <?php
                $cnt++;
            }
            ?>


        </div>


    </div>
</div>


<?php include 'inc/footer.php'; ?>