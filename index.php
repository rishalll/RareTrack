<?php
// Include header (navigation, styles, etc.)
include 'header.php';
?>

<!-- =======================
      HEADER SECTION START
========================= -->
<div class="container-fluid bg-dark p-0 mb-5">
  <div class="row g-0 flex-column-reverse flex-lg-row">

    <!-- Left: Text content -->
    <div class="col-lg-6 p-0 wow fadeIn" data-wow-delay="0.1s">
      <div class="header-bg h-100 d-flex flex-column justify-content-center p-5">

        <!-- Intro text -->
        <p class="text-primary mb-2"># Community-powered conservation</p>
        <h1 class="display-4 text-light mb-3">
          Capture rare wildlife moments for global research
        </h1>
        <p class="text-light-50 mb-4" style="max-width: 560px; color: rgba(255,255,255,.8) !important;">
          Share sightings, validate species, and help protect habitats with data trusted by researchers.
        </p>

        <!-- Call-to-action buttons -->
        <div class="d-flex align-items-center flex-wrap gap-2 pt-2 animated slideInDown">
          <a href="signup.php" class="btn btn-primary py-sm-3 px-3 px-sm-5">Get Started</a>
        </div>

        <!-- Badges -->
        <div class="d-flex flex-wrap gap-3 mt-4">
          <span class="badge bg-success bg-opacity-25 text-success border border-success">Verified data</span>
          <span class="badge bg-info bg-opacity-25 text-info border border-info">Research-ready</span>
          <span class="badge bg-warning bg-opacity-25 text-warning border border-warning">Privacy aware</span>
        </div>

      </div>
    </div>

    <!-- Right: Carousel images -->
    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
      <div class="owl-carousel header-carousel">
        <div class="owl-carousel-item">
          <img class="img-fluid" src="img/carousel-1.jpg" alt="Rare Animal 1" />
        </div>
        <div class="owl-carousel-item">
          <!-- FIXED: missing "=" in alt attribute -->
          <img class="img-fluid" src="img/carousel-2.jpg" alt="Rare Animal 2" />
        </div>
        <div class="owl-carousel-item">
          <img class="img-fluid" src="img/carousel-3.jpg" alt="Rare Animal 3" />
        </div>
      </div>
    </div>

  </div>
</div>
<!-- =======================
      HEADER SECTION END
========================= -->


<!-- =======================
      VIDEO MODAL START
========================= -->
<div class="modal modal-video fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-0">

      <!-- Modal header -->
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Our Research Video</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="ratio ratio-16x9">
          <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always" allow="autoplay"></iframe>
        </div>
      </div>

    </div>
  </div>
</div>
<!-- =======================
      VIDEO MODAL END
========================= -->


<!-- =======================
      ABOUT SECTION START
========================= -->
<div class="container-xxl py-5">
  <div class="container">
    <div class="row g-5">

      <!-- Left column: description & steps -->
      <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">

        <p><span class="text-primary me-2">#</span>RareTrack Initiative</p>
        <h1 class="display-5 mb-4">
          Document rare species for <span class="text-primary">real-world</span> conservation
        </h1>
        <p class="mb-4">
          Contribute sightings, validate records, and help researchers track endangered wildlife across regions with community-powered data.
        </p>

        <!-- Upload process -->
        <h5 class="mb-2"><i class="far fa-check-circle text-primary me-3"></i>What happens to uploads</h5>
        <ul class="mb-3" style="margin-left:1rem; color:#5B6B61;">
          <li>Images are reviewed by researchers for accuracy</li>
          <li>Verified sightings appear on public maps and feeds</li>
          <li>Insights guide habitat protection and policy</li>
        </ul>

        <!-- How it works -->
        <h5 class="mb-2"><i class="far fa-check-circle text-primary me-3"></i>How it works</h5>
        <ul class="mb-4" style="margin-left:1rem; color:#5B6B61;">
          <li>Snap a clear, location-tagged photo</li>
          <li>Upload with species name or description</li>
          <li>Get notified when verified</li>
        </ul>

        <!-- Join button -->
        <div class="d-flex flex-wrap gap-2">
          <a class="btn btn-primary py-3 px-5" href="signup.php">Join Project</a>
        </div>

      </div>

      <!-- Right column: image -->
      <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
        <div class="img-border mb-3">
          <img class="img-fluid" src="img/about.jpg" alt="Wildlife Research" />
        </div>
      </div>

    </div>
  </div>
</div>
<!-- =======================
      ABOUT SECTION END
========================= -->


<?php
// =======================
// DATABASE QUERIES
// =======================

// Connect to DB
include 'connection.php';

// Get counts
$speciesCount     = $con->query("SELECT COUNT(*) AS total FROM species")->fetch_assoc()['total'];
$contributorCount = $con->query("SELECT COUNT(*) AS total FROM signup")->fetch_assoc()['total'];
$researcherCount  = $con->query("SELECT COUNT(*) AS total FROM researcher")->fetch_assoc()['total'];
?>


<!-- =======================
      FACTS SECTION START
