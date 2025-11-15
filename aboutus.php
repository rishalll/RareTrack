<?php include 'header.php'; ?>

<style>
  /* Use signup page color tokens */
  :root{
    --rt-surface: #F6FBF8;  /* card surface */
    --rt-bg:       #E9F2EC;  /* page background */
    --rt-border:   #D5E5DA;  /* subtle border */
    --primary:     #2EB872;
    --dark:        #2A2E2B;
  }

  *, *::before, *::after { box-sizing: border-box; }

  body {
    background: var(--rt-bg);
    color: var(--dark);
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    line-height: 1.5;
  }

  .section {
    padding: 60px 0;
    border-bottom: 1px solid var(--rt-border);
  }

  /* HERO */
  .hero {
    background: var(--rt-surface);
    padding: 60px 0;
    text-align: center;
    border-bottom: 1px solid var(--rt-border);
  }
  @media (min-width: 768px) {
    .hero { padding: 80px 0; }
  }

  .hero h1 {
    font-size: 1.85rem;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: .6rem;
  }

  .hero p {
    color: #5B6B61;
    max-width: 720px;
    margin: 0 auto 20px;
    font-size: 1rem;
  }

  /* Buttons */
  .btn-accent {
    background: var(--primary);
    color: #fff;
    border-radius: 999px;
    padding: 10px 18px;
    border: none;
    display: inline-block;
  }
  .btn-accent:hover { background: #25935b; }

  .btn-outline-accent {
    border: 1px solid var(--primary);
    color: var(--primary);
    border-radius: 999px;
    padding: 10px 18px;
    background: transparent;
    display: inline-block;
  }
  .btn-outline-accent:hover {
    background: rgba(46,184,114,.10);
  }

  /* TILE */
  .tile {
    background: var(--rt-surface);
    border: 1px solid var(--rt-border);
    border-radius: 12px;
    padding: 22px;
    text-align: center;
    transition: transform .22s ease, border-color .22s ease, box-shadow .22s ease;
  }
  .tile:hover {
    border-color: var(--primary);
    transform: translateY(-6px);
    box-shadow: 0 10px 30px rgba(46,184,114,0.12);
  }

  .avatar {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    border: 2px solid var(--primary);
    object-fit: cover;
    margin-bottom: 6px;
  }

  h2 {
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 12px;
  }

  .muted {
    color: #5B6B61;
  }

  .tile h6 {
    margin: .4rem 0 0;
    color: var(--dark);
    font-weight: 600;
  }

  /* CTA tile */
  .cta-tile {
    display: flex;
    gap: 12px;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    background: var(--rt-surface);
    border: 1px solid var(--rt-border);
    border-radius: 12px;
    padding: 22px;
  }

  .cta-actions { display:flex; gap:12px; align-items:center; }
  .gap-2 { gap: .5rem; }
  .d-flex { display:flex; }
  .justify-content-center { justify-content:center; }
  .flex-wrap { flex-wrap:wrap; }
  .text-center { text-align:center; }

  /* focus states */
  .btn-accent:focus, .btn-outline-accent:focus {
    outline: 3px solid rgba(46,184,114,0.28);
    outline-offset: 3px;
  }
</style>


<!-- Hero -->
<section class="hero">
  <div class="container">
    <h1>Co-Creators of Raretrack</h1>
    <p>Raretrack is a collaborative mini-project built together by three classmates. Every screen, query, and pixel was a shared effort.</p>
    <div class="d-flex justify-content-center gap-2 flex-wrap mt-3">
      <a href="index.php" class="btn-outline-accent">About the mission</a>
      <a href="#" class="btn-accent">Contact team</a>
    </div>
  </div>
</section>

<!-- Team -->
<section class="section">
  <div class="container text-center">
    <h2>Our Team</h2>
    <p class="muted mb-4">We designed, built, and refined Raretrack together—pair-programming and reviewing as one team.</p>

    <div class="row g-3">
      <div class="col-md-4">
        <div class="tile">
          <img src="img/team-rishal.jpg" class="avatar" alt="Rishal" ">
          <h6>Rishal</h6>
          <small class="muted">Co-Creator</small>
        </div>
      </div>
      <div class="col-md-4">
        <div class="tile">
          <img src="img/team-nihal.jpg" class="avatar" alt="Nihal" ">
          <h6>Nihal</h6>
          <small class="muted">Co-Creator</small>
        </div>
      </div>
      <div class="col-md-4">
        <div class="tile">
          <img src="img/team-lizan.jpg" class="avatar" alt="Lizan"">
          <h6>Lizan</h6>
          <small class="muted">Co-Creator</small>
        </div>
      </div>
    </div>

    <small class="muted d-block mt-3">Built together at Marian Academy of Management • BCA (AI) Mini Project</small>
  </div>
</section>

<!-- Values -->
<section class="section">
  <div class="container text-center">
    <h2>What We Believe</h2>
    <div class="row g-3">
      <div class="col-md-4">
        <div class="tile">
          <h6>Build for Impact</h6>
          <p class="muted">Features should help protect species and support research.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="tile">
          <h6>Keep it Simple</h6>
          <p class="muted">Clean UI and easy-to-read code for others to extend.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="tile">
          <h6>Open Collaboration</h6>
          <p class="muted">We pair-program, review together, and share credit equally.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section">
  <div class="container">
    <div class="tile cta-tile">
      <div>
        <h4 style="color: black; margin:0 0 6px;">Want to collaborate or learn more?</h4>
        <p class="muted" style="margin:0 0 6px;">We’re happy to share our approach and help others build conservation tools.</p>
      </div>
      <div class="cta-actions">
        <a href="index.php" class="btn-accent" style="text-decoration:none;">Reach out</a>
        <a href="index.php" class="btn-outline-accent" style="text-decoration:none;">Explore Raretrack</a>
      </div>
    </div>
  </div>
</section>

<?php include 'js.php'; ?>
