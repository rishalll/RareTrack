<?php
include '../connection.php';
session_start();

$species_id = $_POST['species_id'];
$log = $_SESSION['id'];

$check = mysqli_query($con, "SELECT * FROM species_likes WHERE species_id='$species_id' AND login_id='$log'");

if(mysqli_num_rows($check) > 0){
    mysqli_query($con, "DELETE FROM species_likes WHERE species_id='$species_id' AND login_id='$log'");
} else {
    mysqli_query($con, "INSERT INTO species_likes(species_id, login_id) VALUES('$species_id', '$log')");
}

$count = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS cnt FROM species_likes WHERE species_id='$species_id'"))['cnt'];

echo $count;
?>
