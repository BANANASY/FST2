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
        $db = $this->connect2DB();
        $query = "SELECT * FROM address";
        $ergebnis = $this->connection->query($query);
        if ($ergebnis) {
            $zeile = $ergebnis->fetch_object();
            echo '<p>'.$zeile->address.'</p>';
        }
        $this->connection->close();
        return true;
    }
}
?>