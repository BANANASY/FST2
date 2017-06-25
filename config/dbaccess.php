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

    function getOnePurchaseOrder($purchaseOrderID) {
        $con = $this->connect2DB();
        $query = "SELECT * FROM PurchaseOrder WHERE PurchaseOrderID = " . $purchaseOrderID;
        $result = $con->query($query);
        if ($result) {
            $line = $result->fetch_object();
            $purchaseOrder = new PurchaseOrder($line->PurchaseOrderID, $line->SupplierID, $line->EmployeeID, $line->DateTime, $line->Status);
            $con->close();
            return $purchaseOrder;
        } else {
            $con->close();
            return false;
        }
    }

    function getAllEmployees() {
        $employee = array();

        $con = $this->connect2DB();
        $query = "SELECT * FROM Employee JOIN Person using(PersonID)";
        $result = $con->query($query);
        if ($result) {
            while ($line = $result->fetch_object()) {
                $employee[] = new Employee($line->EmployeeID, $line->PersonID, $line->DepartmentID, $line->EntryDate, $line->TerminationDate, $line->SocialSecurityNumber, $line->FirstName, $line->LastName);
            }
            $con->close();
            return $employee;
        } else {
            $con->close();
            return false;
        }
    }

    function insertDeliveryInfo($deliveryInfo) {
        $con = $this->connect2DB();
        $statement = $con->prepare("INSERT INTO `deliveryinfo` (`DeliveryInfoID`, `EmployeeID`, `SupplierID`, `PurchaseOrderID`, `DeliverySlipScanID`, `IncomeDateTime`, `DeliveryInformation`) VALUES (null, ?, ?, ?, ?, ?, ?);");

        $EmployeeID = $deliveryInfo->getEmployeeID();
        $SupplierID = $deliveryInfo->getSupplierID();
        $PurchaseOrderID = $deliveryInfo->getPurchaseOrderID();
        $DeliverySlipScanID = $deliveryInfo->getDeliverySlipScanID();
        $IncomeDateTime = $deliveryInfo->getIncomeDateTime();
        $DeliveryInformation = $deliveryInfo->getDeliveryInformation();

        $statement->bind_param("iiisss", $EmployeeID, $SupplierID, $PurchaseOrderID, $DeliverySlipScanID, $IncomeDateTime, $DeliveryInformation);
        $result = $statement->execute();
        if ($result) {
            $last_id = $statement->insert_id;
            $con->close();
            return $last_id; //wenn das inserten geklappt hat dann gib die ID des neuen Eintrages zurück
        } else {
            $con->close();
            return false;
        }
    }

    function insertOneDeliveredGood($deliveredGood) {
        $con = $this->connect2DB();
        $statement = $con->prepare("INSERT INTO `delivery_has_goods` (`DeliveryInfoID`, `GoodsID`, `Amount`, `QualityIsOK`) VALUES (?, ?, ?, ?);");

        $DeliveryInfoID = $deliveredGood->getDeliveryInfoID();
        $GoodsID = $deliveredGood->getGoodsID();
        $Amount = $deliveredGood->getAmount();
        $QualityIsOK = $deliveredGood->getQualityIsOK();

        $statement->bind_param("iiii", $DeliveryInfoID, $GoodsID, $Amount, $QualityIsOK);
        $result = $statement->execute();
        if ($result) {
            $con->close();
            return true;
        } else {
            $con->close();
            return false;
        }
    }

    function updatePurchaseOrderStatus($PurchaseOrderID, $Status) {
        $con = $this->connect2DB();
        $statement = $con->prepare("UPDATE PurchaseOrder SET Status = ? WHERE PurchaseOrderID = ?");
        $statement->bind_param("si", $Status, $PurchaseOrderID);
        $result = $statement->execute();

        if ($result) {
            $this->connection->close();
            return true;
        } else {
            $this->connection->close();
            return false;
        }
    }

    function getDeliveryInfoByPurchaseOrderID($PurchaseOrderID) {
        $con = $this->connect2DB();
        $query = "SELECT * FROM DeliveryInfo WHERE PurchaseOrderID = " . $PurchaseOrderID;
        $result = $con->query($query);
        if ($result) {
            $line = $result->fetch_object();
            $deliverInfo = new DeliveryInfo($line->DeliveryInfoID, $line->EmployeeID, $line->SupplierID, $line->PurchaseOrderID, $line->DeliverySlipScanID, $line->IncomeDateTime, $line->DeliveryInformation);
            $con->close();
            return $deliverInfo;
        } else {
            $con->close();
            return false;
        }
    }

    function getDeliveryInfo($DeliveryInfoID) {
        $con = $this->connect2DB();
        $query = "SELECT * FROM DeliveryInfo WHERE DeliveryInfoID = " . $DeliveryInfoID;
        $result = $con->query($query);
        if ($result) {
            $line = $result->fetch_object();
            $deliverInfo = new DeliveryInfo($line->DeliveryInfoID, $line->EmployeeID, $line->SupplierID, $line->PurchaseOrderID, $line->DeliverySlipScanID, $line->IncomeDateTime, $line->DeliveryInformation);
            $con->close();
            return $deliverInfo;
        } else {
            $con->close();
            return false;
        }
    }

    function getAllDeliveredGoods($DeliveryInfoID) {
        $deliveredGoods = array();

        $con = $this->connect2DB();
        $query = "SELECT * FROM Delivery_Has_Goods WHERE DeliveryInfoID = " . $DeliveryInfoID;
        $result = $con->query($query);
        if ($result) {
            while ($line = $result->fetch_object()) {
                $deliveredGoods[] = new DeliveredGoods($line->DeliveryInfoID, $line->GoodsID, $line->Amount, $line->QualityIsOK);
            }
            $con->close();

            return $deliveredGoods;
        } else {
            $con->close();
            return false;
        }
    }

    function getOneGood($goodID) {
        $con = $this->connect2DB();
        $query = "SELECT * FROM Goods WHERE GoodsID = " . $goodID;
        $result = $con->query($query);
        if ($result) {
            $line = $result->fetch_object();
            $good = new PlainGood($line->GoodsID, $line->CategoryID, $line->TaxID, $line->Name, $line->Description, $line->Manufacturer, $line->CurrentNetSalesPrice, $line->StorageLocation, $line->Unit, $line->MinAmount, $line->StockAmount, $line->Active, $line->IsOrdered);
            $con->close();
            return $good;
        } else {
            $con->close();
            return false;
        }
    }

    function updateStorageLocation($GoodsID, $storageLocation) {
        $con = $this->connect2DB();
        $statement = $con->prepare("UPDATE Goods SET StorageLocation = ? WHERE GoodsID = ?");
        $statement->bind_param("si", $storageLocation, $GoodsID);
        $result = $statement->execute();

        if ($result) {
            $this->connection->close();
            return true;
        } else {
            $this->connection->close();
            return false;
        }
    }

    function updateStockAmount($GoodsID, $add) {
        $con = $this->connect2DB();

        $query = "SELECT * FROM Goods WHERE GoodsID = " . $GoodsID;
        $result = $con->query($query);
        if ($result) {
            $line = $result->fetch_object();
            $oldStockAmount = $line->StockAmount;
            $newStockAmount = $oldStockAmount + $add;

            $statement = $con->prepare("UPDATE Goods SET StockAmount = ? WHERE GoodsID = ?");
            $statement->bind_param("ii", $newStockAmount, $GoodsID);
            $result = $statement->execute();

            if ($result) {
                $con->close();
                return true;
            } else {
                $con->close();
                return false;
            }
        }
        return false;
    }

