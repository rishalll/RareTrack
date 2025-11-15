<?php
session_start();
include 'header.php';
include '../connection.php';
?>

<style>
    .species-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .species-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .species-card img {
        height: 200px;
        object-fit: cover;
    }
    .species-card .card-body {
        background: #fff;
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .species-card .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
    }
    .species-info p {
        margin-bottom: 6px;
        font-size: 0.9rem;
        color: #555;
    }
    .truncate-text {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .badge {
        font-size: 0.85rem;
        padding: 6px 10px;
        border-radius: 8px;
    }
    .btn-sm {
        border-radius: 6px;
    }
</style>

<div class="container" style="margin-top: 150px;">
    <h2 class="text-center mb-4 fw-bold">Species List</h2>

    <?php
$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

$str = "SELECT species.name AS species_name, species.id, species.type, species.location, species.description, species.file, species.status,
        species.real_name, species.details, signup.name AS contributor_name, signup.email, signup.login_id 
        FROM species 
        JOIN signup ON species.login_id = signup.login_id 
        JOIN login ON signup.login_id = login.id";

if (!empty($searchTerm)) {
    $str .= " WHERE species.name LIKE '%$searchTerm%'";
}
$str .= " ORDER BY 
CASE species.status
    WHEN 'pending' THEN 0
    WHEN 'approved' THEN 1
    WHEN 'rejected' THEN 2
    ELSE 3
    END,
    species.id DESC";

    $result = mysqli_query($con, $str);

    if (mysqli_num_rows($result) > 0) {
    ?>
    <form method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search by species name..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
</form>

    <div class="row g-4">
        <?php while ($data = mysqli_fetch_array($result)) { ?>
            <div class="col-lg-4 col-md-6 col-sm-12 d-flex">
                <div class="card species-card shadow-sm w-100">
                    <img src="../uploads/<?php echo $data['file']; ?>" class="card-img-top" alt="Species Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo ucfirst($data['species_name']); ?></h5>
                        
                        <div class="species-info mb-3">
                            <p><strong>Contributor:</strong> <?php echo $data['contributor_name']; ?></p>
                            <p><strong>Email:</strong> <?php echo $data['email']; ?></p>
                            <p><strong>Type:</strong> <?php echo $data['type']; ?></p>
                            <p><strong>Location:</strong> <?php echo $data['location']; ?></p>
                            <p><strong>Real Name:</strong> <?php echo $data['real_name']; ?></p>
                        </div>

                        <p class="truncate-text"><strong>Description:</strong> <?php echo $data['description']; ?></p>
                        <p class="truncate-text"><strong>Details:</strong> <?php echo $data['details']; ?></p>

                        <!-- Read More Button -->
                        <button class="btn btn-link p-0 text-primary" data-bs-toggle="modal" data-bs-target="#modal<?php echo $data['id']; ?>">
                            Read More
                        </button>

                        <div class="mt-auto">
                            <p class="mb-2">
                                <?php
                                if ($data['status'] == 'approved') {
                                    echo "<span class='badge bg-success'>Approved ✅</span>";
                                    
                                } elseif ($data['status'] == 'pending') {
                                    echo "<span class='badge bg-warning text-dark'>Pending</span>";
                                } elseif ($data['status'] == 'rejected') {
                                    echo "<span class='badge bg-danger'>Rejected ❌</span>";
                                }
                                ?>
                            </p>

                            <div class="d-flex flex-wrap gap-2">
                                <?php if ($data['status'] == 'pending') { ?>
                                    <a href="approvespecies.php?id=<?php echo $data['id']?>" class="btn btn-success btn-sm">Approve</a>
                                    <a href="rejectspecies.php?id=<?php echo $data['id']?>" class="btn btn-danger btn-sm">Reject</a>
                                <?php } elseif ($data['status'] == 'approved') { ?>
                                    <a href="edit_details.php?id=<?php echo $data['id']?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="report.php?id=<?php echo $data['id']?>" class="btn btn-warning btn-sm">Report</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Full Details -->
            <div class="modal fade" id="modal<?php echo $data['id']; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><?php echo ucfirst($data['species_name']); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <img src="../uploads/<?php echo $data['file']; ?>" class="img-fluid mb-3" style="max-height:300px; object-fit:cover;">
                            <p><strong>Description:</strong> <?php echo $data['description']; ?></p>
                            <p><strong>Details:</strong> <?php echo $data['details']; ?></p>
                            <p><strong>Contributor:</strong> <?php echo $data['contributor_name']; ?> (<?php echo $data['phone']; ?>)</p>
                            <p><strong>Type:</strong> <?php echo $data['type']; ?></p>
                            <p><strong>Location:</strong> <?php echo $data['location']; ?></p>
                            <p><strong>Real Name:</strong> <?php echo $data['real_name']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php
    } else {
        echo "<h4 class='text-center text-muted'>No species found.</h4>";
    }

    include 'js.php';
    ?>
</div>
