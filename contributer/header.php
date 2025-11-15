<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Raretrack</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Quicksand:wght@600;700&display=swap" rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet" />
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
  </head>

  <body style="background:#E9F2EC;">
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
      <div class="spinner-border text-primary" style="width: 3rem; height: 3rem" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top py-lg-0 px-4 px-lg-5 wow fadeIn" data-wow-delay="0.1s" style="border-bottom:1px solid #D5E5DA;">
      <a href="index.php" class="navbar-brand p-0 d-flex align-items-center">
        <img class="img-fluid me-2" src="img/icon/icon-10.png" alt="Icon" style="height:32px;" />
        <h1 class="m-0" style="color:#2EB872;">Raretrack</h1>
      </a>
      <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse py-4 py-lg-0" id="navbarCollapse">
        <div class="navbar-nav ms-auto">
          <a href="index.php" class="nav-item nav-link active">Home</a>
          <!-- <a href="addspecies.php" class="nav-item nav-link">Add Species</a>
          <a href="viewspecies.php" class="nav-item nav-link">View Species</a> -->
          <a href="profile.php" class="nav-item nav-link">View Profile</a>
          <!-- <a href="addfeedback.php" class="nav-item nav-link">Feedback</a>
          <a href="addcomplaint.php" class="nav-item nav-link">Complaint</a> -->
        </div>
        <a href="../login.php" class="btn btn-primary btn-pill" style="background:#2EB872; border-color:#2EB872;">
          Logout <i class="fa fa-arrow-right ms-3"></i>
        </a>
      </div>
    </nav>
    <!-- Navbar End -->
