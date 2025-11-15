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
    padding-top: 1.25rem; padding-bottom: 1.25rem;
    border-bottom: 1px solid #D5E5DA; margin-bottom: 1.25rem;
  }
  .page-title{ font-size: 1.75rem; font-weight: 700; color:#282F34; letter-spacing:.2px; line-height:1.2; }
  .page-sub{ color:#5B6B61; font-size:.95rem; }

  /* Table polish consistent with admin */
  .table{ background:#F6FBF8; border:1px solid #D5E5DA; border-radius:16px; overflow:hidden; }
  .table thead.table-dark{ background:#2EB872 !important; border-color:#2EB872 !important; }
  .table thead.table-dark th{ color:#fff; letter-spacing:.2px; text-transform:uppercase; font-size:.9rem; }
  .table-striped>tbody>tr:nth-of-type(odd)>*{ --bs-table-accent-bg:#f1f7f3; }
  .table-hover tbody tr:hover{ background:#eef6f0; }
  .table-bordered>:not(caption)>*{ border-color:#D5E5DA; }
</style>

<div class="container py-5" style="background:#E9F2EC;">

  <!-- Professional heading -->
  <div class="page-head container">
    <div class="row align-items-center g-3">
      <div class="col">
        <h1 class="page-title m-0">Feedbacks</h1>
        <p class="page-sub m-0">User feedback submitted from the app</p>
      </div>
      <div class="col-auto">
        <!-- Optional action: export or filters -->
        <!-- <a href="export_feedback.php" class="btn btn-success btn-sm rounded-pill">Export CSV</a> -->
      </div>
    </div>
  </div>

  <?php
  $str = "SELECT feedback.*, signup.name FROM feedback
          INNER JOIN signup ON feedback.contributor_id = signup.login_id";
  $result = mysqli_query($con, $str);

  if (mysqli_num_rows($result) > 0) {
  ?>
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>Contributor</th>
          <th>Subject</th>
          <th>Feedback</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($data = mysqli_fetch_array($result)) { ?>
        <tr>
          <td><?= htmlspecialchars($data['name']); ?></td>
          <td><?= htmlspecialchars($data['subject']); ?></td>
          <td style="text-align:left;"><?= nl2br(htmlspecialchars($data['feedback'])); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <?php
  } else {
    echo "<h4 class='text-center text-muted'>No feedbacks found.</h4>";
  }

  include 'js.php';
  ?>
</div>
