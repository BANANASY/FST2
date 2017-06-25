<?php
include 'inc/header.php';
echo "<div class = 'container k'>";
if (empty($_GET['completeThis']) || !is_numeric($_GET['completeThis'])) {
    header("Location: OpenSalesOrder.php");
} else {
    $completeThis = $_GET['completeThis'];
    $db = new DB();
    echo "<h1 class='page-header'>Shipment</h1>";
    if ($db->markReviewed($completeThis)) {
        echo "<div class='jumbotron'>";
        echo "<span class='badge pull-right'>". date("Y-m-d H:m:s", time())."</span><br>";
        $db->getFinalRemarks($completeThis);
        echo "<br><button class='btn btn-primary' onclick='bananaPrint()'>Print</button>";


        echo "</div>";
    } else {
        echo "Error: Couldn't mark this Salesorder as Reviewed.";
    }
}
?>

<form class="form" method="get" action="SalesOrderCompleted.php">
    <button name="complete" value="<?php echo $completeThis ?>" type="submit" class="btn btn-success">Complete</button>
</form>
<br>
<br>
</div>

<?php include 'inc/footer.php'; ?>
<script>
    function bananaPrint() {
        window.print();
    }
</script>