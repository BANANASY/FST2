<?php
include 'inc/header.php';
?>
<!--filter hohlen-->
<?php
if (empty($_GET['salesid']) || !is_numeric($_GET['salesid'])) {
    header("Location: OpenSalesOrder.php");
} else {
    $load = $_GET['salesid'];
}
?>

<h1 class="page-header">Review</h1>

<?php
$db = new DB();
$db->processSC($load);
?>
<form class="form" method="get" action="CompleteSalesOrder.php">
    <button name="completeThis" value="<?php echo $load ?>" type="submit" class="btn btn-warning">Review completed</button>
</form>

<?php include 'inc/footer.php'; ?>