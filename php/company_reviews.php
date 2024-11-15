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

    <style>
        /* Custom CSS */
        .review-card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .review-card .rating-badge {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .review-card .comment-text {
            font-size: 1rem;
            color: #555;
        }

        .review-card .review-footer {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .anonymous {
            font-weight: bold;
            color: #888;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .review-footer .anonymous-wrapper {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Company Reviews</h2>
        
        <?php if (mysqli_num_rows($reviews_result) > 0): ?>
            <div class="list-group">
                <?php while ($review = mysqli_fetch_assoc($reviews_result)): ?>
                    <div class="card mb-4 review-card">
                        <div class="card-body">
                            <h5 class="card-title">Rating: 
                                <span class="badge rating-badge"><?php echo htmlspecialchars($review['rating']); ?></span>
                            </h5>
                            <p class="card-text comment-text"><?php echo htmlspecialchars($review['commentDescription']); ?></p>
                            <div class="review-footer">
                                <small class="text-muted">
                                    Submitted on <?php echo date('Y-m-d H:i', strtotime($review['created_at'])); ?>
                                    <span class="anonymous-wrapper">
                                        <!-- Avatar -->
                                        <img src="https://www.w3schools.com/w3images/avatar2.png" class="avatar" alt="Anonymous Avatar">
                                        <!-- Anonymous Label -->
                                        <span class="anonymous">- Submitted by <?php echo 'Anonymous ' . rand(1000, 9999); ?></span>
                                    </span>
                                </small>
                            </div>
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
