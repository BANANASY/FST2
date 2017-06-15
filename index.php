<?php
require_once 'model/Address.php';
require_once 'config/dbaccess.php';

$db = new DB();
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>Storage</title>
        <link rel="stylesheet"  type="text/css" href="res/css/style.css">
    </head>
    <body>
        <h1>NexX war hier!</h1>
        <div class="container">
            <div class="nav_left">

            </div>
            <div class="container_main">
                <div class="infoboard">

                </div>
                <div class="databoard">
                    <?php
                    $address = $db->getAddress();
                    foreach ($address as $result) {
                        echo '<p>Adresse: ' . $result->getAddress() . '</p>';
                    }
                    ?>


                </div>
            </div>
        </div>
    </body>
</html>
