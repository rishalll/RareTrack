<?php
session_start();
include 'header.php';
include '../connection.php';
?>

<style>
  /* Global background + heading styles (can be moved to main CSS once) */
  html, body{ height:100%; }
  body{ background:#E9F2EC; }

  /* Professional page heading block */
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

  /* Report card palette and behaviors (matches app cards) */
  .report-card{
    border:1px solid #D5E5DA; border-radius:16px; background:#F6FBF8;
    box-shadow:0 8px 20px rgba(0,0,0,.06);
    transition: transform .3s, box-shadow .3s;
    display:flex; flex-direction:column; height:100%;
  }
  .report-card:hover{ transform: translateY(-6px); box-shadow:0 12px 30px rgba(0,0,0,.12); }
  .report-img{ height:220px; object-fit:cover; border-top-left-radius:16px; border-top-right-radius:16px; }

  .card-body{ padding:18px; display:flex; flex-direction:column; }
  .card-title{ font-size:1.15rem; font-weight:700; color:#282F34; letter-spacing:.2px; margin-bottom:10px; }

  .report-info p{ margin-bottom:6px; font-size:.95rem; color:#5B6B61; }
  .truncate-text{
    overflow:hidden; text-overflow:ellipsis; display:-webkit-box;
    -webkit-line-clamp:3; -webkit-box-orient:vertical; font-size:.9rem; color:#5B6B61;
  }

  .btn-success{ background:#2EB872; border-color:#2EB872; }
  .btn-success:hover{ background:#25935b; border-color:#25935b; }
  .btn-pill{ border-radius:999px; }
</style>

<div class="container py-5" style="background:#E9F2EC;">

  <!-- =========================
       Page Heading (Reusable)
       Purpose: A clean, consistent header with title, subtext, and optional actions.
       ========================= -->
  <div class="page-head container">
    <div class="row align-items-center g-3">
      <!-- Left: main title and one-line context -->
      <div class="col">
        <h1 class="page-title m-0">Reports</h1>
        <p class="page-sub m-0">Researcher observations with media and comments</p>
      </div>
      <!-- Right: optional actions (remove if not needed) -->
      <div class="col-auto">
        <!-- Example: could point to a CSV export or filters page -->
        <!-- <a href="export_reports.php" class="btn btn-success btn-sm rounded-pill">Export CSV</a> -->
      </div>
    </div>
  </div>

  <?php
  // Pull report + species + researcher info for the cards
  $str = "SELECT 
            researcher.name AS researcher_name, 
            species.name AS species_name, 
            species.type AS species_type, 
            species.file, 
            species.location, 
            report.comment 
          FROM report 
          INNER JOIN species ON report.species_id = species.id
          INNER JOIN researcher ON report.researcher_id = researcher.login_id";
  $result = mysqli_query($con, $str);

  if (mysqli_num_rows($result) > 0) {
      // small utility: a few sample recipient emails for quick share
      $randomEmails = ['wildlife@ngo.org', 'conservation@org.com', 'forestdept@gov.in', 'naturewatch@mail.com'];
      $count = mysqli_num_rows($result);
      $i = 0;
  ?>
  <div class="row g-4 justify-content-center">
    <?php while ($data = mysqli_fetch_array($result)) { 
      $i++;

      // Defensive escaping for safe output
      $file        = htmlspecialchars($data['file']);
      $speciesName = htmlspecialchars($data['species_name']);
      $researcher  = htmlspecialchars($data['researcher_name']);
      $stype       = htmlspecialchars($data['species_type']);
      $loc         = htmlspecialchars($data['location']);
      $comment     = htmlspecialchars($data['comment']);

      // Pick a random recipient and build a simple mailto body
      $randomEmail = $randomEmails[array_rand($randomEmails)];
      $mailBody = "Hello,%0D%0A%0D%0A".
                  "Here are the details of the reported species:%0D%0A".
                  "Species Name: ".$speciesName."%0D%0A".
                  "Species Type: ".$stype."%0D%0A".
                  "Location: ".$loc."%0D%0A".
                  "Comment: ".$comment."%0D%0A%0D%0A".
                  "Regards,%0D%0AResearch Team";

      // Basic file type check: if it looks like a video, render a video preview
      $isVideo = preg_match('/\.(mp4|webm|ogg)$/i', $file);
    ?>
      <div class="<?php echo ($count == 1) ? 'col-lg-6 col-md-8 col-sm-12' : 'col-lg-4 col-md-6 col-sm-12'; ?> d-flex">
        <div class="card report-card shadow-sm w-100">

          <!-- Thumbnail: click to open full media in a modal -->
          <a href="#" data-bs-toggle="modal" data-bs-target="#viewAsset<?= $i; ?>">
            <?php if($isVideo){ ?>
              <!-- Muted preview helps indicate it’s a video without autoplay noise -->
              <video class="w-100 report-img" muted>
                <source src="../uploads/<?= $file; ?>">
              </video>
            <?php } else { ?>
              <img src="../uploads/<?= $file; ?>" class="card-img-top report-img" alt="Report Media">
            <?php } ?>
          </a>

          <div class="card-body">
            <!-- Clear, strong title -->
            <h5 class="card-title"><?= $speciesName; ?></h5>

            <!-- Compact meta details in a readable muted tone -->
            <div class="report-info mb-3">
              <p><strong>Researcher:</strong> <?= $researcher; ?></p>
              <p><strong>Type:</strong> <?= $stype; ?></p>
              <p><strong>Location:</strong> <?= $loc; ?></p>
            </div>

            <!-- Comment truncated to 3 lines for tidy cards -->
            <p class="truncate-text"><strong>Comment:</strong> <?= $comment; ?></p>

            <!-- Actions: quick share via email, or open media in a new tab -->
            <div class="mt-auto d-flex gap-2">
              <a href="mailto:<?= $randomEmail; ?>?subject=Species%20Report&body=<?= $mailBody; ?>"
                 class="btn btn-success btn-sm btn-pill">📧 Send Mail</a>
              <a class="btn btn-outline-secondary btn-sm btn-pill" href="../uploads/<?= $file; ?>" target="_blank">Open in new tab</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Full-screen modal viewer for image/video -->
      <div class="modal fade" id="viewAsset<?= $i; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content" style="background:#000;">
            <!-- Media area: centers image/video and caps height for large screens -->
            <div class="modal-body p-0" style="max-height:80vh; display:flex; align-items:center; justify-content:center;">
              <?php if($isVideo){ ?>
                <video controls class="w-100" style="max-height:80vh;">
                  <source src="../uploads/<?= $file; ?>">
                </video>
              <?php } else { ?>
                <img src="../uploads/<?= $file; ?>" class="img-fluid w-100" alt="Full Media" style="object-fit:contain; max-height:80vh;">
              <?php } ?>
            </div>
            <!-- Footer gives filename context, plus download and close controls -->
            <div class="modal-footer bg-dark border-0 d-flex justify-content-between">
              <span class="text-white small"><?= $speciesName; ?> • <?= $researcher; ?></span>
              <div>
                <a href="../uploads/<?= $file; ?>" class="btn btn-light btn-sm btn-pill" download>Download</a>
                <button type="button" class="btn btn-secondary btn-sm btn-pill" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    <?php } ?>
  </div>
  <?php
  } else {
    // Friendly empty state in the same tone as other pages
    echo "<h4 class='text-center text-muted'>No reports found.</h4>";
  }

  include 'js.php';
  ?>
</div>
