<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] = false) {
    header("location: ../index.php");
}
include '_dbconnect.php';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Submit a Review</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* General body styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
}

/* Navbar styling */
.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #2376ae;
    padding: 10px 20px;
    color: #ffffff;
}

.navbar .logo {
    height: 40px;
    width: auto;
}

.navbar .nav-links {
    color: #ffffff;
    text-decoration: none;
    font-size: 16px;
    margin-left: 20px;
    transition: color 0.3s ease;
}

.navbar .nav-links:hover {
    color: #17a2b8;
}

.navbar a {
    text-decoration: none;
}

.navbar i {
    margin-right: 8px;
}

/* Container for the form and reviews */
.container {
    margin-top: 30px;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Form styling */
h2 {
    color: #343a40;
}

h3 {
    color: #495057;
}

.form-group label {
    font-weight: bold;
    color: #495057;
}

.form-control {
    border-radius: 5px;
    border: 1px solid #ced4da;
    padding: 10px;
}

.btn-primary {
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
}

/* Review card styling */
.card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.card-body {
    padding: 15px;
}

.card-title {
    font-weight: bold;
    color: #343a40;
}

.card-text {
    color: #495057;
}

/* For smaller screens */
@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
        align-items: flex-start;
    }

    .navbar .nav-links {
        margin-left: 0;
        margin-bottom: 10px;
    }
    /* Divider Styling */
.section-divider {
    border: none;
    border-top: 2px solid #dee2e6; /* Light gray line */
    margin: 30px 0;
    width: 100%;
}

/* Optional: Add a text label on the divider */
.section-divider::before {
    content: "Other Reviews";
    display: block;
    text-align: center;
    font-size: 1.2rem;
    color: #495057;
    margin-bottom: -15px;
    background-color: #f8f9fa; /* Matches the background color */
    padding: 0 10px;
    position: relative;
    top: -12px;
}

}

    </style>
</head>
<body>
<nav class="navbar">
    <img src="../web_dev_img/dailysmarty.png" class="logo" style="margin-top:-5px">
    <a href="employeehome.php" class="nav-links"><i class="fa fa-home"></i> Home</a>
</nav>

<div class="container mt-4">
    <h2>Submit a Review</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="company_no">Select Company:</label>
            <select name="company_no" id="company_no" class="form-control" required onchange="fetchReviews(this.value)">
                <option value="">-- Select a Company --</option>
                <?php while ($company = mysqli_fetch_assoc($companies_result)) : ?>
                    <option value="<?php echo $company['company_no']; ?>"><?php echo $company['company_name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="rating">Rating:</label>
            <select name="rating" id="rating" class="form-control" required>
                <option value="">-- Select Rating --</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="commentDescription">Comment:</label>
            <textarea name="commentDescription" id="commentDescription" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit Review</button>
    </form>
    <hr class="section-divider">
    <!-- Other Reviews Section -->
    <div id="other-reviews-section" class="mt-5 ">
        <h3>Other Reviews</h3>
        <div id="reviews-container">
            <p class="text-muted">Select a company to view its reviews.</p>
        </div>
    </div>
</div>

<script>
function fetchReviews(companyNo) {
    const reviewsContainer = document.getElementById('reviews-container');

    if (!companyNo) {
        reviewsContainer.innerHTML = '<p class="text-muted">Select a company to view its reviews.</p>';
        return;
    }

    fetch('fetch_reviews.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'company_no=' + companyNo
    })
    .then(response => response.json())
    .then(data => {
        if (data.length === 0) {
            reviewsContainer.innerHTML = '<p class="text-muted">No reviews available for this company.</p>';
            return;
        }

        const reviewsHTML = data.map(review => `
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Rating: 
                        <span class="badge badge-primary">${review.rating}</span>
                    </h5>
                    <p class="card-text">${review.commentDescription}</p>
                    <small class="text-muted">Submitted on ${new Date(review.created_at).toLocaleString()}</small>
                </div>
            </div>
        `).join('');

        reviewsContainer.innerHTML = reviewsHTML;
    })
    .catch(error => {
        console.error('Error fetching reviews:', error);
        reviewsContainer.innerHTML = '<p class="text-danger">Error fetching reviews. Please try again later.</p>';
    });
}
</script>

</body>
</html>