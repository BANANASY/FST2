<?php include 'inc/header.php'; ?>


<?php
$purchaseOrder = $db->getAllPurchaseOrder();
?>


<div class="row nexx-container">

    <div class="col-md-12"><br>

        <h1>Open Purchase Order</h1>


        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

            <?php
            $cnt = 1;
            foreach ($purchaseOrder as $element) {
                ?>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading_<?php echo $cnt; ?>">
                        <h4 class="panel-title">
                            <a style="text-align:left !important" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $cnt; ?>" aria-expanded="false" aria-controls="collapse_<?php echo $cnt; ?>">
                                Purchase Order <?php echo $element->getPurchaseOrderID(); ?> from <?php echo $element->getDateTime(); ?> | status: <span class="<?php echo $element->getStatus(); ?>"><?php echo $element->getStatus(); ?></span>
                            </a>
                            <a href="ReviewPurchaseOrder.php?purchaseOrderID=<?php echo $element->getPurchaseOrderID() ?>"  style="text-align:right; float: right; color:cornflowerblue;"> [open this purchase order]</a>
                        </h4>
                    </div>
                    <div id="collapse_<?php echo $cnt; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_<?php echo $cnt; ?>">
                        <div class="panel-body">
                            <table class="table table-hover nexx">
                                <tr>
                                    <th>PurchaseOrderID</th>
                                    <th>GoodsID</th>                  
                                    <th>Amount</th>
                                    <th>PurchasedPrice</th>
                                </tr>

                                <?php
                                $purchaseOrderHasGoods = $db->getAllPurchasedGoods($element->getPurchaseOrderID());
                                foreach ($purchaseOrderHasGoods as $good) {
                                    ?>
                                    <tr>
                                        <td><?php echo $good->getPurchaseOrderID() ?></td>
                                        <td><?php echo $good->getGoodsID(); ?></td>
                                        <td><?php echo $good->getAmount(); ?></td>
                                        <td>€ <?php echo $good->getPurchasePrice(); ?></td>
                                        <td> 
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

</div>

<?php include 'inc/footer.php'; ?>