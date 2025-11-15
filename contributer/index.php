<?php
session_start();
include 'header.php';
include '../connection.php';

// Current logged-in user ID
$login_id = $_SESSION['id'];

// Fetch all approved species (feed data)
$feed_q = mysqli_query(
  $con,
  "SELECT 
    species.id,
    species.name,
    species.type,
    species.location,
    species.description,
    species.file,
    signup.name AS contributor_name
   FROM species
   LEFT JOIN signup ON signup.login_id = species.login_id
   WHERE species.status='approved'
   ORDER BY species.id DESC"
);

?>

<!-- ================= STYLES ================= -->
<style>
  /* Uniform thumbnail size for species images */
  .species-img {
    width: 100%;
    height: 200px;              /* adjust between 180–240px if needed */
    object-fit: cover;          /* crop image nicely */
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
  }

  /* Limit description text inside cards */
  .card-text:last-of-type {
    display: -webkit-box;
    -webkit-line-clamp: 3;      /* max 3 lines */
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  /* Allow collapsed text to expand inline */
  .card-text .collapse.show {
    display: inline;
  }
</style>

<!-- ================= MAIN PAGE ================= -->
<div class="container py-4" style="background:#E9F2EC;">

  <!-- Page Heading -->
  <div class="page-head">
    <h1 class="page-title">Contributors Home</h1>
    <p class="page-sub">Upload sightings, track approvals, and engage with others</p>
  </div>

  <!-- Main Action Buttons -->
  <div class="d-flex gap-2 flex-wrap mb-4">
    <a href="addspecies.php" class="btn btn-success rounded-pill" style="background:#2EB872; border-color:#2EB872;">Contribute</a>
    <a href="dashboard.php" class="btn btn-outline-success rounded-pill" style="border-color:#2EB872; color:#2EB872;">Dashboard</a>
  </div>

  <!-- Feed Section -->
  <h5 class="section-title">Contributions From Others</h5>
  <div class="row g-4">

    <?php if($feed_q && mysqli_num_rows($feed_q) > 0){ ?>

      <?php
      /* ---------------- Prepare Likes & Comments Data ---------------- */
      
      // Likes count for each species
      $likes_map = [];
      $likes_res = mysqli_query(
        $con,
        "SELECT species_id, COUNT(*) AS like_count 
         FROM species_likes 
         GROUP BY species_id"
      );
      if($likes_res){
        while($r = mysqli_fetch_assoc($likes_res)){
          $likes_map[(int)$r['species_id']] = (int)$r['like_count'];
        }
      }

      // Which species current user has liked
      $user_likes = [];
      $ul_res = mysqli_query(
        $con,
        "SELECT species_id 
         FROM species_likes 
         WHERE login_id='$login_id'"
      );
      if($ul_res){
        while($u = mysqli_fetch_assoc($ul_res)){
          $user_likes[] = (int)$u['species_id'];
        }
      }

      // Comments grouped by species
      $comments = [];
      $c_res = mysqli_query(
        $con,
        "SELECT species_id, comment 
         FROM species_comments 
         ORDER BY created_at ASC"
      );
      if($c_res){
        while($c = mysqli_fetch_assoc($c_res)){
          $comments[(int)$c['species_id']][] = $c;
        }
      }
      ?>

      <?php while($row = mysqli_fetch_assoc($feed_q)){ 
        /* ---------------- Prepare Each Species Card ---------------- */
        $sid       = (int)$row['id'];
        $liked     = in_array($sid, $user_likes);
        $likec     = $likes_map[$sid] ?? 0;

        // Description: short + rest (for "See more")
        $desc_id   = 'desc-' . $sid;
        $short     = mb_substr($row['description'], 0, 140);
        $rest      = mb_substr($row['description'], 140);
        $has_more  = mb_strlen($row['description']) > 140;
      ?>

      <!-- ================= Species Card ================= -->
      <div class="col-md-4 col-sm-6">
        <div class="card h-100 border-0 shadow-sm species-card">

          <!-- Image clickable (opens full size in new tab) -->
          <a href="../uploads/<?= htmlspecialchars($row['file']); ?>" target="_blank" rel="noopener">
            <img src="../uploads/<?= htmlspecialchars($row['file']); ?>"
                 class="card-img-top species-img"
                 alt="<?= htmlspecialchars($row['name']); ?>"
                 loading="lazy">
          </a>

          <!-- Card Body -->
          <div class="card-body">
            <h5 class="card-title" style="color:#282F34;">
              <?= htmlspecialchars($row['name']); ?>
            </h5>
            <p class="card-text" style="color:#5B6B61;">
              <strong>Type:</strong> <?= htmlspecialchars($row['type']); ?>
            </p>
             <p class="card-text" style="color:#5B6B61;">
              <strong>Contributor:</strong> <?= htmlspecialchars($row['contributor_name'] ?? 'Unknown'); ?>
              </p>
            <p class="card-text" style="color:#5B6B61;">
              <strong>Location:</strong> <?= htmlspecialchars($row['location']); ?>
            </p>

            <!-- Description -->
            <p class="card-text" style="color:#5B6B61;">
              <?= nl2br(htmlspecialchars($short)); ?>
              <?php if($has_more){ ?>
                <span class="collapse" id="<?= $desc_id ?>">
                  <?= nl2br(htmlspecialchars($rest)); ?>
                </span>
                <a class="ms-1 small"
                   data-bs-toggle="collapse"
                   href="#<?= $desc_id ?>"
                   role="button"
                   aria-expanded="false"
                   aria-controls="<?= $desc_id ?>">
                  See more
                </a>
              <?php } ?>
            </p>

            <!-- Read More (Modal Trigger) -->
            <button type="button"
                    class="btn btn-link p-0 text-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modal<?= $sid ?>">
              Read More
            </button>
          </div>

          <!-- Card Footer: Like & Comment Buttons -->
          <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
            <button class="btn btn-sm btn-outline-success like-btn <?= $liked ? 'liked' : '' ?>"
                    data-species="<?= $sid ?>">
              <i class="fa fa-heart me-1"></i> 
              Like <span class="like-count"><?= $likec ?></span>
            </button>

            <button class="btn btn-sm btn-outline-secondary comment-btn"
                    data-bs-toggle="collapse"
                    data-bs-target="#comments-<?= $sid ?>">
              <i class="fa fa-comment me-1"></i> 
              Comment <span class="comment-count"><?= count($comments[$sid] ?? []) ?></span>
            </button>
          </div>

          <!-- Collapsible Comments Section -->
          <div class="collapse" id="comments-<?= $sid ?>">
            <div class="card-body border-top">
              
              <!-- Existing Comments -->
              <div class="existing-comments mb-2">
                <?php
                  if(isset($comments[$sid])){
                    foreach($comments[$sid] as $c){
                      echo '<div class="mb-1">'.htmlspecialchars($c['comment']).'</div>';
                    }
                  }
                ?>
              </div>

              <!-- New Comment Input -->
              <textarea class="form-control mb-2 comment-input"
                        placeholder="Write a comment..."
                        data-species="<?= $sid ?>"></textarea>

              <button class="btn btn-sm btn-primary w-100 post-comment"
                      data-species="<?= $sid ?>">
                Post
              </button>
            </div>
          </div>

        </div>
      </div>

      <!-- ================= Modal (Full Info) ================= -->
      <div class="modal fade" id="modal<?= $sid ?>" tabindex="-1" aria-hidden="true" aria-labelledby="modalLabel<?= $sid ?>">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            
            <div class="modal-header">
              <h5 id="modalLabel<?= $sid ?>" class="modal-title">
                <?= htmlspecialchars($row['name']); ?>
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <img src="../uploads/<?= htmlspecialchars($row['file']); ?>"
                   alt="<?= htmlspecialchars($row['name']); ?>"
                   class="img-fluid mb-3"
                   style="border-radius:8px;">
              <p class="mb-1"><strong>Type:</strong> <?= htmlspecialchars($row['type']); ?></p>
              <p class="card-text" style="color:#5B6B61;">
              <strong>Contributor:</strong> <?= htmlspecialchars($row['contributor_name'] ?? 'Unknown'); ?>
              </p>
              <p class="mb-2"><strong>Location:</strong> <?= htmlspecialchars($row['location']); ?></p>
              <div style="white-space:pre-wrap; color:#5B6B61;">
                <?= htmlspecialchars($row['description']); ?>
              </div>
            </div>

            <div class="modal-footer">
              <a href="../uploads/<?= htmlspecialchars($row['file']); ?>"
                 target="_blank" rel="noopener"
                 class="btn btn-outline-primary">Open Image</a>
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>

          </div>
        </div>
      </div>

      <?php } // end while ?>
    
    <?php } else { ?>
      <!-- If no species are available -->
      <div class="col-12">
        <p class="text-muted m-0">No verified contributions yet.</p>
      </div>
    <?php } ?>

  </div>
</div>

<!-- ================= LIKE & COMMENT JS ================= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
  // Like button
  $('.like-btn').on('click', function(){
    var species_id = $(this).data('species');
    var btn = $(this);
    $.post('like_species.php', { species_id: species_id }, function(data){
      btn.find('.like-count').text(data);
      btn.toggleClass('liked');
    });
  });

  // Post comment
  $('.post-comment').on('click', function(){
    var species_id = $(this).data('species');
    var textarea = $(this).siblings('.comment-input');
    var comment = textarea.val();
    var commentsDiv = $(this).siblings('.existing-comments');

    if(comment.trim() !== ''){
      $.post('comment_species.php', { species_id: species_id, comment: comment }, function(data){
        commentsDiv.append('<div class="mb-1">'+data+'</div>');
        textarea.val('');
        $('button.comment-btn[data-bs-target="#comments-'+species_id+'"] .comment-count')
          .text(commentsDiv.children().length);
      });
    }
  });
});
</script>

<?php include 'footer.php'; ?>
