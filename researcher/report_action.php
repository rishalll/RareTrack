<?php
session_start();
$comment=$_POST['comment'];
$species_id=$_POST['species_id'];
$log=$_SESSION['id'];
include '../connection.php';
$sql="insert into report(species_id,researcher_id,comment) values('$species_id','$log','$comment')";
mysqli_query($con,$sql);
echo "<script>alert('Report submitted successfully');window.location='verifyspecies.php'</script>";
?>

