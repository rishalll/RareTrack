<?php
session_start();//temporary variable store
include 'connection.php';

$name = $_POST['username'];
$pass = $_POST['password'];

$str = "SELECT * FROM login WHERE username='$name' AND password='$pass'";
$result = mysqli_query($con, $str);

if ($result) {
    $data = mysqli_fetch_array($result);
    
    if ($data) {
        $_SESSION['id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['user_type'] = $data['user_type'];

        if ($data['user_type'] == 'admin') {
            header("Location: admin/index.php");
        } 
        else if($data['user_type']=="contributor" && $data['user_status']=="approved") {
            header("Location: contributer/index.php");
        } 
        else if($data['user_type']=="researcher" && $data['user_status']=="approved") {
            header ("Location: researcher/index.php");
        }
        else {
            echo "<script>alert('Not approved');window.location='login.php'</script>";
        }
    } else {
        echo "<script>alert('Invalid username or password');window.location='login.php'</script>";
    }
} else {
    echo "<script>alert('Invalid database');window.location='login.php'</script>";
}
?>
