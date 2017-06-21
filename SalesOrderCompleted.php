<?php
include 'inc/header.php';

if (empty($_GET['complete']) || !is_numeric($_GET['complete'])) {
    header("Location: OpenSalesOrder.php");
} else {
    $salesId = $_GET['complete'];
    $db = new DB();
    if($db->completeSalesOrder($salesId)){
        echo "<p class='bg bg-success'>Congratulations you just did your job.</p>";
    } else {
        echo "<p class='bg bg-danger'>Error: Couldn't complete salesorder.</p>";
    }
}
?>

<?php include 'inc/footer.php'; ?>