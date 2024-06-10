<?php 
include 'database.php';
$id = $_GET['id'];
mysqli_query($conn,"delete from orders where order_id='$id'");
 
// mengalihkan halaman kembali ke index.php
header("location:orders.php");
 
?>