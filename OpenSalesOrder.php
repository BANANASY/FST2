<?php include 'inc/header.php'; ?>
<!--filter hohlen-->
<?php
if (empty($_GET['filter'])) {
    $load = 1;
} else {
    $load = $_GET['filter'];
}
?>
<!--Navigation-->
<h1 class="page-header">Sales overview</h1>
<nav class="navbar  navbar-inverse">
    <div class="container">
        <div id="navbar" class="navbar-collapse collapse">
            <ul id="menu" class="nav navbar-nav">
                <li><a href = "OpenSalesOrder.php?filter=1">Open</a></li>
                <li><a href = "OpenSalesOrder.php?filter=2">In process</a></li>
                <li><a href = "OpenSalesOrder.php?filter=3">Closed</a></li>
            </ul>
        </div>
    </div>
</nav>



<?php include 'inc/footer.php'; ?>