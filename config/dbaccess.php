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

    function getAllPurchaseOrder(){
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
    function getAllPurchasedGoods($purchaseOrderID){
        $purchasedGoods = array();
        
        $con = $this->connect2DB();
        $query = "SELECT * FROM PurchaseOrder_Has_Goods WHERE PurchaseOrderID = ".$purchaseOrderID;
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
}
