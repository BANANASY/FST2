<?php  

include 'inc/header.php'; 

$db = new DB();
?>
<div class="goodsoverview-container">
    <table class="table table-hover goods_table">
        <thead>
            <tr>
                <td class="goodsoverview-th goodsoverview-search-row goodsoverview-minify"></td>
                <td class="goodsoverview-th goodsoverview-search-row" colspan="2">
                    <input type="text" id='search-input' class="form-control" placeholder="Search">
                </td>
                <td class="goodsoverview-th goodsoverview-search-row goodsoverview-minify">
                </td>
            </tr>
            <tr>
                <td class="goodsoverview-th goodsoverview-minify">Good-ID</td>
                <td class="goodsoverview-th">Name</td>
                <td class="goodsoverview-th goodsoverview-minify">Min amount</td>
                <td class="goodsoverview-th goodsoverview-minify">Stock amount</td>
            </tr>
        </thead>
        <tbody>
            <?php
                $db->printGoodsList();
            ?>
        </tbody>  
    </table>
</div>


<?php  include 'inc/footer.php';?>