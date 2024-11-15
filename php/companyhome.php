<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    header("location: ../index.php");
}
include '_dbconnect.php';
$c_id = $_SESSION['sess_id'];

// Handle job deletion
if (isset($_GET['delete_job_id'])) {
    $job_id = $_GET['delete_job_id'];
    $delete_sql = "DELETE FROM `postajob` WHERE `job_id` = '$job_id' AND `company_no` = '$c_id'";
    mysqli_query($conn, $delete_sql);
    // Redirect to avoid resubmission on page reload
    header("location: companyhome.php");
}

// Fetch all jobs posted by the company
$sql = "SELECT job_id, job_position, job_location, job_description, job_type FROM postajob WHERE company_no = '$c_id'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/companyhome.css" />
    <link rel="stylesheet" href="../css/navbar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <title>Home Company</title>
</head>

<body>
    <nav class="navbar">
        <span class="navbar-toggle" id="js-navbar-toggle">
            <i class="fas fa-bars"></i>
        </span>
        <img src="../web_dev_img/dailysmarty.png" class="logo">
        <ul class="main-nav" id="js-menu">
            <li><a href="#" class="nav-links select-page"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li><a href="companypostajob.php" class="nav-links"><i class="fa fa-bell" aria-hidden="true"></i> Post a Job</a></li>
            <li><a href="company_reviews.php" class="nav-links"><i class="fa fa-comment" aria-hidden="true"></i>Reviews</a></li>
            <li><a href="logout.php" class="nav-links"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a></li>
            <li><a href="#" class="nav-links"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION['navname']; ?></a></li>
        </ul>
    </nav>

    <div class="image-text-box">
        <div class="bottom-left">Home</div>
    </div>

    <div class="super-container">
    <?php
    if (mysqli_num_rows($result) == 0) {
        echo '<h4 style="color:black;">No Job Posts</h4>';
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="job-card">
                <div class="job-info">
                    <h3>' . $row['job_position'] . '</h3>
                    <h4 class="job-type">' . $row['job_type'] . '</h4>
                    <p class="job-location"><i class="fa fa-map-marker" aria-hidden="true"></i> ' . $row['job_location'] . '</p>
                </div>
                <div class="job-actions">
                    <a href="view_applicants.php?job_id=' . $row['job_id'] . '" class="apply-button view-button">View</a>
                    <a href="companyhome.php?delete_job_id=' . $row['job_id'] . '" class="apply-button delete-button" onclick="return confirm(\'Are you sure you want to delete this job?\');">Delete</a>
                </div>
            </div>';
        }
    }
    ?>
</div>

    <script src="../js/employee.js"></script>
</body>

</html>
