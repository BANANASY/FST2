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

    function getAllAddress() {
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

    function getAllPurchasedGoods($purchaseOrderID) {
        $purchasedGoods = array();

        $con = $this->connect2DB();
        $query = "SELECT * FROM PurchaseOrder_Has_Goods WHERE PurchaseOrderID = " . $purchaseOrderID;
        $result = $con->query($query);
        if ($result) {
            while ($line = $result->fetch_object()) {
                $purchasedGoods[] = new PurchasedGoods($line->PurchaseOrderID, $line->GoodsID, $line->Amount, $line->PurchasePrice);
            }
            $con->close();

            return $purchasedGoods;
        } else {
            $con->close();
            return false;
        }
    }

    public function getOpenSC() {
        $db = $this->connect2DB();
        $query = "select 
                	salesorderid,
                        DateTime,
                        cust.title,
                        cust.FirstName,
                        cust.LastName,
                        emp.title,
                        emp.FirstName,
                        emp.LastName,
                        emp.PhoneNumber,
                        emp.Email
                    from salesorder join customer c using (CustomerID)
                                    join Person cust on c.PersonID = cust.PersonID
                                    join employee e using (EmployeeID)
                                    join Person emp on e.PersonID = emp.Personid
                    where status = 'open'
                    order by DateTime";
        $ergebnis = $db->prepare($query);
        $ergebnis->execute();
        $ergebnis->bind_result($salesId, $datetime, $cTitle, $cFname, $cLname, $eTitle, $eFname, $eLname, $phone, $mail);
        if ($ergebnis) {
            echo "<table class='table table-hover'>";
            echo "<thead><tr>";
            echo "<th>SalesId</th>";
            echo "<th>Date/Time</th>";
            echo "<th>Customer</th>";
            echo "<th>Sales Employee</th>";
            echo "<th>Call</th>";
            echo "<th>process</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($ergebnis->fetch()) {
                echo "<tr>";
                echo "<td>$salesId</td>";
                echo "<td>$datetime</td>";
                echo "<td>$cTitle $cFname $cLname</td>";
                echo "<td><a href='mailto:$mail'>$eTitle $eFname $eLname</td>";
                echo "<td><a href='tel:$phone'>$phone</a></td>";
                echo "<td><input type='button' class='btn btn-info' value='Start processing' onclick='processSC($salesId)'></td>";
//                echo "<td><button class='btn btn-success'><a href='ReviewSalesOrder.php?salesid=$salesId'>process</a></button></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        $ergebnis->close();
        $db->close();
    }

    public function getProcessedSC() {
        $db = $this->connect2DB();
        $query = "select 
                	salesorderid,
                        DateTime,
                        cust.title,
                        cust.FirstName,
                        cust.LastName,
                        emp.title,
                        emp.FirstName,
                        emp.LastName,
                        emp.PhoneNumber,
                        emp.Email
                    from salesorder join customer c using (CustomerID)
                                    join Person cust on c.PersonID = cust.PersonID
                                    join employee e using (EmployeeID)
                                    join Person emp on e.PersonID = emp.Personid
                    where status = 'reviewed'
                    order by DateTime desc";
        $ergebnis = $db->prepare($query);
        $ergebnis->execute();
        $ergebnis->bind_result($salesId, $datetime, $cTitle, $cFname, $cLname, $eTitle, $eFname, $eLname, $phone, $mail);
        if ($ergebnis) {
            echo "<table class='table table-hover'>";
            echo "<thead><tr>";
            echo "<th>SalesId</th>";
            echo "<th>Date/Time</th>";
            echo "<th>Customer</th>";
            echo "<th>Sales Employee</th>";
            echo "<th>Call</th>";
            echo "<th>complete</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($ergebnis->fetch()) {
                echo "<tr>";
                echo "<td>$salesId</td>";
                echo "<td>$datetime</td>";
                echo "<td>$cTitle $cFname $cLname</td>";
                echo "<td><a href='mailto:$mail'>$eTitle $eFname $eLname</td>";
                echo "<td><a href='tel:$phone'>$phone</a></td>";
                echo "<td><input type='button' class='btn btn-info' value='Continue processing' onclick='processSC($salesId)'></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        $ergebnis->close();
        $db->close();
    }

    public function processSC($salesorderid) {
        $db = $this->connect2DB();
        $query = "select 
                        name,
                        title,
                        amount,
                        StorageLocation,
                        Unit
                  from salesorder_has_goods join goods using(goodsid)
		  join goodscategory using (categoryid)
                  where salesorderid = ?
                  order by StorageLocation;";
        $ergebnis = $db->prepare($query);
        $ergebnis->bind_param("i", $salesorderid);
        $ergebnis->execute();
        $ergebnis->bind_result($name, $title, $amount, $location, $unit);
        if ($ergebnis) {
            echo "<table class='table table-hover'>";
            echo "<thead><tr>";
            echo "<th>Name</th>";
            echo "<th>Category</th>";
            echo "<th>Amount</th>";
            echo "<th>Unit</th>";
            echo "<th>Storage Location</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($ergebnis->fetch()) {
                echo "<tr>";
                echo "<td>$name</td>";
                echo "<td>$title</td>";
                echo "<td>$amount</td>";
                echo "<td>$unit</td>";
                echo "<td>$location</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        $ergebnis->close();
        $db->close();
    }

    public function getCompletedSC() {
        $db = $this->connect2DB();
        $query = "select 
                	salesorderid,
                        DateTime,
                        cust.title,
                        cust.FirstName,
                        cust.LastName,
                        emp.title,
                        emp.FirstName,
                        emp.LastName,
                        emp.PhoneNumber,
                        emp.Email,
                        outgoingdatetime
                    from salesorder join customer c using (CustomerID)
                                    join Person cust on c.PersonID = cust.PersonID
                                    join employee e using (EmployeeID)
                                    join Person emp on e.PersonID = emp.Personid
                    where status = 'completed'
                    order by outgoingdatetime desc";
        $ergebnis = $db->prepare($query);
        $ergebnis->execute();
        $ergebnis->bind_result($salesId, $datetime, $cTitle, $cFname, $cLname, $eTitle, $eFname, $eLname, $phone, $mail, $outgoingdatetime);
        if ($ergebnis) {
            echo "<table class='table table-hover'>";
            echo "<thead><tr>";
            echo "<th>SalesId</th>";
            echo "<th>Ordered</th>";
            echo "<th>Completed</th>";
            echo "<th>Customer</th>";
            echo "<th>Sales Employee</th>";
            echo "<th>Call</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($ergebnis->fetch()) {
                echo "<tr>";
                echo "<td>$salesId</td>";
                echo "<td>$datetime</td>";
                echo "<td>$outgoingdatetime</td>";
                echo "<td>$cTitle $cFname $cLname</td>";
                echo "<td><a href='mailto:$mail'>$eTitle $eFname $eLname</td>";
                echo "<td><a href='tel:$phone'>$phone</a></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        $ergebnis->close();
        $db->close();
    }

    public function getFinalRemarks($completeThis) {
        $db = $this->connect2DB();
        $query = "select 
                        DateTime,
                        cust.title,
                        cust.FirstName,
                        cust.LastName,
                        emp.title,
                        emp.FirstName,
                        emp.LastName,
                        emp.PhoneNumber,
                        emp.Email,
                        packagingwishes
                    from salesorder join customer c using (CustomerID)
                                    join Person cust on c.PersonID = cust.PersonID
                                    join employee e using (EmployeeID)
                                    join Person emp on e.PersonID = emp.Personid
                    where salesorderid = ?
                    ";
        $ergebnis = $db->prepare($query);
        $ergebnis->bind_param("i", $completeThis);
        $ergebnis->execute();
        $ergebnis->bind_result($datetime, $cTitle, $cFname, $cLname, $eTitle, $eFname, $eLname, $phone, $mail, $wishes);
        if ($ergebnis) {
            echo "<div class='jumbotron'";
            while ($ergebnis->fetch()) {
                echo "<p><b>Salesman: </b>";
                echo "<a href='mailto:$mail'>$eTitle $eFname $eLname</a><br>";
                echo "<b>Phone:</b> <a href='tel:$phone'>$phone</a></p>";
                echo "<p><b>Customer: </b>";
                echo "$cTitle $cFname $cLname</p>";
                echo "<p><b>Packaging wishes:</b><br>$wishes</p>";
            }
            echo "</div>";
        }
        $ergebnis->close();
        $db->close();
    }

    public function markReviewed($completeThis) {
        $db = $this->connect2DB();
        $query = "UPDATE salesorder SET Status='reviewed' WHERE SalesOrderID=?;";
        $ergebnis = $db->prepare($query);
        $ergebnis->bind_param("i", $completeThis);
        $ergebnis->execute();
        if ($ergebnis) {
            $success = true;
        } else {
            $success = false;
        }
        $ergebnis->close();
        $db->close();
        return $success;
    }

    public function completeSalesOrder($salesId) {
        $db = $this->connect2DB();
        
//        $query = "UPDATE `s17-bvz2-fst-20`.`goods` SET `StockAmount`='150' WHERE `GoodsID`='2';";
//        echo $query;
//        $ergebnis = $db->prepare($query);
//        $ergebnis->bind_param("i", $salesId);
//        $ergebnis->execute();
//        if ($ergebnis) {
//            $success = true;
//        } else {
//            $success = false;
//        }
        
        $query = "UPDATE salesorder SET OutgoingDateTime='".date("Y-m-d H:m:s")."', Status='completed' WHERE SalesOrderID=?;";
        echo $query;
        $ergebnis = $db->prepare($query);
        $ergebnis->bind_param("i", $salesId);
        $ergebnis->execute();
        if ($ergebnis) {
            $success = true;
        } else {
            $success = false;
        }
        $ergebnis->close();
        $db->close();
        return $success;
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
    function getAllPurchaseOrder() {
        $purchaseOrder = array();

        $con = $this->connect2DB();
        $query = "SELECT * FROM PurchaseOrder";
        $result = $con->query($query);
        if ($result) {
            while ($line = $result->fetch_object()) {
                $purchaseOrder[] = new PurchaseOrder($line->PurchaseOrderID, $line->SupplierID, $line->EmployeeID, $line->DateTime, $line->Status);
            }
            $con->close();
            return $purchaseOrder;
        } else {
            $con->close();
            return false;
        }
    }

    
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
