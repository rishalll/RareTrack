<?php
session_start();
include 'header.php';
include '../connection.php';
?>

<style>
  /* Global background + heading */
  html, body{ height:100%; }
  body{ background:#E9F2EC; }

  .page-head{
    padding-top: 1.25rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid #D5E5DA;
    margin-bottom: 1.25rem;
  }
  .page-title{
    font-size: 1.75rem; font-weight: 700; color:#282F34;
    letter-spacing:.2px; line-height:1.2;
  }
  .page-sub{ color:#5B6B61; font-size:.95rem; }

  /* Card visuals matching app palette */
  .complaint-card{
    border:1px solid #D5E5DA; border-radius:16px; background:#F6FBF8;
    box-shadow:0 8px 20px rgba(0,0,0,.06);
    transition: transform .3s, box-shadow .3s;
    display:flex; flex-direction:column; height:100%;
  }
  .complaint-card:hover{ transform: translateY(-6px); box-shadow:0 12px 30px rgba(0,0,0,.12); }
  .complaint-img{ height:220px; object-fit:cover; border-top-left-radius:16px; border-top-right-radius:16px; }

  .card-title{ color:#282F34; font-weight:700; letter-spacing:.2px; }
  .meta{ color:#5B6B61; font-size:.95rem; }

  .btn-pill{ border-radius:999px; }
  .btn-success{ background:#2EB872; border-color:#2EB872; }
  .btn-success:hover{ background:#25935b; border-color:#25935b; }
</style>

<div class="container py-5" style="background:#E9F2EC;">

  <!-- Professional heading: title + short context -->
  <div class="page-head container">
    <div class="row align-items-center g-3">
      <div class="col">
        <h1 class="page-title m-0">Complaints</h1>
        <p class="page-sub m-0">Contributor issues with optional media attachments</p>
      </div>
      <div class="col-auto">
        <!-- Optional action (filters/export); remove if not used -->
        <!-- <a href="export_complaints.php" class="btn btn-success btn-sm rounded-pill">Export CSV</a> -->
      </div>
    </div>
  </div>

  <?php
  // Pull complaints joined with contributor name
  $str = "SELECT complaint.*, signup.name 
          FROM complaint
          INNER JOIN signup ON complaint.contributor_id = signup.login_id";
  $result = mysqli_query($con, $str);

  if (mysqli_num_rows($result) > 0) {
    $count = mysqli_num_rows($result);
    $i = 0;
  ?>
  <div class="row g-4">
    <?php while ($data = mysqli_fetch_array($result)) { 
      $i++;

      // Escape values for safe output
      $name      = htmlspecialchars($data['name']);
      $subject   = htmlspecialchars($data['subject']);
      $complaint = htmlspecialchars($data['complaint']);
      $file      = htmlspecialchars($data['file']);

      // Basic check to render video vs image
      $isVideo = preg_match('/\.(mp4|webm|ogg)$/i', $file);
    ?>
      <div class="<?php echo ($count == 1) ? 'col-lg-6 col-md-8 col-sm-12' : 'col-lg-4 col-md-6 col-sm-12'; ?> d-flex">
        <div class="card complaint-card shadow-sm w-100">

          <!-- Click media to open in a modal viewer -->
          <?php if(!empty($file)){ ?>
            <a href="#" data-bs-toggle="modal" data-bs-target="#viewComplaintAsset<?= $i; ?>">
              <?php if($isVideo){ ?>
                <video class="w-100 complaint-img" muted>
                  <source src="../uploads/<?= $file; ?>">
                </video>
              <?php } else { ?>
                <img src="../uploads/<?= $file; ?>" class="card-img-top complaint-img" alt="Complaint Media">
              <?php } ?>
            </a>
          <?php } ?>

          <div class="card-body d-flex flex-column">
            <!-- Subject as the strong title -->
            <h5 class="card-title mb-1"><?= $subject; ?></h5>

            <!-- Contributor information in muted meta line -->
            <p class="meta mb-2">By <?= $name; ?></p>

            <!-- Complaint text -->
            <p class="mb-0" style="color:#5B6B61;"><?= nl2br($complaint); ?></p>

            <!-- Footer actions (optional): open asset in new tab if present -->
            <?php if(!empty($file)){ ?>
              <div class="mt-3">
                <a class="btn btn-outline-secondary btn-sm btn-pill" href="../uploads/<?= $file; ?>" target="_blank">
                  Open in new tab
                </a>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>

      <!-- Modal viewer per card for clean in-page viewing -->
      <?php if(!empty($file)){ ?>
      <div class="modal fade" id="viewComplaintAsset<?= $i; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content" style="background:#000;">
            <div class="modal-body p-0" style="max-height:80vh; display:flex; align-items:center; justify-content:center;">
              <?php if($isVideo){ ?>
                <video controls class="w-100" style="max-height:80vh;">
                  <source src="../uploads/<?= $file; ?>">
                </video>
              <?php } else { ?>
                <img src="../uploads/<?= $file; ?>" class="img-fluid w-100" alt="Full Media" style="object-fit:contain; max-height:80vh;">
              <?php } ?>
            </div>
            <div class="modal-footer bg-dark border-0 d-flex justify-content-end">
              <a href="../uploads/<?= $file; ?>" class="btn btn-light btn-sm btn-pill" download>Download</a>
              <button type="button" class="btn btn-secondary btn-sm btn-pill" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>

    <?php } ?>
  </div>
  <?php
  } else {
    // Friendly empty state to match tone of other pages
    echo "<h4 class='text-center text-muted'>No complaints found.</h4>";
  }

  include 'js.php';
  ?>
</div>
