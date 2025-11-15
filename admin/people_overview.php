<?php
session_start();
include 'header.php';
include '../connection.php';

/* Totals */
$total_contributors = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS c FROM signup"))['c'] ?? 0;
$total_researchers  = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS c FROM researcher"))['c'] ?? 0;

/* Contributors list (joined with login for status and id) */
$contributors = mysqli_query($con, "
  SELECT signup.*, login.user_status, login.id AS login_id
  FROM signup
  INNER JOIN login ON signup.login_id = login.id
  ORDER BY signup.name ASC
");

/* Researchers list (joined with login for status and id) */
$researchers = mysqli_query($con, "
  SELECT researcher.*, login.user_status, login.id AS login_id
  FROM researcher
  INNER JOIN login ON researcher.login_id = login.id
  ORDER BY researcher.name ASC
");
?>

<style>
  html, body{ height:100%; }
  body{ background:#E9F2EC; }

  .page-head{
    padding: 20px 0;
    border-bottom:1px solid #D5E5DA;
    margin-bottom:16px;
  }
  .page-title{
    font-size: 1.75rem; font-weight: 700; color:#282F34; letter-spacing:.2px; line-height:1.2; margin:0;
  }
  .page-sub{ color:#5B6B61; margin:0; }

  .kpi-card{
    background:#F6FBF8; border:1px solid #D5E5DA; border-radius:12px; padding:16px; text-align:center;
  }
  .kpi-number{ font-size:26px; font-weight:700; color:#282F34; margin:0; }
  .kpi-label{ color:#5B6B61; margin:0; }

  .table{ background:#F6FBF8; border:1px solid #D5E5DA; border-radius:16px; overflow:hidden; }
  .table thead.table-dark{ background:#2EB872 !important; border-color:#2EB872 !important; }
  .table thead.table-dark th{ color:#fff; letter-spacing:.2px; text-transform:uppercase; font-size:.9rem; }
  .table-striped>tbody>tr:nth-of-type(odd)>*{ --bs-table-accent-bg:#f1f7f3; }
  .table-hover tbody tr:hover{ background:#eef6f0; }
  .table-bordered>:not(caption)>*{ border-color:#D5E5DA; }

  .btn-sm{ border-radius:10px; font-weight:500; padding:.35rem .6rem; }
  .btn-success.btn-sm{ background:#2EB872; border-color:#2EB872; }
  .btn-success.btn-sm:hover{ background:#25935b; border-color:#25935b; }
  .btn-danger.btn-sm{ background:#E55353; border-color:#E55353; }
  .btn-danger.btn-sm:hover{ background:#cc4646; border-color:#cc4646; }

  .section-title{ color:#282F34; font-weight:700; margin: 16px 0; }
</style>

<div class="container py-4" style="background:#E9F2EC;">

  <!-- Heading -->
  <div class="page-head">
    <h1 class="page-title">People Overview</h1>
    <p class="page-sub">All contributors and researchers in one place</p>
  </div>

  <!-- Totals -->
  <div class="row g-3 mb-3">
    <div class="col-12 col-md-6">
      <div class="kpi-card">
        <p class="kpi-number"><?= $total_contributors ?></p>
        <p class="kpi-label">Total Contributors</p>
      </div>
    </div>
    <div class="col-12 col-md-6">
      <div class="kpi-card">
        <p class="kpi-number"><?= $total_researchers ?></p>
        <p class="kpi-label">Total Researchers</p>
      </div>
    </div>
  </div>

  <!-- Contributors table -->
  <h5 class="section-title">Contributors</h5>
  <div class="table-responsive mb-4">
    <table class="table table-bordered table-striped table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Address</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if($contributors && mysqli_num_rows($contributors)>0){ ?>
          <?php while($u = mysqli_fetch_assoc($contributors)){ ?>
            <tr>
              <td><?= htmlspecialchars($u['name']); ?></td>
              <td><?= htmlspecialchars($u['email']); ?></td>
              <td><?= htmlspecialchars($u['phone']); ?></td>
              <td><?= htmlspecialchars($u['address']); ?></td>
              <td>
                <?php
                  if ($u['user_status'] == 'approved') echo "<span class='text-success'>Verified</span>";
                  elseif ($u['user_status'] == 'pending') echo "<span class='text-warning'>Pending review</span>";
                  elseif ($u['user_status'] == 'rejected') echo "<span class='text-danger'>Revoked</span>";
                ?>
              </td>
          <?php } ?>
        <?php } else { ?>
          <tr><td colspan="6" class="text-muted">No contributors found.</td></tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <!-- Researchers table -->
  <h5 class="section-title">Researchers</h5>
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Address</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if($researchers && mysqli_num_rows($researchers)>0){ ?>
          <?php while($r = mysqli_fetch_assoc($researchers)){ ?>
            <tr>
              <td><?= htmlspecialchars($r['name']); ?></td>
              <td><?= htmlspecialchars($r['email']); ?></td>
              <td><?= htmlspecialchars($r['phone']); ?></td>
              <td><?= htmlspecialchars($r['address']); ?></td>
              <td>
                <?php
                  if ($r['user_status'] == 'approved') echo "<span class='text-success'>Verified</span>";
                  elseif ($r['user_status'] == 'pending') echo "<span class='text-warning'>Pending review</span>";
                  elseif ($r['user_status'] == 'rejected') echo "<span class='text-danger'>Revoked</span>";
                ?>
              </td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr><td colspan="6" class="text-muted">No researchers found.</td></tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

</div>

<?php include 'js.php'; ?>
