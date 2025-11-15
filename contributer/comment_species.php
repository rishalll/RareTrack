<?php
include '../connection.php';
session_start();

$species_id = $_POST['species_id'];
$comment = mysqli_real_escape_string($con, $_POST['comment']);
$log = $_SESSION['id'];

mysqli_query($con, "INSERT INTO species_comments(species_id, comment, login_id) 
                    VALUES('$species_id', '$comment', '$log')");

echo htmlspecialchars($comment);
?>