//-------------------------------------Beautiful Short 'n Awesome ObjectOriented Database Functions Stop Here Line-------------------------------------------



    public function getOpenSC() {
        $db = $this->connect2DB();
        $query = "select 
                	salesorderid,
                        DateTime,
                        cust.title,
                        cust.FirstName,
                        cust.LastName
                    from salesorder join customer c using (CustomerID)
                                    join Person cust on c.PersonID = cust.PersonID
                    where status = 'open'
                    order by DateTime";
        $ergebnis = $db->prepare($query);
        $ergebnis->execute();
        $ergebnis->bind_result($salesId, $datetime, $cTitle, $cFname, $cLname);
        if ($ergebnis) {
            echo "<table class='table table-hover'>";
            echo "<thead><tr>";
            echo "<th>salesId</th>";
            echo "<th>date/time</th>";
            echo "<th>customer</th>";
            echo "<th>goods</th>";
            echo "<th>process</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($ergebnis->fetch()) {
                $so = new salesOrder($salesId);
                echo "<tr>";
                echo "<td>$salesId</td>";
                echo "<td>$datetime</td>";
                echo "<td>$cTitle $cFname $cLname</td>";
                echo "<td>" . $so->getGoodsCount() . "</td>";
                if ($so->isReadyForShipping()) {
                    echo "<td><input type='button' class='btn btn-success' value='Start processing' onclick='processSC($salesId)'></td>";
                } else {
                    echo "<td><input type='button' class='btn btn-danger' value='Not enough stock' onclick='processSC($salesId)'></td>";
                }
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
                        cust.LastName
                    from salesorder join customer c using (CustomerID)
                                    join Person cust on c.PersonID = cust.PersonID
                    where status = 'reviewed'
                    order by DateTime desc";
        $ergebnis = $db->prepare($query);
        $ergebnis->execute();
        $ergebnis->bind_result($salesId, $datetime, $cTitle, $cFname, $cLname);
        if ($ergebnis) {
            echo "<table class='table table-hover'>";
            echo "<thead><tr>";
            echo "<th>salesId</th>";
            echo "<th>date/Time</th>";
            echo "<th>customer</th>";
            echo "<th>goods</th>";
            echo "<th>complete</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($ergebnis->fetch()) {
                $so = new salesOrder($salesId);
                echo "<tr>";
                echo "<td>$salesId</td>";
                echo "<td>$datetime</td>";
                echo "<td>$cTitle $cFname $cLname</td>";
                echo "<td>" . $so->getGoodsCount() . "</td>";
                if ($so->isReadyForShipping()) {
                    echo "<td><input type='button' class='btn btn-success' value='Continue processing' onclick='processSC($salesId)'></td>";
                } else {
                    echo "<td><input type='button' class='btn btn-danger' value='Not enough stock' onclick='processSC($salesId)'></td>";
                }

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
                        manufacturer,
                        amount,
                        StockAmount,
                        StorageLocation,
                        Unit,
                        isOrdered
                  from salesorder_has_goods join goods using(goodsid)
		  join goodscategory using (categoryid)
                  where salesorderid = ?
                  order by StorageLocation;";
        $ergebnis = $db->prepare($query);
        $ergebnis->bind_param("i", $salesorderid);
        $ergebnis->execute();
        $ergebnis->bind_result($name, $manufacturer, $amount, $stockAmount, $location, $unit, $isOrdered);
        if ($ergebnis) {
            echo "<table class='table table-hover'>";
            echo "<thead><tr>";
            echo "<th>name</th>";
            echo "<th>manufacturer</th>";
            echo "<th>ordered</th>";
            echo "<th>stock</th>";
            echo "<th>Unit</th>";
            echo "<th>location</th>";
            echo "<th>purchase</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($ergebnis->fetch()) {
                $isOut = $stockAmount - $amount < 0;
                if ($isOut && !$isOrdered) {
                    echo "<tr class='danger'>";
                } elseif ($isOut && $isOrdered) {
                    echo "<tr class='warning'>";
                } else {
                    echo "<tr>";
                }
                echo "<td>$name</td>";
                echo "<td>$manufacturer</td>";
                echo "<td>$amount</td>";
                echo "<td>$stockAmount</td>";
                echo "<td>$unit</td>";
                echo "<td>$location</td>";
                if ($isOrdered) {
                    echo "<td><img src='img/onTheWay.gif' height='30'></td>";
                } else {
                    echo "<td>---</td>";
                }
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
                        outgoingdatetime
                    from salesorder join customer c using (CustomerID)
                                    join Person cust on c.PersonID = cust.PersonID
                    where status = 'completed'
                    order by outgoingdatetime desc";
        $ergebnis = $db->prepare($query);
        $ergebnis->execute();
        $ergebnis->bind_result($salesId, $datetime, $cTitle, $cFname, $cLname, $outgoingdatetime);
        if ($ergebnis) {

            while ($ergebnis->fetch()) {
                $so = new salesOrder($salesId);
                $goodsCnt = $so->getGoodsCount();
                echo "<tr data-toggle='collapse' data-target='.s$salesId' class='clickable info'>";
                echo " <td>$salesId</td>";
                echo " <td>$datetime</td>";
                echo " <td>$outgoingdatetime</td>";
                echo " <td>$cTitle $cFname $cLname</td>";
                echo " <td>$goodsCnt</td>";
                echo "</tr>";
                $so->printGoods();
            }
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
                    packagingwishes,
                    Address,
                    ZIP,
                    City,
                    Country
                    from salesorder join customer c using (CustomerID)
                                    join Person cust on c.PersonID = cust.PersonID
                                    join address using(AddressID)
								
                    where salesorderid = ?";
        $ergebnis = $db->prepare($query);
        $ergebnis->bind_param("i", $completeThis);
        $ergebnis->execute();
        $ergebnis->bind_result($datetime, $cTitle, $cFname, $cLname, $wishes, $address, $zip, $city, $country);
        if ($ergebnis) {

            while ($ergebnis->fetch()) {
                echo "<p>";
                echo "<b>$cTitle $cFname $cLname </b></p>";
                echo "<p>$address<br>$zip $city<br>$country</p>";
                echo "<p><b>Packaging request:</b><br>$wishes</p>";
            }
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

        $query = "UPDATE salesorder SET OutgoingDateTime='" . date("Y-m-d H:m:s") . "', Status='completed' WHERE SalesOrderID=?;";
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

    function printGoodsList() {
        $conn = $this->connect2DB();

        $stmt = "SELECT GoodsID, Name, StockAmount, MinAmount FROM goods WHERE active = 1 ORDER BY GoodsID;";

        if ($ergebnis = $conn->prepare($stmt)) {
            if ($ergebnis->execute()) {
                $ergebnis->bind_result($id, $name, $stockAmount, $minamount);
                if ($ergebnis) {
                    while ($ergebnis->fetch()) {
                        echo "<tr class='goodCage'>";
                        echo "<td class='goodsoverview-td good_id goodsoverview-minify'>" . $id . "</td>";
                        echo "<td class='goodsoverview-td good_description'>" . $name . "</td>";
                        echo "<td class='goodsoverview-td goodsoverview-minify'>" . $minamount . "</td>";
                        echo "<td class='goodsoverview-td goodsoverview-minify'>" . $stockAmount . "</td>";
                        echo "</tr>";
                    }
                }
            }
        }
    }

    function getGoodById($id) {
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
                    LEFT JOIN goodscategory gc USING (categoryid)
                    LEFT JOIN supplier_has_goods USING (goodsid)
                    LEFT JOIN taxes t USING (taxid)
                    LEFT JOIN supplier s USING (supplierid)
                    WHERE goodsid = ?";
        if ($ergebnis = $conn->prepare($stmt)) {
            $ergebnis->bind_param("i", $id);
            if ($ergebnis->execute()) {
                $ergebnis->bind_result($goodsid, $category, $name, $manufacturer, $price, $storagelocation, $unit, $minamount, $stockamount, $supplier, $taxname, $taxpercent);
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
    function printOutgoingMovementById($id, $asc) {
        $conn = $this->connection;
        $stmt;

        if ($asc) {
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
        } else {
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
                $ergebnis->bind_result($purchaseorderid, $orderamount, $deliveryamount, $orderdate, $deliverydate);
                if ($ergebnis) {
                    while ($ergebnis->fetch()) {
                        echo "<tr class='goods-entries'>";
                        echo "<td data-field-type='number'>" . $purchaseorderid . "</td>";
                        echo "<td data-field-type='number'>" . $orderamount . "</td>";
                        echo "<td data-field-type='number'>" . $deliveryamount . "</td>";
                        echo "<td data-field-type='date'>" . $orderdate . "</td>";
                        echo "<td data-field-type='date' class='goods-inc-deliverydate'>" . $deliverydate . "</td>";
                        echo "<tr>";
                    }
                }
            }
        }
    }

//IS ACTUALLY OUTGOING, BUT TOO LAZY TO CORRECT
    function printIncomingMovementById($id, $asc) {
        $conn = $this->connection;
        $stmt;

        if ($asc) {
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
        } else {
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
                $ergebnis->bind_result($salesorderid, $deliveryamount, $orderdate, $deliverydate);
                if ($ergebnis) {
                    while ($ergebnis->fetch()) {
                        echo "<tr class='goods-entries'>";
                        echo "<td data-field-type='number'>" . $salesorderid . "</td>";
                        echo "<td data-field-type='number'>" . $deliveryamount . "</td>";
                        echo "<td data-field-type='date'>" . $orderdate . "</td>";
                        echo "<td data-field-type='date' class='goods-out-deliverydate'>" . $deliverydate . "</td>";
                        echo "<tr>";
                    }
                }
            }
        }
    }

    public function getGoods($salesId) {
        $db = $this->connect2DB();
        $goods = [];
        $query = "SELECT goodsid, name, manufacturer, storageLocation, unit, minAmount, StockAmount, Isordered, amount FROM goods join salesorder_has_goods using(goodsid) where SalesOrderID= ?;";
        $ergebnis = $db->prepare($query);
        $ergebnis->bind_param("i", $salesId);
        $ergebnis->execute();
        if ($ergebnis->bind_result($goodsID, $name, $manufacturer, $storageLocation, $unit, $minAmount, $stockAmount, $isOrdered, $orderedAmount)) {
            while ($ergebnis->fetch()) {
                array_push($goods, new GoodsLight($goodsID, $name, $manufacturer, $storageLocation, $unit, $minAmount, $stockAmount, $isOrdered, $orderedAmount));
            }
            $db->close();
//            var_dump($goods);
            return $goods;
        }
    }

    public function setNewStock($amount, $goodsid) {
        $db = $this->connect2DB();
        $success = false;
        $query = "UPDATE goods SET StockAmount=? WHERE GoodsID=?;";
        $ergebnis = $db->prepare($query);
        $ergebnis->bind_param("ii", $amount, $goodsid);
        $ergebnis->execute();
        if ($ergebnis) {
            $success = true;
        }
        $db->close();
        return $success;
    }

}
