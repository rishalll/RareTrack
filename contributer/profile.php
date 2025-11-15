<?php
session_start();
$login_id = $_SESSION['id'];

include '../connection.php';
include 'header.php';

$query  = "SELECT name, email, phone, address, image FROM signup WHERE login_id = $login_id";
$result = mysqli_query($con, $query);
$user   = mysqli_fetch_assoc($result);
?>

<!-- Palette + component overrides -->
<style>
  html, body{ height:100%; }
  body{ background:#E9F2EC !important; }                 /* soft page bg */
  .profile-card{
    background:#F6FBF8; border:1px solid #D5E5DA;
    border-radius:20px; box-shadow:0 12px 30px rgba(0,0,0,.06);
  }
  .profile-img{ border:4px solid #fff; transition: transform .3s ease; }
  .profile-img:hover{ transform: scale(1.1); }

  /* Professional identity section */
  .profile-name{ color:#282F34; font-weight:700; letter-spacing:.2px; line-height:1.2; }
  .profile-subtle{ color:#5B6B61 !important; font-size:.95rem; }
  .meta-label{
    display:block; font-size:.75rem; color:#5B6B61;
    letter-spacing:.2px; text-transform:uppercase;
  }
  .meta-value{ display:block; color:#282F34; font-weight:600; letter-spacing:.2px; }
  @media (max-width:576px){ .meta-label,.meta-value{ text-align:center; } }

  /* Buttons */
  .btn-outline-primary{ border-color:#2EB872; color:#2EB872; }
  .btn-outline-primary:hover{ background:#e9f8f1; border-color:#25935b; color:#25935b; }
  .btn-success{ background:#2EB872; border-color:#2EB872; }
  .btn-success:hover{ background:#25935b; border-color:#25935b; }

  /* Generic hover lift */
  .btn:hover{ transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.15); }
</style>

<br><br><br>

<div class="container mt-5" style="background:#E9F2EC;">
  <div class="row justify-content-center py-4">
    <div class="col-md-8 col-lg-6">

      <div class="card profile-card shadow-lg border-0 rounded-3">
        <!-- Gradient Header -->
        <div class="card-header text-white text-center py-4"
             style="background: linear-gradient(90deg, #2EB872, #25935b);">
          <h3 class="mb-0">👋 Welcome, <strong><?php echo htmlspecialchars($user['name']); ?></strong>!</h3>
        </div>

        <div class="card-body text-center p-5">
          <!-- Profile Image -->
          <img src="../uploads/<?= $user['image']; ?>"
               class="rounded-circle shadow mb-3 profile-img"
               width="120" height="120" alt="User">

          <!-- Identity (professional layout) -->
          <div class="profile-identity text-center mb-3">
            <h3 class="profile-name m-0">
              <?php echo htmlspecialchars($user['name']); ?>
            </h3>
            <p class="profile-subtle m-0">🌱 Nature Explorer</p>
          </div>

          <!-- Quick facts row -->
          <div class="row justify-content-center g-3 mb-4">
            <div class="col-auto">
              <span class="meta-label">Email</span>
              <span class="meta-value"><?php echo htmlspecialchars($user['email']); ?></span>
            </div>
            <div class="col-auto">
              <span class="meta-label">Phone</span>
              <span class="meta-value"><?php echo htmlspecialchars($user['phone']); ?></span>
            </div>
            <div class="col-auto">
              <span class="meta-label">Address</span>
              <span class="meta-value"><?php echo htmlspecialchars($user['address']); ?></span>
            </div>
          </div>

          <!-- Buttons -->
          <div class="mt-2">
            <a href="edit_profile.php" class="btn btn-outline-primary me-2"
               style="border-radius:30px; padding:10px 18px;">
              ✏️ Edit Profile
            </a>
            <a href="achievements.php" class="btn btn-success"
               style="border-radius:30px; padding:10px 18px;">
              🏆 My Achievements
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<br><br>
<?php include 'js.php'; ?>
