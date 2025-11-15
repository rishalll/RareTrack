<?php
session_start();
include 'header.php';
include '../connection.php';
?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $str = "DELETE FROM species WHERE id='$id'";
    if (mysqli_query($con, $str)) {
        echo "<script>alert('Species deleted successfully'); window.location='viewspecies.php';</script>";
    } else {
        echo "<script>alert('Species not deleted'); window.location='viewspecies.php';</script>";
    }
}
?>

<style>
 html, body{ height:100%; }
  body{ background:#E9F2EC !important; }           /* force global bg */
  .page-species{ background:transparent !important; padding-top:6rem; padding-bottom:3rem; }
  /* View Species — palette + simple polish only */


  .species-card{
    border: 1px solid #D5E5DA;        /* subtle border */
    border-radius: 16px;
    overflow: hidden;
    background: #F6FBF8;              /* soft card surface */
    box-shadow: 0 8px 20px rgba(0,0,0,.06);
    transition: transform .3s ease, box-shadow .3s ease;
    display: flex; flex-direction: column; height: 100%;
  }
  .species-card:hover{
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0,0,0,.12);
  }

  .species-card img{ height: 220px; object-fit: cover; }

  .species-card .card-body{
    background: #F6FBF8;
    padding: 16px;
    flex-grow: 1;
    display: flex; flex-direction: column;
  }
  .species-card .card-title{
    font-size: 1.1rem; font-weight: 600; color: #282F34;
    margin-bottom: 10px; letter-spacing: .2px;
  }

  .species-info p{ margin-bottom: 6px; font-size: .95rem; color: #5B6B61; }

  .truncate-text{
    overflow: hidden; text-overflow: ellipsis; display: -webkit-box;
    -webkit-line-clamp: 2; -webkit-box-orient: vertical;
  }

  .badge{ font-size: .85rem; padding: 6px 10px; border-radius: 8px; }
  .badge.bg-success{ background-color: #2EB872 !important; }  /* brand green */
  .badge.bg-warning{ background-color: #FFE08A !important; color: #1F2328 !important; }
  .badge.bg-danger{ background-color: #E55353 !important; }

  .btn-link.p-0.text-primary{ color: #2EB872 !important; }
  .btn-link.p-0.text-primary:hover{ color: #25935b !important; }

  .btn-sm{ border-radius: 10px; padding: .4rem .65rem; font-weight: 500; }
  .btn-danger.btn-sm{ background: #E55353; border-color: #E55353; }
  .btn-danger.btn-sm:hover{ background: #cc4646; border-color: #cc4646; }

  .modal-content{ border-radius: 16px; border: 1px solid #D5E5DA; }
  .modal-header{ border-bottom-color: #D5E5DA; }
</style>

<div class="container page-species">
  <h2 class="text-center mb-4 fw-bold" style="color:#282F34;">My Species List</h2>

  <?php
  $login_id = $_SESSION['id'];
  $str = "SELECT species.id AS species_id, species.name, species.type, species.location, species.description, species.file, species.status, species.real_name, species.details
          FROM species WHERE species.login_id = '$login_id'";
  $result = mysqli_query($con, $str);

  if (mysqli_num_rows($result) > 0) {
  ?>
  <div class="row g-4">
    <?php while ($data = mysqli_fetch_array($result)) { ?>
      <div class="col-lg-4 col-md-6 col-sm-12 d-flex">
        <div class="card species-card shadow-sm w-100">
          <img src="../uploads/<?= $data['file']; ?>" class="card-img-top" alt="Species Image">
          <div class="card-body">
            <h5 class="card-title"><?= ucfirst($data['name']); ?></h5>

            <div class="species-info mb-3">
              <p><strong>Type:</strong> <?= $data['type']; ?></p>
              <p><strong>Location:</strong> <?= $data['location']; ?></p>
              <p><strong>Real Name:</strong> <?= $data['real_name']; ?></p>
            </div>

            <p class="truncate-text"><strong>Description:</strong> <?= $data['description']; ?></p>
            <p class="truncate-text"><strong>Details:</strong> <?= $data['details']; ?></p>

            <!-- View More Button -->
            <button class="btn btn-link p-0 text-primary" data-bs-toggle="modal" data-bs-target="#modal<?= $data['species_id']; ?>">
              View More
            </button>

            <!-- Status Badge -->
            <p class="mt-2">
              <?php
              if ($data['status'] == 'approved') {
                echo "<span class='badge bg-success'>Approved ✅</span>";
              } elseif ($data['status'] == 'pending') {
                echo "<span class='badge bg-warning text-dark'>Pending</span>";
              } elseif ($data['status'] == 'rejected') {
                echo "<span class='badge bg-danger'>Rejected ❌</span>";
              }
              ?>
            </p>

            <!-- Delete Button -->
            <div class="mt-auto">
              <?php if ($data['status'] == 'pending' || $data['status'] == 'rejected') { ?>
                <a href="viewspecies.php?id=<?= $data['species_id']; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Are you sure you want to delete this species?');">
                  Delete
                </a>
              <?php } else { ?>
                <span class="text-muted">Not allowed</span>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal for Full Details -->
      <div class="modal fade" id="modal<?= $data['species_id']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><?= ucfirst($data['name']); ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <img src="../uploads/<?= $data['file']; ?>" class="img-fluid mb-3" style="max-height:300px; object-fit:cover;">
              <p><strong>Description:</strong> <?= $data['description']; ?></p>
              <p><strong>Details:</strong> <?= $data['details']; ?></p>
              <p><strong>Type:</strong> <?= $data['type']; ?></p>
              <p><strong>Location:</strong> <?= $data['location']; ?></p>
              <p><strong>Real Name:</strong> <?= $data['real_name']; ?></p>
              <p><strong>Status:</strong>
                <?php
                if ($data['status'] == 'approved') {
                  echo "<span class='badge bg-success'>Approved ✅</span>";
                } elseif ($data['status'] == 'pending') {
                  echo "<span class='badge bg-warning text-dark'>Pending</span>";
                } elseif ($data['status'] == 'rejected') {
                  echo "<span class='badge bg-danger'>Rejected ❌</span>";
                }
                ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
  <?php
  } else {
      echo "<h4 class='text-center text-muted'>No species found.</h4>";
  }

  include 'js.php';
  ?>
</div>
