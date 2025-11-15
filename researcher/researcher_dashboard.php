<?php
session_start();
include 'header.php';
include '../connection.php';

$login_id = $_SESSION['id'];

/* -----------------------------
   Helper function: count_query
   Runs a COUNT(*) query safely
------------------------------ */
function count_query($con, $sql){
  $res = mysqli_query($con, $sql);
  if(!$res){ return 0; }
  $row = mysqli_fetch_assoc($res);
  return isset($row['c']) ? (int)$row['c'] : 0;
}

/* -----------------------------
   KPIs for researcher
   - Reports submitted by this researcher
   - Total approved species
   - Total pending species (available to review)
------------------------------ */
$reports_submitted   = count_query($con, "SELECT COUNT(*) AS c FROM report WHERE researcher_id='$login_id'");
$species_reviewed    = count_query($con, "SELECT COUNT(*) AS c FROM species WHERE status='approved'");
$available_to_review = count_query($con, "SELECT COUNT(*) AS c FROM species WHERE status='pending'");

/* -----------------------------
   Recent pending queue
   Latest 6 species still pending
------------------------------ */
$queue = mysqli_query(
  $con,
  "SELECT id, name, file, location 
   FROM species 
   WHERE status='pending' 
   ORDER BY id DESC 
   LIMIT 6"
);
?>

<style>
  body { background:#E9F2EC; }

  .page-head {
    padding-top:1.25rem;
    padding-bottom:1.25rem;
    border-bottom:1px solid #D5E5DA;
    margin-bottom:1.25rem;
  }
  .page-title { font-size:1.75rem; font-weight:700; color:#282F34; margin:0; }
  .page-sub   { color:#5B6B61; margin:0; }

  .kpi-card {
    background:#F6FBF8;
    border:1px solid #D5E5DA;
    border-radius:12px;
    padding:16px;
    text-align:center;
  }
  .kpi-number { font-size:26px; font-weight:700; color:#282F34; margin:0; }
  .kpi-label  { color:#5B6B61; margin:0; }

  .quick-link {
    background:#fff;
    border:1px solid #D5E5DA;
    border-radius:10px;
    padding:12px 14px;
    color:#282F34;
    text-decoration:none;
    display:block;
  }
  .quick-link:hover { background:#F6FBF8; }

  .species-mini {
    background:#F6FBF8;
    border:1px solid #D5E5DA;
    border-radius:10px;
    padding:10px;
    display:flex;
    align-items:center;
    gap:10px;
  }
  .species-mini img {
    width:60px; height:60px;
    object-fit:cover;
    border-radius:8px;
  }

  /* Custom buttons styled to match theme */
  .btn-success {
    background:#2EB872 !important;
    border-color:#2EB872 !important;
    color:#fff !important;
    border-radius:999px !important;
    padding:.5rem 1rem !important;
    font-weight:600 !important;
    box-shadow:0 4px 10px rgba(46,184,114,.18) !important;
    transition:transform .15s, box-shadow .15s, background-color .15s;
  }
  .btn-success:hover {
    background:#25935b !important;
    border-color:#25935b !important;
    transform:translateY(-1px);
    box-shadow:0 6px 16px rgba(37,147,91,.22) !important;
  }

  .btn-outline-secondary {
    border-color:#CED7CF !important;
    color:#5B6B61 !important;
    border-radius:999px !important;
    padding:.45rem .9rem !important;
    font-weight:600 !important;
  }
  .btn-outline-secondary:hover {
    background:#F6FBF8 !important;
    color:#282F34 !important;
  }
</style>

<div class="container py-4" style="background:#E9F2EC;">

  <!-- Page heading -->
  <div class="page-head">
    <h1 class="page-title">Researcher Dashboard</h1>
    <p class="page-sub">Verify species, manage reports, and keep data clean</p>
  </div>

  <!-- KPI cards -->
  <div class="row g-3 mb-3">
    <div class="col-12 col-md-4">
      <div class="kpi-card">
        <p class="kpi-number"><?= $reports_submitted ?></p>
        <p class="kpi-label">Reports submitted</p>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="kpi-card">
        <p class="kpi-number"><?= $species_reviewed ?></p>
        <p class="kpi-label">Species reviewed</p>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="kpi-card">
        <p class="kpi-number"><?= $available_to_review ?></p>
        <p class="kpi-label">Available to review</p>
      </div>
    </div>
  </div>

  <!-- Quick links -->
  <div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
      <a class="quick-link" href="verifyspecies.php">Verify Species</a>
    </div>
    <div class="col-12 col-md-4">
      <a class="quick-link" href="profile.php">My Profile</a>
    </div>
    <div class="col-12 col-md-4">
      <a class="quick-link" href="researcher_achievements.php">My Achievements</a>
    </div>
  </div>

  <!-- Pending review queue (currently commented out, can be enabled if needed) -->
  <!--
  <h5 class="mb-3" style="color:#282F34;">Pending review queue</h5>
  <div class="row g-3">
    <?php if($queue && mysqli_num_rows($queue) > 0){ ?>
      <?php while($sp = mysqli_fetch_assoc($queue)){ ?>
        <div class="col-12 col-md-6 col-lg-4">
          <div class="species-mini">
            <img src="../uploads/<?= htmlspecialchars($sp['file']); ?>" alt="<?= htmlspecialchars($sp['name']); ?>">
            <div class="flex-grow-1">
              <div style="font-weight:600; color:#282F34;"><?= htmlspecialchars($sp['name']); ?></div>
              <div style="color:#5B6B61; font-size:.9rem;"><?= htmlspecialchars($sp['location']); ?></div>
            </div>
            <div class="d-flex gap-2">
              <a href="edit_species.php?id=<?= (int)$sp['id']; ?>" class="btn btn-success btn-sm">Verify</a>
              <a href="revoke_species.php?id=<?= (int)$sp['id']; ?>" class="btn btn-outline-secondary btn-sm">Revoke</a>
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
  -->
</div>

<?php include 'js.php'; ?>
