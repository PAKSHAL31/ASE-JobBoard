<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] = false) {
    header("location: ../index.php");
}
include '_dbconnect.php';
$e_id = $_SESSION['sess_id'];
if (isset($_POST['updlink'])) {
    $cvlink = $_POST['cvlink'];
    $sql = "UPDATE `employee` SET `emp_cvlink`= '$cvlink' WHERE `emp_no`= '$e_id';";
    $ans = mysqli_query($conn, $sql);
} else if (isset($_POST['sublink'])) {
    $cvlink = $_POST['cvlink'];
    $sql = "UPDATE `employee` SET `emp_cv`= 1 ,`emp_cvlink`= '$cvlink' WHERE `emp_no`= '$e_id';";
    $ans = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/companypostajob.css" />
    <link rel="stylesheet" href="../css/navbar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <title>Post a Job</title>
</head>

<body>
    <nav class="navbar">
        <span class="navbar-toggle" id="js-navbar-toggle">
            <i class="fas fa-bars"></i>
        </span>
        <img src="../web_dev_img/dailysmarty.png" class="logo">
        <ul class="main-nav" id="js-menu">
            <li>
                <a href="employeehome.php" class="nav-links"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li>
                <a href="#" class="nav-links select-page"><i class="fa fa-file" aria-hidden="true"></i> Resume</a>
            </li>
            <li>
                <a href="employeenotifications.php" class="nav-links"><i class="fa fa-bell" aria-hidden="true"></i>
                    Notifications</a>
            </li>
            <li>
                <a href="logout.php" class="nav-links"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
            </li>
            <li>
                <a href="#" class="nav-links"><i class="fa fa-user" aria-hidden="true"></i><?php echo $_SESSION['navname']; ?></a>
            </li>
        </ul>
    </nav>

    <div class="image-text-box">
        <div class="bottom-left">Post a Job</div>
    </div>


    <script src="employee.js"></script>

    <div id="container">
        <form id="form" method="POST">
            <div id="emptydiv"></div>

            <div class="form-box">
                <label>Upload your link here</label>
                <input type="text" class="input" id="username" name="cvlink" placeholder="Your drive link here" required>
            </div>
            <?php
            $sql = "SELECT `emp_cv` FROM `employee` WHERE `emp_no` = '$e_id'; ";
            $ans = mysqli_query($conn, $sql);
            $numrows = mysqli_fetch_assoc($ans);
            if ($numrows['emp_cv'] == 1) {
                echo '<div class="form-box">
                <button class="send" name="updlink">Update-link</button>
                </div>';
            } else {
                echo '<div class="form-box">
                <button class="send" name="sublink">Submit</button>
                </div>';
            }
            ?>
        </form>
    </div>

</body>

</html>