<?php
session_start();
$subject=$_POST['subject'];
$complaint=$_POST['complaint']; 
    

include '../connection.php';
$log=$_SESSION['id'];

$file=$_FILES['file']['name'];
$temp=$_FILES['file']['tmp_name'];
$target_dir = "../uploads/" . basename($file);
move_uploaded_file($temp, $target_dir);

$sql="insert into complaint(subject,complaint,file,contributor_id) values('$subject','$complaint','$file','$log')";
mysqli_query($con,$sql);
echo "<script>alert('Your complaint was Reported Successfully');window.location='index.php'</script>";

?>
