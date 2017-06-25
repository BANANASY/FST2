<?php
require_once 'model/Goods.class.php';
require_once 'model/Address.class.php';
require_once 'model/PurchaseOrder.class.php';
require_once 'model/PurchasedGoods.class.php';
require_once 'model/DeliveryInfo.class.php';
require_once 'model/Employee.class.php';
require_once 'model/DeliveredGoods.class.php';
require_once 'model/PlainGood.class.php';

require_once 'config/dbaccess.php';

$db = new DB();

function consolePrint($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(', ', $output); //wenn array dann mach einen string daraus und zwischen jedem wert klebe ("$glue") einen beistrich hinein

    echo "<script>console.log( 'TestData: " . $output . "' );</script>";
}

function alertPrint($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(', ', $output);

    echo "<script>alert('" . $output . "');</script>";
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">


        <title>Storage</title>

        <!-- Bootstrap core CSS -->
        <!--<link href="../../dist/css/bootstrap.min.css" rel="stylesheet"> -->
        <!-- Bootstrap theme -->
        <!-- <link href="../../dist/css/bootstrap-theme.min.css" rel="stylesheet"> -->
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <!--<link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">-->

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


        <script src="res/js/script.js"></script>


        <link rel="stylesheet" type="text/css" href="res/css/style.css">





        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>



    <body>

        <header>
            <!-- Fixed navbar -->
            <?php include 'navigation_bar.php'; ?>      
        </header>

        <main>