========================= -->
<div class="container-xxl bg-primary facts my-5 py-5 wow fadeInUp" data-wow-delay="0.1s">
  <div class="container py-5">
    <div class="row g-4">

      <!-- Total Species -->
      <div class="col-md-6 col-lg-4 text-center wow fadeIn" data-wow-delay="0.1s">
        <i class="fa fa-camera fa-3x text-primary mb-3"></i>
        <h1 class="text-white mb-2" data-toggle="counter-up"><?= $speciesCount ?></h1>
        <p class="text-white mb-0">Total Species</p>
      </div>

      <!-- Active Contributors -->
      <div class="col-md-6 col-lg-4 text-center wow fadeIn" data-wow-delay="0.3s">
        <i class="fa fa-users fa-3x text-primary mb-3"></i>
        <h1 class="text-white mb-2" data-toggle="counter-up"><?= $contributorCount ?></h1>
        <p class="text-white mb-0">Active Contributors</p>
      </div>

      <!-- Active Researchers -->
      <div class="col-md-6 col-lg-4 text-center wow fadeIn" data-wow-delay="0.7s">
        <i class="fa fa-globe fa-3x text-primary mb-3"></i>
        <h1 class="text-white mb-2" data-toggle="counter-up"><?= $researcherCount ?></h1>
        <p class="text-white mb-0">Active Researchers</p>
      </div>

    </div>
  </div>
</div>
<!-- =======================
      FACTS SECTION END
========================= -->


<?php
// =======================
// PUBLIC FEED SECTION
// =======================

// Fetch approved species
$feed_q = mysqli_query($con, "
  SELECT 
    species.id,
    species.name,
    species.type,
    species.location,
    species.description,
    species.file,
    signup.name AS contributor_name
  FROM species
  LEFT JOIN signup ON signup.login_id = species.login_id
  WHERE species.status = 'approved'
  ORDER BY species.id DESC
");

// Fetch like counts
$likes_map = [];
$likes_res = mysqli_query($con, "SELECT species_id, COUNT(*) AS like_count FROM species_likes GROUP BY species_id");
if ($likes_res) {
  while ($r = mysqli_fetch_assoc($likes_res)) {
    $likes_map[(int)$r['species_id']] = (int)$r['like_count'];
  }
}
?>


<!-- =======================
      CONTRIBUTIONS FEED
========================= -->
<div class="container-xxl py-5">
  <div class="container">
    <h5 class="section-title mb-4">Contributions From Others</h5>
    <div class="row g-4">

      <?php if($feed_q && mysqli_num_rows($feed_q) > 0){ ?>
        <?php while($row = mysqli_fetch_assoc($feed_q)){

          // Extract values
          $sid   = (int)$row['id'];
          $likec = $likes_map[$sid] ?? 0;

          // Handle description "see more"
          $desc_id  = 'desc-' . $sid;
          $short    = mb_substr($row['description'], 0, 140);
          $rest     = mb_substr($row['description'], 140);
          $has_more = mb_strlen($row['description']) > 140;
        ?>

        <!-- Single card -->
        <div class="col-md-4 col-sm-6">
          <div class="card h-100 border-0 shadow-sm">

            <!-- Image -->
            <img src="uploads/<?= htmlspecialchars($row['file']); ?>" 
                 class="card-img-top" 
                 alt="<?= htmlspecialchars($row['name']); ?>" 
                 loading="lazy" 
                 style="height:200px; object-fit:cover;">

            <!-- Card body -->
            <div class="card-body">
              <h5 class="card-title" style="color:#282F34;"><?= htmlspecialchars($row['name']); ?></h5>
              <p class="card-text" style="color:#5B6B61;"><strong>Type:</strong> <?= htmlspecialchars($row['type']); ?></p>
              <p class="card-text" style="color:#5B6B61;">
              <strong>Contributor:</strong> <?= htmlspecialchars($row['contributor_name'] ?? 'Unknown'); ?>
              </p>

              <p class="card-text" style="color:#5B6B61;"><strong>Location:</strong> <?= htmlspecialchars($row['location']); ?></p>

              <!-- Description with "see more" -->
              <p class="card-text" style="color:#5B6B61;">
                <?= nl2br(htmlspecialchars($short)); ?>
                <?php if($has_more){ ?>
                  <span class="collapse" id="<?= $desc_id ?>"><?= nl2br(htmlspecialchars($rest)); ?></span>
                  <a class="ms-1 small" data-bs-toggle="collapse" href="#<?= $desc_id ?>" role="button" aria-expanded="false" aria-controls="<?= $desc_id ?>">See more</a>
                <?php } ?>
              </p>
            </div>

            <!-- Likes footer -->
            <div class="card-footer bg-white border-0 d-flex justify-content-start align-items-center">
              <span class="badge bg-success">
                <i class="fa fa-heart me-1"></i> <?= (int)$likec ?> likes
              </span>
            </div>

          </div>
        </div>
        <?php } ?>
      <?php } else { ?>
        <div class="col-12">
          <p class="text-muted m-0">No verified contributions yet.</p>
        </div>
      <?php } ?>

    </div>
  </div>
</div>
<!-- =======================
      FEED END
========================= -->


<?php
// Include footer
include 'footer.php';
?>

