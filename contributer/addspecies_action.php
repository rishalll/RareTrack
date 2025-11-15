<?php
session_start();
include '../connection.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Please log in first.'); window.location='../login.php';</script>";
    exit();
}

$log = $_SESSION['id'];

// Validate and sanitize input fields
$name = mysqli_real_escape_string($con, $_POST['name']);
$type = mysqli_real_escape_string($con, $_POST['type']);
$location = mysqli_real_escape_string($con, $_POST['location']);
$description = mysqli_real_escape_string($con, $_POST['description']);

// Handle file upload
$file = $_FILES['file']['name'];
$temp = $_FILES['file']['tmp_name'];
$uploadPath = "../uploads/" . basename($file);

// Initialize message collector
$alertMessages = "";

if (move_uploaded_file($temp, $uploadPath)) {
    // Insert species into database
    $sql = "INSERT INTO species (name, type, location, description, file, real_name, details, login_id, status)
            VALUES ('$name', '$type', '$location', '$description', '$file', '', '', '$log', 'pending')";
    if (!mysqli_query($con, $sql)) {
        die("Species insert failed: " . mysqli_error($con));
    }

    // Count total uploads by this user
    $countQuery = "SELECT COUNT(*) AS total FROM species WHERE login_id = '$log'";
    $result = mysqli_query($con, $countQuery);
    if (!$result) {
        die("Upload count query failed: " . mysqli_error($con));
    }

    $row = mysqli_fetch_assoc($result);
    $totalUploads = (int)$row['total'];

    $alertMessages .= "Total uploads: $totalUploads\n";

    // Achievement awarding function (add messages to $alertMessages)
    function awardAchievement($con, $log, $type, &$alertMessages) {
        $alertMessages .= "Checking for achievement: $type\n";

        $check = "SELECT * FROM achievements WHERE login_id = '$log' AND achievement_type = '$type'";
        $res = mysqli_query($con, $check);
        if (!$res) {
            die("Achievement SELECT failed: " . mysqli_error($con));
        }

        if (mysqli_num_rows($res) == 0) {
            //$alertMessages .= "Not yet awarded. Attempting to insert achievement: $type\n";
            $insert = "INSERT INTO achievements (login_id, achievement_type) VALUES ('$log', '$type')";
            if (!mysqli_query($con, $insert)) {
                die("Achievement INSERT failed: " . mysqli_error($con));
            } else {
                $alertMessages .= "Achievement \"$type\" awarded successfully!\n";
            }
        } else {
            $alertMessages .= "Achievement \"$type\" already exists.\n";
        }
    }

    // Check and award achievements
    if ($totalUploads == 1) {
        awardAchievement($con, $log, 'First Species Uploaded', $alertMessages);
    } elseif ($totalUploads == 5) {
        awardAchievement($con, $log, '5 Species Uploaded', $alertMessages);
    } elseif ($totalUploads == 10) {
        awardAchievement($con, $log, '10 Species Uploaded', $alertMessages);
    } elseif ($totalUploads == 50) {
        awardAchievement($con, $log, '50 Species Uploaded', $alertMessages);
    }

    // Prepare messages for JavaScript alert
    $jsAlertMessages = addslashes($alertMessages);
    $jsAlertMessages = str_replace("\n", "\\n", $jsAlertMessages);

    // Output one alert with all messages + redirect
    echo "<script>
            alert('$jsAlertMessages');
            window.location = 'index.php';
          </script>";
    exit();

} else {
    echo "<script>alert('File upload failed. Please try again.'); window.location='upload_species.php';</script>";
    exit();
}
?>
