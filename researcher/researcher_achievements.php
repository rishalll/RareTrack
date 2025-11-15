<?php
session_start();
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Please log in first.'); window.location='../login.php';</script>";
    exit();
}

$researcher_id = $_SESSION['id'];
include '../connection.php'; 
include 'header.php';

// ✅ Researcher milestone definitions
$allMilestones = [
    "First Approval" => 1,
    "5 Species Approved" => 5,
    "10 Species Approved" => 10,
    "50 Species Approved" => 50
];

// ✅ Get total approvals by researcher
$countQuery = "SELECT COUNT(*) AS total FROM rare_species WHERE researcher_id = '$researcher_id'";
$countResult = mysqli_query($con, $countQuery);
$row = mysqli_fetch_assoc($countResult);
$totalApprovals = (int)$row['total'];

// ✅ Fetch unlocked achievements
$query = "SELECT achievement_type FROM researcher_achievements WHERE researcher_id = '$researcher_id'";
$result = mysqli_query($con, $query);
$unlocked = [];
while ($r = mysqli_fetch_assoc($result)) {
    $unlocked[] = $r['achievement_type'];
}

// ✅ Fetch species researcher approved
$approvedQuery = "
    SELECT rs.approved_date, s.name, s.type, s.location, s.file 
    FROM rare_species rs
    INNER JOIN species s ON rs.species_id = s.id
    WHERE rs.researcher_id = '$researcher_id'
    ORDER BY rs.approved_date DESC
";
$approvedResult = mysqli_query($con, $approvedQuery);
?>
<br><br><br>
<div class="container mt-5">

    <!-- 🏅 Researcher Achievements & Milestones -->
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card shadow border-0 rounded mb-5">
                <div class="card-header text-white text-center" style="background: linear-gradient(90deg, #2196f3, #03a9f4);">
                    <h3>🎖 My Approval Achievements 🎖</h3>
                    <p class="mb-0">Approve species to unlock rewards ✅</p>
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
                                
                                $progress = min(100, ($totalApprovals / $required) * 100);
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
                                            <div class="progress-bar bg-info" role="progressbar" 
                                                style="width: <?php echo $progress; ?>%;" 
                                                aria-valuenow="<?php echo $progress; ?>" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            <?php echo min($totalApprovals, $required) . "/" . $required; ?> approvals
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

    <!-- 🌿 Approved Species List -->
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card shadow border-0 rounded">
                <div class="card-header text-white text-center" style="background: linear-gradient(90deg, #4caf50, #8bc34a);">
                    <h3>🌿 Species I Approved 🌿</h3>
                    <p class="mb-0">These species were approved as Rare Species by me ✅</p>
                </div>

                <div class="card-body">
                    <?php if (mysqli_num_rows($approvedResult) > 0) { ?>
                        <div class="row">
                            <?php while ($sp = mysqli_fetch_assoc($approvedResult)) { ?>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm border-0 rounded-3 text-center">
                                        <?php if (!empty($sp['file'])) { ?>
                                            <img src="../uploads/<?php echo htmlspecialchars($sp['file']); ?>" class="card-img-top" alt="Species Image" style="height:200px; object-fit:cover;">
                                        <?php } ?>
                                        <div class="card-body">
                                            <h5 class="fw-bold text-success"><?php echo htmlspecialchars($sp['name']); ?></h5>
                                            <p class="text-muted mb-1"><b>Type:</b> <?php echo htmlspecialchars($sp['type']); ?></p>
                                            <p class="text-muted mb-1"><b>Location:</b> <?php echo htmlspecialchars($sp['location']); ?></p>
                                            <small class="text-primary"><b>Approved:</b> <?php echo date("d M Y", strtotime($sp['approved_date'])); ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-info text-center">
                            ❌ You haven’t approved any species yet.
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
    background: linear-gradient(135deg, #ffffff, #e3f2fd);
    color: #0d47a1;
    border: 2px solid #2196f3;
    min-height: 220px;
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(33, 150, 243, 0.4);
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
    background: linear-gradient(90deg, #2196f3, #03a9f4);
}
@keyframes pop {
    0% { transform: scale(0.5); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
</style>

<?php include 'js.php'; ?>
