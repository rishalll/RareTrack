<?php
include 'header.php';
?>
<body style="background-color: #E9F2EC; min-height: 100vh;">

  <div style="min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 1rem;">
    <div class="card shadow-sm" style="width: 100%; max-width: 500px; padding: 2rem; background:#F6FBF8; border:1px solid #D5E5DA; border-radius:16px; box-shadow:0 12px 30px rgba(0,0,0,.06);">
      <h3 class="text-center" style="margin-bottom: 1.0rem; color: #282F34; letter-spacing:.2px;">CONTRIBUTE TO OUR COMMUNITY</h3>
      <p class="text-center" style="margin-top:-.5rem; margin-bottom:1.25rem; color:#5B6B61; font-size:.9rem;">Share a sighting with RareTrack</p>

      <form method="post" action="addspecies_action.php" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="name" class="form-label" style="color:#5B6B61; letter-spacing:.1px;">Name of species</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter the name of species" required
                 style="background:#fff; border-color:#D5E5DA; color:#282F34; padding:.78rem .95rem;">
        </div>

        <div class="mb-3">
          <label for="type" class="form-label" style="color:#5B6B61; letter-spacing:.1px;">Type</label>
          <input type="text" class="form-control" id="type" name="type" placeholder="Type of species" required
                 style="background:#fff; border-color:#D5E5DA; color:#282F34; padding:.78rem .95rem;">
        </div>

        <div class="mb-3">
          <label for="phone" class="form-label" style="color:#5B6B61; letter-spacing:.1px;">Description</label>
          <textarea class="form-control" id="phone" name="description" placeholder="Describe the species" required
                    style="background:#fff; border-color:#D5E5DA; color:#282F34; padding:.78rem .95rem; min-height:96px; resize:vertical;"></textarea>
        </div>

        <div class="mb-3">
          <label for="location" class="form-label" style="color:#5B6B61; letter-spacing:.1px;">Location</label>
          <input type="text" class="form-control" id="location" name="location" placeholder="Describe the location" required
                 style="background:#fff; border-color:#D5E5DA; color:#282F34; padding:.78rem .95rem;">
        </div>

        <div class="mb-3">
          <label for="file" class="form-label" style="color:#5B6B61; letter-spacing:.1px;">Image/Video</label>
          <input type="file" class="form-control" id="file" name="file" required
                 style="background:#fff; border-color:#D5E5DA; color:#282F34; padding:.6rem .8rem;">
        </div>

        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-success rounded-pill" style="background:#2EB872; border-color:#2EB872; min-height:48px; padding:.95rem 1.25rem; letter-spacing:.3px;">
            Contribute
          </button>
        </div>
      </form>
    </div>
  </div>

<?php
include 'js.php';
?>
