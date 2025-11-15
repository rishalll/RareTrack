<?php 
session_start();

// Common includes
include 'header.php';
include '../connection.php';

// Logged in contributor's ID (if not logged in, default = 0)
$login_id = $_SESSION['id'] ?? 0;

/* ---------------------------
   Contributor quick stats
----------------------------*/

// Total uploads by this contributor
$total = mysqli_fetch_assoc(
    mysqli_query($con, "SELECT COUNT(*) AS c 
                        FROM species 
                        WHERE login_id='$login_id'")
)['c'] ?? 0;

// Approved uploads by this contributor
$approved = mysqli_fetch_assoc(
    mysqli_query($con, "SELECT COUNT(*) AS c 
                        FROM species 
                        WHERE login_id='$login_id' 
                          AND status='approved'")
)['c'] ?? 0;

// Pending uploads by this contributor
$pending = mysqli_fetch_assoc(
    mysqli_query($con, "SELECT COUNT(*) AS c 
                        FROM species 
                        WHERE login_id='$login_id' 
                          AND status='pending'")
)['c'] ?? 0;

/* ---------------------------
   Optional: Community feed 
   (All approved species)
----------------------------*/
$feed_q = mysqli_query(
    $con, 
    "SELECT * FROM species 
     WHERE status='approved' 
     ORDER BY id DESC"
);
?> 

<style>
  /* Page layout */
  html, body { height:100%; }
  body { background:#E9F2EC; }

  /* Header section */
  .page-head {
    padding:16px 0; 
    border-bottom:1px solid #D5E5DA; 
    margin-bottom:16px;
  }
  .page-title {
    font-size:28px; 
    font-weight:700; 
    color:#282F34; 
    margin:0;
  }
  .page-sub {
    color:#5B6B61; 
    margin:0;
  }

  /* Stat cards */
  .fact-card {
    background:#F6FBF8; 
    border:1px solid #D5E5DA; 
    border-radius:12px; 
    padding:16px; 
    text-align:center;
  }
  .fact-number {
    font-size:26px; 
    font-weight:700; 
    color:#282F34; 
    margin:0;
  }
  .fact-label {
    color:#5B6B61; 
    margin:0;
  }

  /* Contributor quick-links */
  .contrib-quick-links .quick-link {
    background:#ffffff;
    border:1px solid #D5E5DA;
    border-radius:12px;
    padding:14px 16px;
    color:#282F34;
    text-decoration:none;
    display:block;
    font-weight:600;
    letter-spacing:.2px;
    transition:background .2s ease, 
               transform .1s ease, 
               box-shadow .2s ease, 
               border-color .2s ease;
  }
  .contrib-quick-links .quick-link:hover {
    background:#F6FBF8;
    border-color:#bcd7c8;
    box-shadow:0 6px 16px rgba(0,0,0,.06);
    transform:translateY(-1px);
  }
  .contrib-quick-links .row.g-3 > [class*="col-"] { 
    display:flex; 
  }
  .contrib-quick-links .row.g-3 > [class*="col-"] .quick-link { 
    width:100%; 
  }
  .contrib-quick-links .quick-link::after {
    content:"→";
    float:right;
    color:#5B6B61;
    transition:transform .2s ease, color .2s ease;
  }
  .contrib-quick-links .quick-link:hover::after {
    transform:translateX(2px); 
    color:#3d5c4e; 
  }

  /* Optional species card styles */
  .species-card {
    border:1px solid #D5E5DA; 
    border-radius:12px; 
    background:#F6FBF8; 
    box-shadow:0 6px 16px rgba(0,0,0,.06);
  }
  .species-img {
    height:220px; 
    object-fit:cover; 
    border-top-left-radius:12px; 
    border-top-right-radius:12px;
  }
  .like-btn, .comment-btn {
    display:flex; 
    align-items:center; 
    font-weight:500;
  }
  .like-btn.liked {
    background:#dc3545; 
    color:#fff; 
    border-color:#dc3545;
  }
  textarea.comment-input {
    resize:vertical; 
    min-height:60px;
  }
  .section-title {
    color:#282F34; 
    font-weight:700; 
    margin:16px 0;
  }
</style>

<!-- Main container -->
<div class="container py-4" style="background:#E9F2EC;">

  <!-- Page heading -->
  <div class="page-head">
    <h1 class="page-title">Contributor Dashboard</h1>
    <p class="page-sub">Upload sightings, track approvals, and engage with others</p>
  </div>

  <!-- KPI cards -->
  <div class="row g-3 mb-3">
    <div class="col-12 col-md-4">
      <div class="fact-card">
        <p class="fact-number"><?= (int)$total ?></p>
        <p class="fact-label">Total uploads</p>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="fact-card">
        <p class="fact-number"><?= (int)$approved ?></p>
        <p class="fact-label">Approved</p>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="fact-card">
        <p class="fact-number"><?= (int)$pending ?></p>
        <p class="fact-label">Pending</p>
      </div>
    </div>
  </div>

  <!-- Quick links -->
  <div class="contrib-quick-links">
    <div class="row g-3 mb-4">
      <div class="col-12 col-md-4">
        <a class="quick-link" href="profile.php">Profile</a>
      </div>
      <div class="col-12 col-md-4">
        <a class="quick-link" href="addspecies.php">Contribute</a>
      </div>
      <div class="col-12 col-md-4">
        <a class="quick-link" href="viewspecies.php">View contributions</a>
      </div>
      <div class="col-12 col-md-4">
        <a class="quick-link" href="addfeedback.php">Feedbacks</a>
      </div>
      <div class="col-12 col-md-4">
        <a class="quick-link" href="addcomplaint.php">Complaints</a>
      </div>
      <div class="col-12 col-md-4">
        <a class="quick-link" href="achievements.php">Achievements</a>
      </div>
    </div>
  </div>

  <!-- Optional: Community feed -->
  <!-- 
  <h5 class="section-title">Community contributions</h5>
  <div class="row g-3">
    <?php if($feed_q && mysqli_num_rows($feed_q) > 0){ ?>
      <?php while($sp = mysqli_fetch_assoc($feed_q)){ ?>
        <div class="col-12 col-md-6 col-lg-4">
          <div class="species-card h-100">
            <img class="species-img" 
                 src="../uploads/<?= htmlspecialchars($sp['file']); ?>" 
                 alt="<?= htmlspecialchars($sp['name']); ?>">
            <div class="p-3">
              <div style="font-weight:600; color:#282F34;">
                <?= htmlspecialchars($sp['name']); ?>
              </div>
              <div style="color:#5B6B61; font-size:.95rem;">
                <?= htmlspecialchars($sp['location']); ?>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    <?php } ?>
  </div>
  -->

</div>

<?php include 'js.php'; ?>
