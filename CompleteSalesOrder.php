<?php
include 'inc/header.php';

if (empty($_GET['completeThis']) || !is_numeric($_GET['completeThis'])) {
    header("Location: OpenSalesOrder.php");
} else {
    $completeThis = $_GET['completeThis'];
    $db = new DB();
    if ($db->markReviewed($completeThis)) {
        $db->getFinalRemarks($completeThis);
        echo date("Y-m-d H:m:s");
    } else {
        echo "Error: Couldn't mark this Salesorder as Reviewed.";
    }
}
?>

<form class="form" method="get" action="SalesOrderCompleted.php">
    <button name="complete" value="<?php echo $completeThis ?>" type="submit" class="btn btn-danger">Shipment completed</button>
</form>


<?php include 'inc/footer.php'; ?>