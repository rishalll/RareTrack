<?php include 'header.php'; ?>
<body>

<style>
  /* Use template tokens from style.css */
  :root{
    --rt-surface: #F6FBF8;   /* soft card surface */
    --rt-bg:       #E9F2EC;   /* page background */
    --rt-border:   #D5E5DA;   /* subtle borders */
  }

  body{ background: var(--rt-bg); min-height: 100vh; }

  /* Layout */
  .login-shell{
    min-height: 100vh;
    display: grid;
    place-items: center;
    padding: 32px 16px;
  }
  .login-card{
    background: var(--rt-surface);
    border: 1px solid var(--rt-border);
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(0,0,0,.06);
    width: 100%;
    max-width: 440px;
  }

  /* Typography and spacing */
  .heading{ color: var(--dark); letter-spacing: .2px; line-height: 1.25; }
  .subheading{ color: #5B6B61; letter-spacing: .2px; }
  .form-label{ color: #5B6B61; letter-spacing: .1px; margin-bottom: .35rem; }
  .help-text{ color: #5B6B61; font-size: .875rem; letter-spacing: .1px; }
  .stack-6 > * + *{ margin-top: 1.5rem; } /* consistent vertical rhythm */

  /* Inputs */
  .form-control{
    background: #fff;
    border-color: var(--rt-border);
    color: var(--dark);
    padding: .78rem .95rem;
  }
  .form-control:focus{
    border-color: var(--primary);
    box-shadow: 0 0 0 .2rem rgba(46,184,114,.20);
  }

  /* Login button: pill, larger target */
  .btn-rt{
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
    border-radius: 999px;     /* pill */
    padding: .95rem 1.25rem;  /* height ≈ 48px with btn-lg */
    min-height: 48px;         /* meet touch target */
    letter-spacing: .3px;
  }
  .btn-rt:hover{ background: #25935b; border-color: #25935b; } /* uses your palette’s hover from style.css comments */
</style>

<!-- Login -->
<div class="login-shell">
  <div class="login-card p-4 p-md-5">
    <div class="text-center mb-3">
      <h3 class="heading fw-semibold m-0">Welcome back</h3>
      <small class="subheading">Log in to <span style="color:var(--primary)">RareTrack</span></small>
    </div>

    <form action="login_action.php" method="post" class="stack-6">
      <div>
        <label for="username" class="form-label">username</label>
        <input
          type="Username"
          class="form-control"
          id="username"
          name="username"
          placeholder="Enter your username"
          autocomplete="username"
          required>
      </div>

      <div>
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          class="form-control"
          id="password"
          name="password"
          placeholder="Password"
          autocomplete="current-password"
          required>
      </div>

      <div class="d-flex justify-content-between align-items-center">
        <div class="form-check m-0">
          <!-- <input class="form-check-input" type="checkbox" id="remember"> -->
          <!-- <label class="form-check-label help-text" for="remember">Remember me</label> -->
        </div>
        <a href="signup.php" class="text-decoration-none" style="color:var(--primary)">New To RareTrack?</a>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-rt btn-lg w-100 rounded-pill">Log In</button>
      </div>
    </form>
  </div>
</div>

<!-- Back to top (works with your main.js) -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

<?php include 'js.php'; ?>
