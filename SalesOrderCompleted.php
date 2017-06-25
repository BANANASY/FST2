<?php
include 'inc/header.php';
include 'model/SalesOrder.class.php';
include 'model/GoodsLight.class.php';
echo "<div class='container'>";

if (empty($_GET['complete']) || !is_numeric($_GET['complete'])) {
    header("Location: OpenSalesOrder.php");
} else {
    $salesId = $_GET['complete'];
    $db = new DB();
    $so = new salesOrder($salesId);
    $so->deductFromStock();


    if ($db->completeSalesOrder($salesId)) {
        header("Location: OpenSalesOrder.php?filter=3");
    } else {
        echo "<p class='bg bg-danger'>Error: Couldn't complete salesorder. DB connection error</p>";
    }
}
?>
</div>
<?php include 'inc/footer.php'; ?>
