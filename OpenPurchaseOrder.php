<?php include 'inc/header.php'; ?>



<br>
<br>
<br>
<br>
<br>
<br>
<?php $db = new DB();
$address = $db->getAddress();

echo $address[0]->getCity();
?>

<?php  include 'inc/footer.php';?>