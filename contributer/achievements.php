<?php
session_start();
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Please log in first.'); window.location='../login.php';</script>";
    exit();
}

$login_id = $_SESSION['id'];
include '../connection.php'; 
include 'header.php';

// ✅ Milestone Definitions
$allMilestones = [
    "First Species Uploaded" => 1,
    "5 Species Uploaded" => 5,
    "10 Species Uploaded" => 10,
    "50 Species Uploaded" => 50
];

// ✅ Get total uploads
$countQuery = "SELECT COUNT(*) AS total FROM species WHERE login_id = '$login_id'";
$countResult = mysqli_query($con, $countQuery);
$row = mysqli_fetch_assoc($countResult);
$totalUploads = (int)$row['total'];

// ✅ Fetch unlocked achievements
$query = "SELECT achievement_type FROM achievements WHERE login_id = '$login_id'";
$result = mysqli_query($con, $query);
$unlocked = [];
while ($r = mysqli_fetch_assoc($result)) {
    $unlocked[] = $r['achievement_type'];
}

// ✅ Fetch contributor’s rare species
$rareQuery = "
    SELECT rs.approved_date, s.name, s.type, s.location, s.file 
    FROM rare_species rs
    INNER JOIN species s ON rs.species_id = s.id
    WHERE s.login_id = '$login_id'
    ORDER BY rs.approved_date DESC
";
$rareResult = mysqli_query($con, $rareQuery);
?>
<br><br><br>
<div class="container mt-5">

    <!-- 🏅 Achievements & Milestones -->
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card shadow border-0 rounded mb-5">
                <div class="card-header text-white text-center" style="background: linear-gradient(90deg, #ff9800, #ffc107);">
                    <h3>🎖 My Achievements & Milestones 🎖</h3>
                    <p class="mb-0">Upload species to unlock rewards 🎖</p>
                </div>

                <div class="card-body text-center">
                    <div class="row">
                        <?php foreach ($allMilestones as $milestone => $required): ?>
                            <?php 
                                $isUnlocked = in_array($milestone, $unlocked);
                                $icon = "🔒"; 
                                $cardClass = "locked-card";

                                if ($isUnlocked) {
                                    if (strpos($milestone, 'First') !== false) $icon = "🥇";
                                    elseif (strpos($milestone, '5') !== false) $icon = "🥈";
                                    elseif (strpos($milestone, '10') !== false) $icon = "🥉";
                                    elseif (strpos($milestone, '50') !== false) $icon = "👑";
                                    else $icon = "🏆";
                                    $cardClass = "unlocked-card";
                                }
                                
                                $progress = min(100, ($totalUploads / $required) * 100);
                            ?>
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="reward-card <?php echo $cardClass; ?>">
                                    <div class="reward-icon"><?php echo $icon; ?></div>
                                    <h6 class="mt-2 fw-bold"><?php echo htmlspecialchars($milestone); ?></h6>

                                    <?php if ($isUnlocked): ?>
                                        <span class="badge bg-success">Unlocked</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Locked</span>
                                        <div class="progress mt-3">
                                            <div class="progress-bar bg-warning" role="progressbar" 
                                                style="width: <?php echo $progress; ?>%;" 
                                                aria-valuenow="<?php echo $progress; ?>" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            <?php echo min($totalUploads, $required) . "/" . $required; ?> uploads
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- 🌿 Rare Species Achievements -->
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card shadow border-0 rounded">
                <div class="card-header text-white text-center" style="background: linear-gradient(90deg, #4caf50, #8bc34a);">
                    <h3>🌿 My Rare Species Achievements 🌿</h3>
                    <p class="mb-0">These species have been approved as Rare Species ✅</p>
                </div>

                <div class="card-body">
                    <?php if (mysqli_num_rows($rareResult) > 0) { ?>
                        <div class="row">
                            <?php while ($rare = mysqli_fetch_assoc($rareResult)) { ?>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm border-0 rounded-3 text-center">
                                        <?php if (!empty($rare['file'])) { ?>
                                            <img src="../uploads/<?php echo htmlspecialchars($rare['file']); ?>" class="card-img-top" alt="Species Image" style="height:200px; object-fit:cover;">
                                        <?php } ?>
                                        <div class="card-body">
                                            <h5 class="fw-bold text-success"><?php echo htmlspecialchars($rare['name']); ?></h5>
                                            <p class="text-muted mb-1"><b>Type:</b> <?php echo htmlspecialchars($rare['type']); ?></p>
                                            <p class="text-muted mb-1"><b>Location:</b> <?php echo htmlspecialchars($rare['location']); ?></p>
                                            <small class="text-primary"><b>Approved:</b> <?php echo date("d M Y", strtotime($rare['approved_date'])); ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-info text-center">
                            ❌ You don’t have any rare species approved yet. Keep contributing!
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>

</div>

<style>
.reward-card {
    border-radius: 20px;
    padding: 25px;
    transition: transform 0.3s, box-shadow 0.3s;
    text-align: center;
    min-height: 180px;
}
.reward-card:hover {
    transform: translateY(-8px) scale(1.05);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}
.unlocked-card {
    background: linear-gradient(135deg, #ffffff, #d4edda);
    color: #155724;
    border: 2px solid #28a745;
    min-height: 220px;
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(40, 167, 69, 0.4);
}
.locked-card {
    background: #f4f4f4;
    color: #777;
    border: 2px dashed #ccc;
    opacity: 0.9;
    min-height: 180px;
}
.reward-icon {
    font-size: 3rem;
    display: block;
    margin-bottom: 10px;
    animation: pop 0.6s ease;
}
.badge {
    font-size: 0.8rem;
    padding: 6px 12px;
    border-radius: 12px;
}
.progress {
    height: 8px;
    border-radius: 5px;
    margin-top: 8px;
    background: #e9ecef;
}
.progress-bar {
    background: linear-gradient(90deg, #ffc107, #ff9800);
}
@keyframes pop {
    0% { transform: scale(0.5); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
</style>

<?php include 'js.php'; ?>
