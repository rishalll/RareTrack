<?php
session_start();
include '../connection.php';

// ✅ Ensure researcher is logged in
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Please log in as researcher.'); window.location='../login.php';</script>";
    exit();
}

$researcher_id = $_SESSION['id']; // logged-in researcher
$id = intval($_GET['id']);       // species id

// ✅ 1. Update species status to approved
$update = "UPDATE species SET status='approved' WHERE id='$id'";
if (mysqli_query($con, $update)) {

    // ✅ 2. Insert into rare_species if not already present
    $check = "SELECT * FROM rare_species WHERE species_id='$id'";
    $checkRes = mysqli_query($con, $check);

    if (mysqli_num_rows($checkRes) == 0) {
        $insert = "INSERT INTO rare_species (species_id, researcher_id, approved_date) 
            VALUES ('$id', '$researcher_id', NOW())";
        mysqli_query($con, $insert);
    }

    // ✅ 3. Count approvals by this researcher
    $countQuery = "SELECT COUNT(*) AS total FROM rare_species WHERE researcher_id='$researcher_id'";
    $countRes = mysqli_query($con, $countQuery);
    $row = mysqli_fetch_assoc($countRes);
    $totalApproved = (int)$row['total'];

    // ✅ 4. Researcher milestones
    $milestones = [
        "First Approval" => 1,
        "5 Species Approved" => 5,
        "10 Species Approved" => 10,
        "50 Species Approved" => 50
    ];

    // ✅ 5. Unlock achievements for researcher
    foreach ($milestones as $title => $required) {
        if ($totalApproved >= $required) {
            $check = "SELECT * FROM researcher_achievements 
                      WHERE researcher_id='$researcher_id' AND achievement_type='$title'";
            $res = mysqli_query($con, $check);

            if (mysqli_num_rows($res) == 0) {
                $insertAch = "INSERT INTO researcher_achievements (researcher_id, achievement_type) 
                              VALUES ('$researcher_id', '$title')";
                mysqli_query($con, $insertAch);
            }
        }
    }

    echo "<script>alert('Approval successful. Rare species saved & researcher achievement updated!'); 
          window.location='index.php';</script>";
} else {
    echo "Error approving species: " . mysqli_error($con);
}
?>
