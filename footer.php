<!-- Footer Start -->
<footer class="bg-dark text-light pt-5 pb-4">
  <div class="container">
    <div class="row gy-4">
      <!-- 1: Brand / Short about -->
      <div class="col-12 col-md-4">
        <a class="d-inline-block mb-2 text-decoration-none" href="#">
          <h4 class="text-light m-0">raretrack</h4>
        </a>
        <p class="small text-muted mb-2" style ="color: white;">
          RareTrack — documenting and conserving rare species through community contributions and research.
        </p>
        <p class="small mb-0">
          <i class="fa fa-map-marker-alt me-2"></i> 123 Street, New York, USA
        </p>
        <p class="small mb-0">
          <i class="fa fa-phone-alt me-2"></i> +012 345 67890
        </p>
        <p class="small">
          <i class="fa fa-envelope me-2"></i> info@example.com
        </p>
        <div class="mt-2">
          <a class="btn btn-outline-light btn-sm btn-social me-1" href="#" aria-label="Twitter">
            <i class="fab fa-twitter"></i>
          </a>
          <a class="btn btn-outline-light btn-sm btn-social me-1" href="#" aria-label="Facebook">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a class="btn btn-outline-light btn-sm btn-social me-1" href="#" aria-label="YouTube">
            <i class="fab fa-youtube"></i>
          </a>
          <a class="btn btn-outline-light btn-sm btn-social" href="#" aria-label="LinkedIn">
            <i class="fab fa-linkedin-in"></i>
          </a>
        </div>
      </div>

      <!-- 2: Quick Links -->
      <nav class="col-6 col-md-2">
        <h6 class="text-light">Quick Links</h6>
        <ul class="list-unstyled small mb-0">
          <li><a class="text-muted text-decoration-none" style="color: white; display: inline-block; margin:0 0 6px" href="aboutus.php">About</a></li>
          <li><a class="text-muted text-decoration-none" style="color: white; display: inline-block; margin:0 0 6px" href="signup.php">Contribute</a></li>

        </ul>
      </nav>

      <!-- 3 Subscribe / Signup -->
      <div class="col-12 col-md-4">
    <h6 class="text-light">Researcher Sign-Up</h6>
    <p class="small text-muted">
        Do you want to sign up as a <strong>researcher</strong>?  
        Please email our official team at:
    </p>

    <div class="bg-secondary text-light p-3 rounded d-flex align-items-center justify-content-between">
        <span class="small" id="official-email">raretrackofficial@gmail.com</span>
        <button class="btn btn-sm btn-outline-light ms-3" onclick="copyEmail()">
            Copy
        </button>
    </div>

    <small class="d-block text-muted mt-2">
        Our team typically responds within 24–48 hours.
    </small>
</div>

    </div>

    <hr class="border-secondary mt-4">

    <div class="row">
      <div class="col-md-6 text-center text-md-start small text-muted">
        &copy; <?php echo date('Y'); ?> <a href="#" class="text-decoration-none text-light">raretrack</a>. All rights reserved.
      </div>
      <div class="col-md-6 text-center text-md-end small text-muted">
        Built with ❤️ — <a href="#" class="text-decoration-none text-muted">Terms</a>
      </div>
    </div>
  </div>
</footer>

<style>
  /* Make all footer text readable on dark background */
  footer, 
  footer * {
      color: #ffffff !important;
  }
  /* Force white text inside the researcher email box */
footer .bg-secondary span,
footer .bg-secondary small,
footer .bg-secondary p {
    color: #ffffff !important;
}


  /* Fix border visibility */
  footer .border,
  footer .border-bottom,
  footer .border-top {
      border-color: rgba(255, 255, 255, 0.3) !important;
  }

  /* Fix buttons */
  footer .btn-social {
      width: 36px;
      height: 36px;
      padding: 0;
      display: inline-flex;
      justify-content: center;
      align-items: center;
  }

  footer .btn-link {
      color: #e6e6e6 !important;
      font-size: 14px;
      padding-left: 0;
  }
  footer .btn-link:hover {
      color: #9cf5c2 !important; /* light green hover */
  }
</style>
<script>
function copyEmail() {
    const email = "raretrackofficial@gmail.com";
    navigator.clipboard.writeText(email);
    alert("Email copied: " + email);
}
</script>

</script>
<!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
