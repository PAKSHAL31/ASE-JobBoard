<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    header("location: ../index.php");
}
include '_dbconnect.php'; 
if(isset($_GET['r_id'])){
    $id = $_GET['r_id'];
    $sql = "UPDATE `company` SET `verified` = '-1' WHERE `company_no` = '$id'";
    $result = mysqli_query($conn, $sql);
    unset($_GET['r_id']);
}

if(isset($_GET['v_id'])){
    $id = $_GET['v_id'];
    $sql = "UPDATE `company` SET `verified` = '1' WHERE `company_no` = '$id'";
    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/admin.css" />
    <link rel="stylesheet" href="../css/navbar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <title>Home Company</title>
</head>

<body>
    <nav class="navbar">
        <span class="navbar-toggle" id="js-navbar-toggle">
            <i class="fas fa-bars"></i>
        </span>
        <img src="../web_dev_img/dailysmarty.png" class="logo">
        <ul class="main-nav" id="js-menu">
            <li>
                <a href="#" class="nav-links select-page"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li>
                <a href="logout.php" class="nav-links"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
            </li>
            <li>
                <a href="#" class="nav-links"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION['navname']; ?></a>
            </li>
        </ul>
    </nav>

    <div class="image-text-box">
        <div class="bottom-left">Admin</div>
    </div>

    <div class="super-container">

    <?php
        $sql = "SELECT * FROM `company` WHERE `verified` = 0;";
        $result = mysqli_query($conn, $sql);
        $numrows = mysqli_num_rows($result);
        if($numrows == 0){
            echo 'No Company Available';
        }
        while($row = mysqli_fetch_assoc($result)){
            echo '<div class="component">
            <div class="job">
                <h3>'. $row['company_name'] .'</h3>
            </div>

            <div class="company-location">
                <a class="locate"><i class="fa fa-phone" aria-hidden="true"></i>
                    <span>'. $row['company_phnumber'] .'</span></a>
                <a class="header-five">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    <span>'. $row['company_email'] .'</span></a>
            </div>

            <div class="application">
                <a href="admin.php?v_id='. $row['company_no'] .'" class="apply-button toggle-accepted">&nbspVerify&nbsp</a>
                <a href="admin.php?r_id='. $row['company_no'] .'" class="apply-button toggle-rejected">Remove</a>
            </div>
        </div>';
        }
    ?>

        <!-- just repeated the component again to check below of spacing and all gg boiz!! -->
    </div>
    <script src="../js/employee.js"></script>

</body>

</html>
<!-- <img src="./web_dev_img/082-bell.png" alt="N" /> -->
