<?php
$name=$_POST['name'];
$email=$_POST['email'];     
$phone=$_POST['phone'];
$address=$_POST['address'];
$username=$_POST['username'];
$password=$_POST['password'];

include '../connection.php';

$str="select * from login where username='$username'";
$result=mysqli_query($con,$str);
if(mysqli_num_rows($result)>0)
{
    echo "<script>alert('Username already exists');window.location='index.php'</script>";
}
else
{
    $query="insert into login(username,password,user_type,user_status) values('$username','$password','researcher','approved')";
    mysqli_query($con,$query);
    $log=mysqli_insert_id($con);
    $sql="insert into researcher(name,email,phone,address,image,certificate,login_id) values('$name','$email','$phone','$address','','','$log')";
    mysqli_query($con,$sql);
    echo "<script>alert('Registration successful');window.location='index.php'</script>";
}
?>
