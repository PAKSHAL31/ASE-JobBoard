<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] = false) {
    header("location: ../index.php");
}
include '_dbconnect.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $company_no = $_POST['company_no'];
    $rating = $_POST['rating'];
    $commentDescription = $_POST['commentDescription'];

    // Insert the review into the database
    $sql = "INSERT INTO `company_reviews` (`company_no`, `rating`, `commentDescription`) VALUES ('$company_no', '$rating', '$commentDescription')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Review submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error submitting review: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch companies for the dropdown
$companies_sql = "SELECT * FROM `company`";
$companies_result = mysqli_query($conn, $companies_sql);

// Fetch existing reviews for display
$reviews_sql = "SELECT cr.*, c.company_name FROM `company_reviews` cr JOIN `company` c ON cr.company_no = c.company_no ORDER BY cr.created_at DESC";
$reviews_result = mysqli_query($conn, $reviews_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/navbar.css" />
    <title>Rate Company</title>
    <style>
    </style>
</head>

<body>
    <nav class="navbar">
        <span class="navbar-toggle" id="js-navbar-toggle">
            <i class="fas fa-bars"></i>
        </span>
        <img src="../web_dev_img/dailysmarty.png" class="logo" style="margin-top:-5px">
    </nav>

    <div class="container mt-4">
        <h2>Rate a Company</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="company_no">Select Company:</label>
                <select name="company_no" id="company_no" class="form-control" required>
                    <option value="">-- Select a Company --</option>
                    <?php
                    while ($company = mysqli_fetch_assoc($companies_result)) {
                        echo '<option value="' . $company['company_no'] . '">' . $company['company_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="rating">Rating:</label>
                <select name="rating" id="rating" class="form-control" required>
                    <option value="">-- Select Rating --</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="commentDescription">Comment:</label>
                <textarea name="commentDescription" id="commentDescription" class="form-control" rows="4"
                    required></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit Review</button>
        </form>

        <h3 class="mt-4">Other Reviews</h3>
        <div class="list-group">
            <?php
            while ($review = mysqli_fetch_assoc($reviews_result)) {
                echo '<div class="list-group-item mb-3">
                    <h5>' . htmlspecialchars($review['company_name']) . ' - Rating: ' . htmlspecialchars($review['rating']) . '</h5>
                    <p>' . htmlspecialchars($review['commentDescription']) . '</p>
                    <small class="text-muted">Submitted on ' . date('Y-m-d H:i', strtotime($review['created_at'])) . '</small>
                </div>';
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>