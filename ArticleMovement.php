<?php 

include 'inc/header.php'; 

$db = new DB();
$id;

if(isset($_GET['product'])){
    $id = $_GET['product']+0;    
    $goodsarr = $db->getGoodById($id);
    
    $goodsid = $goodsarr[0];//
    $category = $goodsarr[1];//
    $manufacturer = $goodsarr[2];//
    $price = $goodsarr[3];
    $storagelocation = $goodsarr[4];
    $unit = $goodsarr[5];
    $minamount = $goodsarr[6];
    $stockamount = $goodsarr[7];
    $supplier = $goodsarr[8];//
    $taxname = $goodsarr[9];//
    $taxpercent = $goodsarr[10];//
    $name = $goodsarr[11];//
}
?>
<div class="goodstable-container">
    <table class="goodstable goodstable-left">
        <tr class="goodstable-left-tr">
            <td class="text-left goodstable-left-td-title">Good-ID</td>
            <td class="text-right goodstable-left-td"><?php echo $goodsid;?></td>
        </tr>
        <tr class="goodstable-left-tr">
            <td class="text-left goodstable-left-td-title">Name</td>
            <td class="text-right goodstable-left-td"><?php echo $name;?></td>
        </tr>
        <tr class="goodstable-left-tr">
            <td class="text-left goodstable-left-td-title">Category</td>
            <td class="text-right goodstable-left-td"><?php echo $category;?></td>
        </tr>
        <tr class="goodstable-left-tr">
            <td class="text-left goodstable-left-td-title">Manufacturer</td>
            <td class="text-right goodstable-left-td"><?php echo $manufacturer;?></td>
        </tr>
        <tr class="goodstable-left-tr">
            <td class="text-left goodstable-left-td-title">Supplier</td>
            <td class="text-right goodstable-left-td"><?php echo $supplier;?></td>
        </tr class="goodstable-left-tr">
        <tr class="goodstable-left-tr">
            <td class="text-left goodstable-left-td-title">Tax</td>
            <td class="text-right goodstable-left-td"><?php echo $taxname.", ".$taxpercent*100 ." %";?></td>
        </tr>
    </table>

    <table class="goodstable goodstable-right">
        <tr class="goodstable-right-tr">
            <td class="text-left goodstable-right-td-title">Saleprice</td>
            <td class="text-right goodstable-right-td"><?php echo "€ ".$price;?></td>
        </tr>
        <tr class="goodstable-right-tr">
            <td class="text-left goodstable-right-td-title">Storage location</td>
            <td class="text-right goodstable-right-td"><?php echo $storagelocation;?></td>
        </tr>
        <tr class="goodstable-right-tr">
            <td class="text-left goodstable-right-td-title">Minimum amount</td>
            <td class="text-right goodstable-right-td"><?php echo $minamount;?></td>
        </tr>
        <tr class="goodstable-right-tr">
            <td class="text-left goodstable-right-td-title">Stock amount</td>
            <td class="text-right goodstable-right-td"><?php echo $stockamount;?></td>
        </tr>
        <tr class="goodstable-right-tr">
            <td class="text-left goodstable-right-td-title">Unit</td>
            <td class="text-right goodstable-right-td"><?php echo $unit;?></td>
        </tr>
        <tr class="goodstable-right-tr">
            <td class="goodstable-right-td-title"><br/></td>
            <td class="goodstable-right-td"><br/></td>
        </tr>
    </table>
</div>
<div class="movement-container">
    <div class="movement-incoming-container">
        <div class="row">
            <h2 class="text-left movement-headline mh-title">Incoming movement</h2>
        </div>
        <table class="table movement-incoming-table">
            <thead>
                <tr>
                    <td>Purchase order ID</td>
                    <td>Order amount</td>
                    <td>Delivery amount</td>
                    <td>Order date</td>
                    <td class="goods-deliverydate"><div class="goods-incdate">Delivery date</div></td>
                </tr>
            </thead>
            <tbody class="movement-incoming-table-body">
                <?php $db->printOutgoingMovementById($id,true)?>
            </tbody>
        </table>
    </div>
    <div class="movement-outgoing-container">
        <div class="row">
            <h2 class="text-left movement-headline mh-title">Outgoing movement</h2>
        </div>
        <table class="table movement-outgoing-table">
            <thead>
                <tr>
                    <td>Sale order ID</td>
                    <td>Order amount</td>
                    <td>Order date</td>
                    <td class="goods-deliverydate"><div class="goods-outdate">Delivery date</div></td>
                </tr>
            </thead>
            <tbody class="movement-outgoing-table-body">
                <?php $db->printIncomingMovementById($id,true)?>
            </tbody>
        </table>
    </div>
</div>
<?php  include 'inc/footer.php';?>