<?php
include '../connection.php';
$id=$_GET['id'];
$str="update species set status='rejected' where id='$id'";
mysqli_query($con,$str);
echo"<script>alert('Rejected succesfully'); window.location='index.php';</script>";
?>