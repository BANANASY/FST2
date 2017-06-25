<?php
include 'inc/header.php';
include 'model/SalesOrder.class.php';
include 'model/GoodsLight.class.php';
?>
<!--filter hohlen-->
<?php
if (empty($_GET['filter'])) {
    $load = 1;
} else {
    $load = $_GET['filter'];
}
?>
<!--Navigation-->
<div class = "container k">
    <h1 class="page-header">Sales overview</h1>
    <nav class="navbar  navbar-inverse">
        <div class="container">
            <div id="navbar" class="navbar-collapse collapse">
                <ul id="menu" class="nav navbar-nav">
                    <li><a href = "OpenSalesOrder.php?filter=1">Open</a></li>
                    <li><a href = "OpenSalesOrder.php?filter=2">Reviewed</a></li>
                    <li><a href = "OpenSalesOrder.php?filter=3">Completed</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
    $db = new DB();
    switch ($load) {
        case 1:
            $db->getOpenSC();
            $soso = new salesOrder(1);
            $soso->getGoodsCount();
            break;
        case 2:
            $db->getProcessedSC();
            break;
        case 3:
            ?>
            <table class="table table-hover">
                <thead>
                <th>salesOrderId</th><th>ordered</th><th>shipped</th><th>customer</th><th>goods</th>
                </thead>
                <tbody>
                    <?php
                    $db->getCompletedSC();
                    echo "</tbody></table>";
                    break;
            }
            ?>
            </div>

            <?php include 'inc/footer.php'; ?>

        <script>
            function processSC($salesId)
            {
                location.href = "ReviewSalesOrder.php?salesid=" + $salesId;
            }
        </script>