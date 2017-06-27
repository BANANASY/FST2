<?php
include 'inc/header.php';
include 'model/SalesOrder.class.php';
include 'model/GoodsLight.class.php';
?>
<!--filter hohlen-->
<?php
if (empty($_GET['salesid']) || !is_numeric($_GET['salesid'])) {
    header("Location: OpenSalesOrder.php");
} else {
    $salesid = $_GET['salesid'];
}
?>
<div class="noOverflow">
    <div class = "container k">
        <h1 class="page-header">Review</h1>

        <?php
        $db = new DB();
        $db->processSC($salesid);
        $so = new salesOrder($salesid);
        $readyToGo = $so->isReadyForShipping();
        if ($readyToGo) {
            ?>
            <form class="form" method="get" action="CompleteSalesOrder.php">
                <button name="completeThis" value="<?php echo $salesid ?>" type="submit" class="btn btn-success">Ready</button>
            </form>
            <br>
            <br>
            <?php
        } else {
            echo "<button class='btn btn-danger'>Waiting for goods</button>";
            echo "<br><br>";
        }
        ?>
    </div>
</div>
<?php include 'inc/footer.php'; ?>