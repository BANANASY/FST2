function getOrdersNew($id)
    {
        require_once("./models/Order.php");

        $query = "SELECT * FROM salesorder WHERE CustomerID = '" . $id . "'";
        $result = mysqli_query($this->con, $query) or die(mysqli_error($this->con));

        $orders = array();
        $cnt = 0;
        while ($row = mysqli_fetch_object($result)) {
            $order = new Order();
            $order->setSalesOrderID($row->SalesOrderID);
            $order->setCustomerID($row->CustomerID);
            $order->setEmployeeID($row->EmployeeID);
            $order->setDate($row->DateTime);
            $order->setPaymentID($row->PaymentID);
            $order->setPackagingWishes($row->PackagingWishes);
            $order->setGoods($this->getGoodsForOrder($row->SalesOrderID));
            $orders[$cnt] = $order;
            $cnt++;
        }
        return $orders;
    }

    function getGoodAmount($goodsID, $orderID){
        $query = "SELECT * FROM salesorder_has_goods WHERE SalesOrderID = '" . $orderID . "' AND GoodsID = '".$goodsID."'";
        $result = mysqli_query($this->con, $query) or die(mysqli_error($this->con));
        while ($row = mysqli_fetch_object($result)) {
            $amount = $row->Amount;
            return $amount;
        }

    }

    function getPaymentType($pid){
        $query = "SELECT * FROM payment WHERE PaymentID = '" . $pid . "'";
        $result = mysqli_query($this->con, $query) or die(mysqli_error($this->con));
        while ($row = mysqli_fetch_object($result)) {
            $type = $row->Type;
            return $type;
        }
    }

    function getPaymentNumber($pid){
        $query = "SELECT * FROM payment WHERE PaymentID = '" . $pid . "'";
        $result = mysqli_query($this->con, $query) or die(mysqli_error($this->con));
        while ($row = mysqli_fetch_object($result)) {
            $number = $row->Number;
            return $number;
        }
    }

    function getOrderInvoice($id)
    {

        $query = "SELECT * FROM salesorder WHERE SalesOrderID = '" . $id . "'";
        $result = mysqli_query($this->con, $query) or die(mysqli_error($this->con));

        $order = new Order();
        while ($row = mysqli_fetch_object($result)) {
            $order->setSalesOrderID($row->SalesOrderID);
            $order->setCustomerID($row->CustomerID);
            $order->setEmployeeID($row->EmployeeID);
            $order->setPaymentID($row->PaymentID);
            $order->setDate($row->DateTime);
            $order->setPackagingWishes($row->PackagingWishes);
            $order->setGoods($this->getGoodsForOrderInvoice($row->SalesOrderID));

        }
        return $order;
    }

    private function getGoodsForOrderInvoice($id)
    {

        $query = "SELECT GoodsID 
                  FROM `salesorder_has_goods` 
                  WHERE `SalesOrderID` = '" . $id . "' ";

        $result = mysqli_query($this->con, $query) or die(mysqli_error($this->con));

        $goods = array();
        while ($row = mysqli_fetch_object($result)) {
            array_push($goods, $this->getProductInvoice($row->GoodsID));
        }
        return $goods;
    }

    function getProductInvoice($id)
    {
        $query = "SELECT 	
                    g.GoodsID as goodID, g.Name as goodName, g.Description, g.Manufacturer, g.CurrentNetSalesPrice, g.StorageLocation, g.Unit,
                    g.MinAmount, g.StockAmount, g.Active, g.IsOrdered, goodscategory.Title AS gcTitle, taxes.Name as taxesName, taxes.Percent as taxesPercent
                  FROM 
                    goods g  JOIN goodscategory Using(CategoryID) JOIN taxes USING(TaxID) WHERE g.GoodsID = '" . $id . "' LIMIT 1";

        $result = mysqli_query($this->con, $query) or die(mysqli_error($this->con));

        $good = new Good();
        while ($row = mysqli_fetch_object($result)) {
            $good->setGoodsID($row->goodID);
            $good->setDescription($row->Description);
            $good->setCategory($row->gcTitle);
            $good->setTax($row->taxesPercent);
            $good->setCategory($row->gcTitle);
            $good->setManufacturer($row->Manufacturer);
            $good->setName($row->goodName);
            $good->setCurrentNetSalesPrice($row->CurrentNetSalesPrice);
            $good->setActive($row->Active);
            $good->setStockAmount($row->StockAmount);
            $good->setMinAmount($row->MinAmount);
            $good->setUnit($row->Unit);
            $good->setIsOrdered($row->IsOrdered);
            $good->setSotrageLocation($row->StorageLocation);
        }
        return $good;
    }

    function getPerson($id)
    {
        require_once("../models/Person.php");

        $query = "SELECT * 
                  FROM `person`
                  JOIN `address` USING(`AddressID`)
                  WHERE PersonID = '" . $id . "'";

        $result = mysqli_query($this->con, $query) or die(mysqli_error($this->con));

        $person = new Person();
        while ($row = mysqli_fetch_object($result)) {
            $person->setAddressID($row->AddressID);
            $person->setIsActive($row->IsActive);
            $person->setPersonID($row->PersonID);
            $person->setEmail($row->Email);
            $person->setAddress($row->Address);
            $person->setBirthday($row->Birthday);
            $person->setCity($row->City);
            $person->setCountry($row->Country);
            $person->setFirstName($row->FirstName);
            $person->setLastName($row->LastName);
            $person->setPersonID($row->PersonID);
            $person->setPhoneNumber($row->PhoneNumber);
            $person->setTitle($row->Title);
            $person->setZIP($row->ZIP);
            $person->setCountry($row->Country);
            $person->setRole($row->RoleID);

        }
        return $person;
    }