<?php

class DB {

    private $host = "wi-projectdb.technikum-wien.at";
    private $user = "s17-bvz2-fst-23";
    private $password = "DbPass4v023";
    private $dbname = "s17-bvz2-fst-20";
    private $connection = null;

    function connect2DB() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        return $this->connection;
    }

    function getAddress() {
        $address = array();

        $con = $this->connect2DB();
        $query = "SELECT * FROM address";
        $result = $con->query($query);
        if ($result) {
            while ($line = $result->fetch_object()) {
                $address[] = new Address($line->AddressID, $line->Address, $line->ZIP, $line->City, $line->Country);
            }
            $con->close();
            return $address;
        } else {
            $con->close();
            return false;
        }
    }

//
//        $address = array();
//        $con = $this->connect2DB();
//        $query = "SELECT * FROM address";
//        $result = $con->prepare($query);
//        $result->execute();
//        $result->bind_result($addressID, $address, $zip, $city, $country);
//        if ($result) {
//            while ($result) {
//                $address[] = new Address($addressID, $address, $zip, $city, $country);
//            }
//        }
//
//
//        $con->close();
//        return $address;
//    }
    
    function printGoodsList(){
        $conn = $this->connect2DB();
        
        $stmt = "SELECT GoodsID, Name, StockAmount, CurrentNetSalesPrice FROM goods WHERE active = 1 ORDER BY GoodsID;";
        
        if($ergebnis = $conn->prepare($stmt)){
            if($ergebnis->execute()){
                $ergebnis->bind_result($id, $name, $stockAmount, $saleprice);
                if($ergebnis){
                    while($ergebnis->fetch()){
                        echo "<tr class='goodCage'>";
                        echo "<td class='good_id'>".$id."</td>";
                        echo "<td>".$name."</td>";
                        echo "<td>".$stockAmount."</td>";
                        echo "<td>".$saleprice."</td>";
                        echo "</tr>";
                    }
                }
            }
        }
    }
    
    function getGoodById ($id) {       
        $id = $id + 0;
        $conn = $this->connect2DB();
        $stmt = "SELECT g.GoodsID, 
                        gc.Title, 
                        g.Name, 
                        g.Manufacturer, 
                        g.CurrentNetSalesPrice AS Price,
                        g.StorageLocation,
                        g.Unit,
                        g.MinAmount,
                        g.StockAmount,
                        s.Name AS supplier_name,
                        t.Name AS tax,
                        t.Percent 
                    FROM goods g
                    JOIN goodscategory gc USING (categoryid)
                    JOIN supplier_has_goods USING (goodsid)
                    JOIN taxes t USING (taxid)
                    JOIN supplier s USING (supplierid)
                    WHERE goodsid = ?";
        if ($ergebnis = $conn->prepare($stmt)) {
            $ergebnis->bind_param("i", $id);
            if ($ergebnis->execute()) {
                $ergebnis->bind_result( $goodsid, 
                                        $category,
                                        $name,
                                        $manufacturer, 
                                        $price, 
                                        $storagelocation,
                                        $unit,
                                        $minamount,
                                        $stockamount,
                                        $supplier,
                                        $taxname,
                                        $taxpercent);
                if ($ergebnis) {                   
                    while ($ergebnis->fetch()) {
                        $goodsarr = [];
                        $goodsarr[0] = $goodsid;
                        $goodsarr[1] = $category;
                        $goodsarr[2] = $manufacturer;
                        $goodsarr[3] = $price;
                        $goodsarr[4] = $storagelocation;
                        $goodsarr[5] = $unit;
                        $goodsarr[6] = $minamount;
                        $goodsarr[7] = $stockamount;
                        $goodsarr[8] = $supplier;
                        $goodsarr[9] = $taxname;
                        $goodsarr[10] = $taxpercent;
                        $goodsarr[11] = $name;
                        
                        return $goodsarr;
                    }         
                }  
            }
        }     
    }
    
    //IS ACTUALLY INCOMING BUT TOO LAZY TO CORRECT
    function printOutgoingMovementById($id, $asc){
        $conn = $this->connection;
        $stmt;
        
        if($asc){
            $stmt = "SELECT 
                        di.purchaseorderid, 
                        phg.Amount AS OrderAmount, 
                        dhg.Amount AS DeliveryAmount,
                        po.DateTime AS OrderDate,
                        di.IncomeDateTime AS DeliveryDate
                    FROM purchaseorder_has_goods phg
                    JOIN purchaseorder po USING (purchaseorderid)
                    JOIN deliveryinfo di USING (purchaseorderid)
                    JOIN delivery_has_goods dhg USING (deliveryinfoid)
                    WHERE dhg.goodsid = ? AND po.status = 'completed'
                    GROUP BY dhg.DeliveryInfoID, dhg.GoodsID
                    ORDER BY deliverydate asc;";
        }else{
            $stmt = "SELECT 
                        di.purchaseorderid, 
                        phg.Amount AS OrderAmount, 
                        dhg.Amount AS DeliveryAmount,
                        po.DateTime AS OrderDate,
                        di.IncomeDateTime AS DeliveryDate
                    FROM purchaseorder_has_goods phg
                    JOIN purchaseorder po USING (purchaseorderid)
                    JOIN deliveryinfo di USING (purchaseorderid)
                    JOIN delivery_has_goods dhg USING (deliveryinfoid)
                    WHERE dhg.goodsid = ? AND po.status = 'completed'
                    GROUP BY dhg.DeliveryInfoID, dhg.GoodsID
                    ORDER BY deliverydate desc;";
        }
        
        if ($ergebnis = $conn->prepare($stmt)) {
            $ergebnis->bind_param("i", $id);
            if ($ergebnis->execute()) {
                $ergebnis->bind_result( $purchaseorderid, 
                                        $orderamount,
                                        $deliveryamount,
                                        $orderdate,
                                        $deliverydate);
                if ($ergebnis) {                   
                    while ($ergebnis->fetch()) {
                        echo "<tr class='goods-entries'>";
                        echo "<td data-field-type='number'>".$purchaseorderid."</td>";
                        echo "<td data-field-type='number'>".$orderamount."</td>";
                        echo "<td data-field-type='number'>".$deliveryamount."</td>";
                        echo "<td data-field-type='date'>".$orderdate."</td>";
                        echo "<td data-field-type='date' class='goods-inc-deliverydate'>".$deliverydate."</td>";
                        echo "<tr>";
                    }
                }
            }
        }
    }  
    
    //IS ACTUALLY OUTGOING, BUT TOO LAZY TO CORRECT
    function printIncomingMovementById($id,$asc){
        $conn = $this->connection;
        $stmt;
        
        if($asc){
            $stmt = "SELECT 
                        so.salesorderid,
                        shg.amount AS DeliveryAmount,
                        so.DateTime AS OrderDate,
                        so.OutgoingDateTime AS DeliveryDate
                    FROM salesorder_has_goods shg
                    JOIN salesorder so USING (salesorderid)
                    WHERE shg.goodsid = ? AND so.status = 'completed'
                    GROUP BY shg.goodsid, shg.salesorderid
                    ORDER BY deliverydate asc;";
        }else{
            $stmt = "SELECT 
                        so.salesorderid,
                        shg.amount AS DeliveryAmount,
                        so.DateTime AS OrderDate,
                        so.OutgoingDateTime AS DeliveryDate
                    FROM salesorder_has_goods shg
                    JOIN salesorder so USING (salesorderid)
                    WHERE shg.goodsid = ? AND so.status = 'completed'
                    GROUP BY shg.goodsid, shg.salesorderid
                    ORDER BY deliverydate desc;";
        }
        
        if ($ergebnis = $conn->prepare($stmt)) {
            $ergebnis->bind_param("i", $id);
            if ($ergebnis->execute()) {
                $ergebnis->bind_result( $salesorderid, 
                                        $deliveryamount,
                                        $orderdate,
                                        $deliverydate);
                if ($ergebnis) {                   
                    while ($ergebnis->fetch()) {
                        echo "<tr class='goods-entries'>";
                        echo "<td data-field-type='number'>".$salesorderid."</td>";
                        echo "<td data-field-type='number'>".$deliveryamount."</td>";
                        echo "<td data-field-type='date'>".$orderdate."</td>";
                        echo "<td data-field-type='date' class='goods-out-deliverydate'>".$deliverydate."</td>";
                        echo "<tr>";
                    }
                }
            }
        }
    }
}
