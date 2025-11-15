<?php
session_start();
include 'header.php';
include '../connection.php';

/* 
 * Helper function: run a COUNT(*) query safely
 * - $con  = database connection
 * - $sql  = the SQL query
 * Returns integer (0 if query fails).
 */
function count_query($con, $sql) {
  $res = mysqli_query($con, $sql);
  if (!$res) { 
    return 0; 
  }
  $row = mysqli_fetch_assoc($res);
  return isset($row['c']) ? (int)$row['c'] : 0;
}

/* ----------------------------------------------------------------
   Step 1: Check if complaint/feedback tables have `created_at` column
   (So we know if we can filter by "last 7 days")
----------------------------------------------------------------- */
$has_complaints_ts = false;
$has_feedbacks_ts  = false;

$chk1 = mysqli_query($con, "SHOW COLUMNS FROM complaint LIKE 'created_at'");
if ($chk1 && mysqli_num_rows($chk1) > 0) { 
  $has_complaints_ts = true; 
}

$chk2 = mysqli_query($con, "SHOW COLUMNS FROM feedback LIKE 'created_at'");
if ($chk2 && mysqli_num_rows($chk2) > 0) { 
  $has_feedbacks_ts = true; 
}

/* ----------------------------------------------------------------
   Step 2: Collect KPI (Key Performance Indicators) numbers
----------------------------------------------------------------- */

// Pending species count
$pending_species = count_query(
  $con, 
  "SELECT COUNT(*) AS c FROM species WHERE status='pending'"
);

// Pending users count
$pending_users = count_query(
  $con, 
  "SELECT COUNT(*) AS c FROM login WHERE user_status='pending'"
);

// Complaints in last 7 days (or total if no timestamp column)
if ($has_complaints_ts) {
  $complaints_7d = count_query(
    $con, 
    "SELECT COUNT(*) AS c FROM complaint 
     WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)"
  );
} else {
  $complaints_7d = count_query(
    $con, 
    "SELECT COUNT(*) AS c FROM complaint"
  );
}

// Feedback in last 7 days (or total if no timestamp column)
if ($has_feedbacks_ts) {
  $feedbacks_7d = count_query(
    $con, 
    "SELECT COUNT(*) AS c FROM feedback 
     WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)"
  );
} else {
  $feedbacks_7d = count_query(
    $con, 
    "SELECT COUNT(*) AS c FROM feedback"
  );
}

/* ----------------------------------------------------------------
   Step 3: Get recent pending species (latest 5)
----------------------------------------------------------------- */
$recent_species = mysqli_query(
  $con, 
  "SELECT id, name, file, location 
   FROM species 
   WHERE status='pending' 
   ORDER BY id DESC 
   LIMIT 5"
);
?>

<!-- ================= CSS ================= -->
<style>
  html, body { height: 100%; }
  body { background: #E9F2EC; }

  .page-head {
    padding-top: 1.25rem; 
    padding-bottom: 1.25rem;
    border-bottom: 1px solid #D5E5DA; 
    margin-bottom: 1.25rem;
  }
  .page-title { 
    font-size: 1.75rem; 
    font-weight: 700; 
    color: #282F34; 
    letter-spacing: .2px; 
    line-height: 1.2; 
  }
  .page-sub { 
    color: #5B6B61; 
    font-size: .95rem; 
  }

  .kpi-card {
    background: #F6FBF8; 
    border: 1px solid #D5E5DA; 
    border-radius: 12px; 
    padding: 16px; 
    text-align: center;
  }
  .kpi-number { 
    font-size: 26px; 
    font-weight: 700; 
    color: #282F34; 
    margin: 0; 
  }
  .kpi-label { 
    color: #5B6B61; 
    margin: 0; 
  }

  .quick-link {
    background: #fff; 
    border: 1px solid #D5E5DA; 
    border-radius: 10px; 
    padding: 12px 14px; 
    color: #282F34; 
    text-decoration: none; 
    display: block;
  }
  .quick-link:hover { background: #F6FBF8; }

  .species-mini {
    background: #F6FBF8; 
    border: 1px solid #D5E5DA; 
    border-radius: 10px; 
    padding: 10px; 
    display: flex; 
    align-items: center; 
    gap: 10px; 
  }
  .species-mini img { 
    width: 60px; 
    height: 60px; 
    object-fit: cover; 
    border-radius: 8px; 
  }
</style>

<!-- ================= Main Content ================= -->
<div class="container py-4" style="background:#E9F2EC;">

  <!-- Heading -->
  <div class="page-head">
    <h1 class="page-title m-0">Admin Dashboard</h1>
    <p class="page-sub m-0">Moderate submissions and manage accounts</p>
  </div>

  <!-- KPI cards -->
  <div class="row g-3 mb-3">
    <div class="col-12 col-md-3">
      <div class="kpi-card">
        <p class="kpi-number"><?= $pending_species ?></p>
        <p class="kpi-label">Pending species</p>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="kpi-card">
        <p class="kpi-number"><?= $pending_users ?></p>
        <p class="kpi-label">Pending users</p>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="kpi-card">
        <p class="kpi-number"><?= $complaints_7d ?></p>
        <p class="kpi-label">
          <?= $has_complaints_ts ? 'Complaints (7d)' : 'Complaints (total)' ?>
        </p>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="kpi-card">
        <p class="kpi-number"><?= $feedbacks_7d ?></p>
        <p class="kpi-label">
          <?= $has_feedbacks_ts ? 'Feedbacks (7d)' : 'Feedbacks (total)' ?>
        </p>
      </div>
    </div>
  </div>

  <!-- Quick links -->
  <div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
      <a class="quick-link" href="verifyspecies.php">Manage Species</a>
    </div>
    <div class="col-12 col-md-4">
      <a class="quick-link" href="verifycontributer.php">Verify Contributors</a>
    </div>
    <div class="col-12 col-md-4">
      <a class="quick-link" href="view_complaint.php">View Complaints</a>
    </div>
    <div class="col-12 col-md-4">
      <a class="quick-link" href="viewfeedback.php">View Feedbacks</a>
    </div>
    <div class="col-12 col-md-4">
      <a class="quick-link" href="view_researcher.php">View Researchers</a>
    </div>
    <div class="col-12 col-md-4">
      <a class="quick-link" href="view_report.php">View Reports</a>
    </div>
    <div class="col-12 col-md-4">
      <a class="quick-link" href="people_overview.php">People Overview</a>
    </div>
  </div>

  <!-- Recent pending species -->
  <h5 class="mb-3" style="color:#282F34;">Recent pending species</h5>
  <div class="row g-3">
    <?php if ($recent_species && mysqli_num_rows($recent_species) > 0) { ?>
      
      <?php while ($sp = mysqli_fetch_assoc($recent_species)) { ?>
        <div class="col-12 col-md-6 col-lg-4">
          <div class="species-mini">
            <img src="../uploads/<?= htmlspecialchars($sp['file']); ?>" 
                 alt="<?= htmlspecialchars($sp['name']); ?>">
            <div>
              <div style="font-weight:600; color:#282F34;">
                <?= htmlspecialchars($sp['name']); ?>
              </div>
              <div style="color:#5B6B61; font-size:.9rem;">
                <?= htmlspecialchars($sp['location']); ?>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    
    <?php } else { ?>
      <div class="col-12">
        <p class="text-muted m-0">No pending species right now.</p>
      </div>
    <?php } ?>
  </div>

</div>

<?php include 'js.php'; ?>
