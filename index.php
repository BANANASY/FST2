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
        <title>DIBWARS</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="./res/css/style.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <h1>NexX war hier!</h1>
        <div class="container">
            <div class="nav_left">

            </div>
            <div class="container_main col-md-8">
                <div class="infoboard">
                </div>
                <div class="databoard">

                </div>
            </div>
        </div>
    </body>
</html>
                    <?php
                    $address = $db->getAddress();
                    foreach ($address as $result) {
                        echo '<p>Adresse: ' . $result->getAddress() . '</p>';
                    }
                    ?>


