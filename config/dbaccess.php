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
                echo "<td><button class='btn btn-success'><a href='ReviewSalesOrder.php?salesid=$salesId'>process</a></button></td>";
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
                echo "<td><a href='CompleteSalesOrder.php?salesid=$salesId'>complete</td>";
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
                  where salesorderid = ?;";
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
                        emp.Email
                    from salesorder join customer c using (CustomerID)
                                    join Person cust on c.PersonID = cust.PersonID
                                    join employee e using (EmployeeID)
                                    join Person emp on e.PersonID = emp.Personid
                    where status = 'completed'
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
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        $ergebnis->close();
        $db->close();
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
}
