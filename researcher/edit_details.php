<?php
session_start();
include 'header.php';
include '../connection.php';

// Validate ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request.");
}
$id = intval($_GET['id']);

// Fetch existing species details
$query = "SELECT * FROM species WHERE id = '$id'";
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) == 0) {
    die("Species not found.");
}
$data = mysqli_fetch_assoc($result);

// Handle form submission
if (isset($_POST['update'])) {
    $species_name = mysqli_real_escape_string($con, $_POST['species_name']);
    $type         = mysqli_real_escape_string($con, $_POST['type']);
    $location     = mysqli_real_escape_string($con, $_POST['location']);
    $description  = mysqli_real_escape_string($con, $_POST['description']);
    $real_name    = mysqli_real_escape_string($con, $_POST['real_name']);
    $details      = mysqli_real_escape_string($con, $_POST['details']);

    $update_query = "UPDATE species SET 
        name='$species_name', 
        type='$type', 
        location='$location', 
        description='$description', 
        real_name='$real_name', 
        details='$details'
        WHERE id='$id'";

    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Details updated successfully!'); window.location='verifyspecies.php';</script>";
    } else {
        echo "<script>alert('Failed to update details.');</script>";
    }
}
?>

<style>
  /* Auth-like card look */
  body{ background:#E9F2EC; }
  .auth-wrap{ min-height: calc(100vh - 180px); display:flex; align-items:center; }
  .auth-card{
    border:1px solid #D5E5DA; border-radius:16px; background:#F6FBF8;
    box-shadow:0 12px 30px rgba(0,0,0,.08);
  }
  .auth-header{
    background: linear-gradient(90deg, #2EB872, #25935b);
    color:#fff; border-top-left-radius:16px; border-top-right-radius:16px;
  }
  .auth-title{ font-weight:700; letter-spacing:.2px; margin:0; }

  .form-label{ font-weight:600; color:#282F34; }
  .form-control{
    border-radius:12px; border:1px solid #D5E5DA; background:#fff;
  }
  .form-control:focus{
    border-color:#2EB872; box-shadow:0 0 0 .2rem rgba(46,184,114,.15);
  }
  .img-thumbnail{ border-radius:12px; border:1px solid #D5E5DA; }

  .btn-primary{ background:#2EB872; border-color:#2EB872; border-radius:999px; padding:.6rem 1rem; font-weight:600; }
  .btn-primary:hover{ background:#25935b; border-color:#25935b; }
</style>

<br><br>

<div class="container auth-wrap">
  <div class="row justify-content-center w-100">
    <div class="col-md-8 col-lg-6">
      <div class="card auth-card shadow p-0">

        <div class="auth-header text-center py-3">
          <h4 class="auth-title">Edit Species Details</h4>
        </div>

        <div class="card-body p-4">
          <form method="POST" class="border-0 p-0">

            <div class="mb-3">
              <label class="form-label">Species Name</label>
              <input type="text" name="species_name" class="form-control" value="<?php echo htmlspecialchars($data['name']); ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Type</label>
              <input type="text" name="type" class="form-control" value="<?php echo htmlspecialchars($data['type']); ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Location</label>
              <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($data['location']); ?>" readonly required>
            </div>

            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($data['description']); ?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Real Name</label>
              <input type="text" name="real_name" class="form-control" value="<?php echo htmlspecialchars($data['real_name']); ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Details</label>
              <textarea name="details" class="form-control" rows="3"><?php echo htmlspecialchars($data['details']); ?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Current Image</label><br>
              <img src="../uploads/<?php echo htmlspecialchars($data['file']); ?>" width="120" height="120" class="img-thumbnail mb-2" alt="Current image">
            </div>

            <button type="submit" name="update" class="btn btn-primary w-100">Update Details</button>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>

<?php include 'js.php'; ?>
