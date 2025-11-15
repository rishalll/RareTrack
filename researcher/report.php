<?php
include 'header.php';
$species_id = $_GET['id'];
?>
<body style="background-color: #f8f9fa; height: 100vh;">

<div style="height: 100vh; display: flex; justify-content: center; align-items: center; padding: 1rem;">
    <div class="card shadow-sm" style="width: 100%; max-width: 500px; padding: 2rem;">
    <h3 class="text-center" style="margin-bottom: 1.5rem;">REPORT</h3>
    <form method="post" action="report_action.php">
        <input type="hidden" name="species_id" value="<?php echo htmlspecialchars($species_id); ?>">
        <div class="mb-3">
        <label for="details" class="form-label">Comment</label>
        <textarea class="form-control" id="details" name="comment" placeholder="Comment" required></textarea>
        </div>

        <div class="d-grid gap-2">
        <button type="submit" class="btn btn-success">Submit</button>
        </div>
        </form>
    </div>
</div>

<?php
include 'footer.php';  
?>
