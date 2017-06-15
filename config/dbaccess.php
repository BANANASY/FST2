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
}
