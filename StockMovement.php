<?php 

include 'inc/header.php'; 

$db = new DB();
?>

<table class="table table-hover goods_table">
    <?php
        $db->printGoodsList();
    ?>
</table>



<?php  include 'inc/footer.php';?>