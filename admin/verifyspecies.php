<?php
session_start();
include 'header.php';
include '../connection.php';
?>

<style>
  /* Global background and heading styles */
  html, body{ height:100%; }
  body{ background:#E9F2EC; }

  /* Reusable page heading block */
  .page-head{
    padding-top: 1.25rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid #D5E5DA;
    margin-bottom: 1.25rem;
  }
  .page-title{
    font-size: 1.75rem;
    font-weight: 700;
    color: #282F34;
    letter-spacing: .2px;
    line-height: 1.2;
  }
  .page-sub{
    color: #5B6B61;
    font-size: .95rem;
  }

  /* Card palette and behaviors to match View Species */
  .species-card{
    border:1px solid #D5E5DA; border-radius:16px; background:#F6FBF8;
    box-shadow:0 8px 20px rgba(0,0,0,.06);
    transition: transform .3s, box-shadow .3s;
  }
  .species-card:hover{ transform: translateY(-6px); box-shadow:0 12px 30px rgba(0,0,0,.12); }
  .species-img{ height:220px; object-fit:cover; border-top-left-radius:16px; border-top-right-radius:16px; }

  .card-title{ color:#282F34; font-weight:700; letter-spacing:.2px; }
  .meta{ color:#5B6B61; font-size:.95rem; }

  .badge{ font-size:.85rem; padding:6px 10px; border-radius:8px; }
  .badge-approve{ background:#2EB872; color:#fff; }
  .badge-pending{ background:#FFE08A; color:#1F2328; }
  .badge-reject{ background:#E55353; color:#fff; }

  .btn-pill{ border-radius:999px; }
</style>

<div class="container py-5" style="background:#E9F2EC;">

  <!-- =========================
       Page Heading (Reusable)
       Title, short context, and optional actions on the right
       ========================= -->
  <div class="page-head container">
    <div class="row align-items-center g-3">
      <div class="col">
        <h1 class="page-title m-0">Species List</h1>
        <p class="page-sub m-0">All submissions with contributor and status</p>
      </div>
      <div class="col-auto">
        <!-- Optional actions: export/filter (remove if not needed) -->
        <!-- <a href="export_species.php" class="btn btn-success btn-sm rounded-pill">Export CSV</a> -->
      </div>
    </div>
  </div>

  <?php
  // Pull species with contributor details
  $str = "SELECT species.name AS species_name, species.id, species.type, species.location, species.description, species.file, species.status, 
                 signup.name AS contributor_name, signup.phone, signup.login_id 
          FROM species 
          JOIN signup ON species.login_id = signup.login_id 
          JOIN login ON signup.login_id = login.id";
  $result = mysqli_query($con, $str);

  if (mysqli_num_rows($result) > 0) {
  ?>
  <!-- Responsive card grid like View Species -->
  <div class="row g-4">
    <?php while ($data = mysqli_fetch_array($result)) { ?>
      <div class="col-lg-4 col-md-6 col-sm-12 d-flex">
        <div class="card species-card shadow-sm w-100">
          <!-- Clickable preview goes to full asset in new tab -->
          <a href="../uploads/<?= htmlspecialchars($data['file']); ?>" target="_blank">
            <img src="../uploads/<?= htmlspecialchars($data['file']); ?>" class="card-img-top species-img" alt="<?= htmlspecialchars($data['species_name']); ?>">
          </a>

          <div class="card-body d-flex flex-column">
            <!-- Species name as strong card title -->
            <h5 class="card-title mb-1"><?= htmlspecialchars($data['species_name']); ?></h5>

            <!-- Contributor and quick contact info in muted meta line -->
            <p class="meta mb-2">
              By <?= htmlspecialchars($data['contributor_name']); ?> • <?= htmlspecialchars($data['phone']); ?>
            </p>

            <!-- Core properties: type + location -->
            <div class="mb-2" style="color:#5B6B61;">
              <p class="mb-1"><strong>Type:</strong> <?= htmlspecialchars($data['type']); ?></p>
              <p class="mb-1"><strong>Location:</strong> <?= htmlspecialchars($data['location']); ?></p>
            </div>

            <!-- Description (kept simple; can add truncation if needed) -->
            <p class="mb-2" style="color:#5B6B61;"><?= nl2br(htmlspecialchars($data['description'])); ?></p>

            <!-- Footer: status badge and optional admin actions (commented to match your file) -->
            <div class="mt-auto d-flex align-items-center justify-content-between">
              <span>
                <?php
                if ($data['status'] == 'approved') {
                  echo "<span class='badge badge-approve'>Approved ✅</span>";
                } elseif ($data['status'] == 'pending') {
                  echo "<span class='badge badge-pending'>Pending</span>";
                } elseif ($data['status'] == 'rejected') {
                  echo "<span class='badge badge-reject'>Rejected ❌</span>";
                }
                ?>
              </span>

              <span class="d-flex gap-2">
                <!-- <?php // if ($data['status'] == 'pending') { ?>
                  <a href="approvespecies.php?id=<?= $data['id']?>" class="btn btn-success btn-sm btn-pill">Approve</a>
                  <a href="rejectspecies.php?id=<?= $data['id']?>" class="btn btn-danger btn-sm btn-pill">Reject</a>
                <?php // } elseif ($data['status'] == 'approved') { ?>
                  <span class="btn btn-success btn-sm btn-pill disabled">Approved</span>
                <?php // } elseif ($data['status'] == 'rejected') { ?>
                  <span class="btn btn-danger btn-sm btn-pill disabled">Rejected</span>
                <?php // } ?>
              </span> -->
            
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>

  <?php
  } else {
    // Friendly empty state
    echo "<h4 class='text-center text-muted'>No species found.</h4>";
  }

  include 'js.php';
  ?>
</div>
