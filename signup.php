<?php include 'header.php'; ?>
<body>

<style>
  /* Use existing template tokens from style.css */
  :root{
    --rt-surface: #F6FBF8;  /* card surface */
    --rt-bg:       #E9F2EC;  /* page background */
    --rt-border:   #D5E5DA;  /* subtle border */
  }

  body{ background: var(--rt-bg); min-height: 100vh; }

  .auth-shell{
    min-height: 100vh;
    display: grid;
    place-items: center;
    padding: 32px 16px;
  }
  .auth-card{
    background: var(--rt-surface);
    border: 1px solid var(--rt-border);
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(0,0,0,.06);
    width: 100%;
    max-width: 520px;
  }

  .heading{ color: var(--dark); letter-spacing: .2px; line-height: 1.25; }
  .subheading{ color: #5B6B61; letter-spacing: .2px; }
  .form-label{ color: #5B6B61; letter-spacing: .1px; margin-bottom: .35rem; }
  .help-text{ color: #5B6B61; font-size: .875rem; letter-spacing: .1px; }
  .stack-6 > * + *{ margin-top: 1.25rem; } /* slightly denser for longer form */

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

  .btn-rt{
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
    border-radius: 999px;
    padding: .95rem 1.25rem;
    min-height: 48px;
    letter-spacing: .3px;
  }
  .btn-rt:hover{ background: #25935b; border-color: #25935b; }

  textarea.form-control{ min-height: 96px; resize: vertical; }
</style>

<div class="auth-shell">
  <div class="auth-card p-4 p-md-5">
    <div class="text-center mb-3">
      <h3 class="heading fw-semibold m-0">Create your account</h3>
      <small class="subheading">Join <span style="color:var(--primary)">RareTrack</span></small>
    </div>

    <form method="post" action="signup_action.php"  class="stack-6">
      <!-- Full Name -->
      <div>
        <label for="name" class="form-label">Full name</label>
        <input
          type="text"
          class="form-control"
          id="name"
          name="name"
          placeholder="Enter your full name"
          pattern="^[A-Za-z\s]{3,50}$"
          title="Name should only contain letters and spaces (3–50 characters)"
          required>
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="form-label">Email address</label>
        <input
          type="email"
          class="form-control"
          id="email"
          name="email"
          placeholder="name@example.com"
          pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
          title="Enter a valid email address (example: user@example.com)"
          autocomplete="email"
          required>
      </div>

      <!-- Phone -->
      <div>
        <label for="phone" class="form-label">Phone number</label>
        <input
          type="tel"
          class="form-control"
          id="phone"
          name="phone"
          placeholder="10-digit mobile number"
          pattern="^[6-9][0-9]{9}$"
          title="Phone number must start with 6–9 and be exactly 10 digits"
          maxlength="10"
          inputmode="numeric"
          required>
      </div>

      <!-- Address -->
      <div>
        <label for="address" class="form-label">Address</label>
        <textarea
          class="form-control"
          id="address"
          name="address"
          placeholder="Enter your address"
          required></textarea>
      </div>

      <!-- Username -->
      <div>
        <label for="username" class="form-label">Username</label>
        <input
          type="text"
          class="form-control"
          id="username"
          name="username"
          placeholder="Choose a username"
          pattern="^[A-Za-z0-9_]{5,15}$"
          title="Username should be 5–15 characters (letters, numbers, underscores)"
          autocomplete="username"
          required>
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          class="form-control"
          id="password"
          name="password"
          placeholder="Create a password"
          pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,20}$"
          title="Password must be 6–20 characters, include at least one letter and one number"
          autocomplete="new-password"
          required>
      </div>

      <!-- Submit -->
      <div class="d-grid">
        <button type="submit" class="btn btn-rt btn-lg w-100 rounded-pill">Sign Up</button>
      </div>

      <div class="text-center" style="margin-top: 1rem;">
        <span class="help-text">Already have an account?
          <a href="login.php" class="text-decoration-none" style="color:var(--primary)">Log in</a>
        </span>
      </div>
    </form>
  </div>
</div>

<?php include 'js.php'; ?>
