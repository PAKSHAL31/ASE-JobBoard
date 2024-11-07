<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    header("location: ../index.php");
}
include '_dbconnect.php';

$company_no = $_SESSION['sess_id']; // Assuming company ID is stored in the session

// Fetch reviews for the logged-in company
$reviews_sql = "SELECT cr.rating, cr.commentDescription, cr.created_at, c.company_name
                FROM `company_reviews` cr
                JOIN `company` c ON cr.company_no = c.company_no
                WHERE cr.company_no = '$company_no' ORDER BY cr.created_at DESC";
$reviews_result = mysqli_query($conn, $reviews_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Reviews</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Company Reviews</h2>
        
        <?php if (mysqli_num_rows($reviews_result) > 0): ?>
            <div class="list-group">
                <?php while ($review = mysqli_fetch_assoc($reviews_result)): ?>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Rating: 
                                <span class="badge badge-primary"><?php echo htmlspecialchars($review['rating']); ?></span>
                            </h5>
                            <p class="card-text"><?php echo htmlspecialchars($review['commentDescription']); ?></p>
                            <small class="text-muted">
                                Submitted on <?php echo date('Y-m-d H:i', strtotime($review['created_at'])); ?>
                            </small>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">No reviews available.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
