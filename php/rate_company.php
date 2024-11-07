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
    <link rel="stylesheet" href="../css/navbar.css" />
</head>
<body>
<nav class="navbar">
        <span class="navbar-toggle" id="js-navbar-toggle">
            <i class="fas fa-bars"></i>
        </span>
        <img src="../web_dev_img/dailysmarty.png" class="logo" style="margin-top:-5px">
        <a href="employeehome.php" class="nav-links"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
    </nav>

    <div class="container mt-4">
        <h2>Submit a Review</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="company_no">Select Company:</label>
                <select name="company_no" id="company_no" class="form-control" required>
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
    </div>
</body>
</html>
