<?php
session_start();
include '../connection.php';
$login_id = $_SESSION['id'];

if ($_POST) {
    $name = $_POST['name'];
    $email = $_POST['email'];       
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Image upload
    $image = $_FILES['image']['name'];
    $temp_image = $_FILES['image']['tmp_name'];
    $target_dir_image = "../uploads/" . basename($image);
    move_uploaded_file($temp_image, $target_dir_image);

    // Certificate upload
    $certificate = $_FILES['certificate']['name'];
    $temp_cert = $_FILES['certificate']['tmp_name'];
    $target_dir_cert = "../uploads/" . basename($certificate);
    move_uploaded_file($temp_cert, $target_dir_cert);

    $query = "UPDATE researcher 
              SET name='$name', email='$email', phone='$phone', address='$address', 
                  image='$image', certificate='$certificate' 
              WHERE login_id=$login_id";

    $result = mysqli_query($con, $query);
    if ($result) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile. Please try again.'); window.location.href='edit_profile.php';</script>";
    }
}
?>
