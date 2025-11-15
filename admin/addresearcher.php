<?php
include 'header.php';
?>
<body style="background:#E9F2EC; min-height:100vh;">

  <div style="min-height:100vh; display:flex; justify-content:center; align-items:center; padding:1rem;">
    <div class="card shadow-sm"
         style="width:100%; max-width:500px; padding:2rem; background:#F6FBF8; border:1px solid #D5E5DA; border-radius:16px; box-shadow:0 12px 30px rgba(0,0,0,.06);">
      <h3 class="text-center" style="margin-bottom:.75rem; color:#282F34; letter-spacing:.2px;">Add Researcher</h3>
      <p class="text-center" style="margin-top:-.25rem; margin-bottom:1.25rem; color:#5B6B61; font-size:.95rem;">
        Create a new researcher account
      </p>

      <form method="post" action="addresearcher_action.php">
        <!-- Full Name -->
        <div class="mb-3">
          <label for="name" class="form-label" style="color:#5B6B61; letter-spacing:.1px;">Full Name</label>
          <input type="text" class="form-control" id="name" name="name"
                 placeholder="Enter full name"
                 pattern="^[A-Za-z\s]{3,50}$"
                 title="Name should contain only letters and spaces (3–50 characters)"
                 required
                 style="background:#fff; border-color:#D5E5DA; color:#282F34; padding:.78rem .95rem;">
        </div>

        <!-- Email -->
        <div class="mb-3">
          <label for="email" class="form-label" style="color:#5B6B61; letter-spacing:.1px;">Email Address</label>
          <input type="email" class="form-control" id="email" name="email"
                 placeholder="Enter email"
                 pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                 title="Enter a valid email address (example: user@example.com)"
                 required
                 style="background:#fff; border-color:#D5E5DA; color:#282F34; padding:.78rem .95rem;">
        </div>

        <!-- Phone -->
        <div class="mb-3">
          <label for="phone" class="form-label" style="color:#5B6B61; letter-spacing:.1px;">Phone Number</label>
          <input type="tel" class="form-control" id="phone" name="phone"
                 placeholder="Enter phone number"
                 pattern="^[6-9][0-9]{9}$"
                 title="Phone number must start with 6-9 and be exactly 10 digits"
                 maxlength="10"
                 required
                 style="background:#fff; border-color:#D5E5DA; color:#282F34; padding:.78rem .95rem;">
        </div>

        <!-- Address -->
        <div class="mb-3">
          <label for="address" class="form-label" style="color:#5B6B61; letter-spacing:.1px;">Address</label>
          <input type="text" class="form-control" id="address" name="address"
                 placeholder="Enter address" required
                 style="background:#fff; border-color:#D5E5DA; color:#282F34; padding:.78rem .95rem;">
        </div>

        <!-- Username -->
        <div class="mb-3">
          <label for="username" class="form-label" style="color:#5B6B61; letter-spacing:.1px;">Username</label>
          <input type="text" class="form-control" id="username" name="username"
                 placeholder="Choose a username"
                 pattern="^[A-Za-z0-9_]{5,15}$"
                 title="Username must be 5–15 characters long (letters, numbers, underscores)"
                 required
                 style="background:#fff; border-color:#D5E5DA; color:#282F34; padding:.78rem .95rem;">
        </div>

        <!-- Password -->
        <div class="mb-3">
          <label for="password" class="form-label" style="color:#5B6B61; letter-spacing:.1px;">Password</label>
          <input type="password" class="form-control" id="password" name="password"
                 placeholder="Create a password"
                 pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,20}$"
                 title="Password must be 6–20 characters and include at least one letter and one number"
                 required
                 style="background:#fff; border-color:#D5E5DA; color:#282F34; padding:.78rem .95rem;">
        </div>

        <!-- Submit -->
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-success rounded-pill"
                  style="background:#2EB872; border-color:#2EB872; min-height:48px; padding:.95rem 1.25rem; letter-spacing:.3px;">
            Add Now
          </button>
        </div>
      </form>
    </div>
  </div>

<?php
include 'js.php';
?>
