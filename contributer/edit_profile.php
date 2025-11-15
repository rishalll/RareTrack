<?php
session_start();
$login_id = $_SESSION['id'];

include '../connection.php';
include 'header.php';

$query = "SELECT name, email, phone, address, image FROM signup WHERE login_id = $login_id";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);
?>
<br><br>

<style>
  /* Auth-style background and centered card */
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
  .btn-success{ background:#2EB872; border-color:#2EB872; border-radius:999px; padding:.6rem 1rem; font-weight:600; }
  .btn-success:hover{ background:#25935b; border-color:#25935b; }
</style>

<div class="container auth-wrap">
  <div class="row justify-content-center w-100">
    <div class="col-md-7 col-lg-5">
      <div class="card auth-card shadow p-0">
        <div class="auth-header text-center py-3">
          <h4 class="auth-title">Edit Profile</h4>
        </div>

        <div class="card-body p-4">
          <form action="updateprofile.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Phone</label>
              <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Address</label>
              <textarea name="address" class="form-control" rows="3" required><?php echo htmlspecialchars($user['address']); ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Profile Picture</label>
              <input type="file" name="image" class="form-control" value="<?php echo htmlspecialchars($user['image']); ?>" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Update Profile</button>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>

<?php include 'js.php'; ?>
