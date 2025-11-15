<?php
session_start();
include 'header.php';
include '../connection.php';
?>

<style>
  html, body{ height:100%; }
  body{ background:#E9F2EC; }

  .page-head{
    padding-top: 1.25rem; padding-bottom: 1.25rem;
    border-bottom: 1px solid #D5E5DA; margin-bottom: 1.25rem;
  }
  .page-title{ font-size: 1.75rem; font-weight:700; color:#282F34; letter-spacing:.2px; line-height:1.2; }
  .page-sub{ color:#5B6B61; font-size:.95rem; }

  .table{ background:#F6FBF8; border:1px solid #D5E5DA; border-radius:16px; overflow:hidden; }
  .table thead.table-dark{ background:#2EB872 !important; border-color:#2EB872 !important; }
  .table thead.table-dark th{ color:#fff; letter-spacing:.2px; text-transform:uppercase; font-size:.9rem; }
  .table-striped>tbody>tr:nth-of-type(odd)>*{ --bs-table-accent-bg:#f1f7f3; }
  .table-hover tbody tr:hover{ background:#eef6f0; }
  .table-bordered>:not(caption)>*{ border-color:#D5E5DA; }

  .btn-sm{ border-radius:10px; font-weight:500; padding:.4rem .65rem; }
  .btn-success.btn-sm{ background:#2EB872; border-color:#2EB872; }
  .btn-success.btn-sm:hover{ background:#25935b; border-color:#25935b; }
  .btn-danger.btn-sm{ background:#E55353; border-color:#E55353; }
  .btn-danger.btn-sm:hover{ background:#cc4646; border-color:#cc4646; }
</style>

<div class="container py-5" style="background:#E9F2EC;">
  <div class="page-head container">
    <div class="row align-items-center g-3">
      <div class="col">
        <h1 class="page-title m-0">Verify Contributor</h1>
        <p class="page-sub m-0">Approve access by verifying, or revoke when needed</p>
      </div>
      <div class="col-auto">
        <!-- Optional filters -->
        <!-- <a href="?status=pending" class="btn btn-success btn-sm rounded-pill">Pending Only</a> -->
      </div>
    </div>
  </div>

  <?php
  $str = "SELECT signup.*, login.user_status, login.id AS login_id
          FROM signup
          INNER JOIN login ON signup.login_id = login.id";
  $result = mysqli_query($con, $str);

  if (mysqli_num_rows($result) > 0) {
  ?>
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Address</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($data = mysqli_fetch_array($result)) { ?>
        <tr>
          <td><?= htmlspecialchars($data['name']); ?></td>
          <td><?= htmlspecialchars($data['email']); ?></td>
          <td><?= htmlspecialchars($data['phone']); ?></td>
          <td><?= htmlspecialchars($data['address']); ?></td>
          <td>
            <?php
            if ($data['user_status'] == 'approved') {
              echo "<span class='text-success'>Verified</span>";
            } elseif ($data['user_status'] == 'pending') {
              echo "<span class='text-warning'>Pending review</span>";
            } elseif ($data['user_status'] == 'rejected') {
              echo "<span class='text-danger'>Revoked</span>";
            }
            ?>
          </td>
          <td>
            <?php if ($data['user_status'] == 'approved') { ?>
              <a href="reject.php?id=<?= $data['login_id']; ?>" class="btn btn-danger btn-sm">Revoke</a>
            <?php } elseif ($data['user_status'] == 'pending') { ?>
              <a href="approved.php?id=<?= $data['login_id']; ?>" class="btn btn-success btn-sm mb-1">Verify</a>
              <a href="reject.php?id=<?= $data['login_id']; ?>" class="btn btn-danger btn-sm">Revoke</a>
            <?php } elseif ($data['user_status'] == 'rejected') { ?>
              <a href="approved.php?id=<?= $data['login_id']; ?>" class="btn btn-success btn-sm">Verify</a>
            <?php } ?>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <?php
  } else {
    echo "<h4 class='text-center text-muted'>No contributors found.</h4>";
  }

  include 'js.php';
  ?>
</div>
