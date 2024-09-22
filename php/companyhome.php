<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
  header("location: ../index.php");
}
include '_dbconnect.php';
$c_id = $_SESSION['sess_id'];
if (isset($_GET['job_id']) && isset($_GET['emp_no']) && isset($_GET['val'])) {
  $j_id = $_GET['job_id'];
  $e_id = $_GET['emp_no'];
  $val = $_GET['val'];
  if ($val == 1) {
    $sqls = "UPDATE `employee_job` SET `ar_val`= '$val' WHERE `emp_no`= '$e_id'  AND `job_id`=  '$j_id' ";
  } else {
    $sqls = "UPDATE `employee_job` SET `ar_val`='$val' WHERE `emp_no`= '$e_id'  AND `job_id`=  '$j_id' ";
  }
  $result = mysqli_query($conn, $sqls);
  unset($_GET['job_id']);
  unset($_GET['emp_no']);
  unset($_GET['val']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/companyhome.css" />
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
        <a href="companypostajob.php" class="nav-links"><i class="fa fa-bell" aria-hidden="true"></i> Post a Job</a>
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
    <div class="bottom-left">Home</div>
  </div>

  <div class="super-container">
    <?php
    $sql = "SELECT j.job_id, j.job_position, j.job_location, j.job_type , ej.emp_no FROM postajob j JOIN employee_job ej WHERE j.job_id = ej.job_id AND j.company_no = '$c_id' AND ej.ar_val = 0;";
    $result = mysqli_query($conn, $sql);
    $numrows = mysqli_num_rows($result);
    if ($numrows == 0) {
      echo '<h4 style = "color:black;">No Applicants</h4>';
    }
    while ($row = mysqli_fetch_assoc($result)) {
      $sql = "SELECT `emp_name`,`emp_cvlink` FROM `employee` WHERE `emp_no`='" . $row['emp_no'] . "'; ";
      $ans = mysqli_query($conn, $sql);
      $numrows = mysqli_fetch_assoc($ans);
      echo '<div class="component">
        <div class="job">
          <h3>' . $numrows['emp_name'] . '</h3>
          <h4 class="job-type">' . $row['job_type'] . '</h4>
        </div>
  
        <div class="company-location">
          <a class="locate"><i class="fa fa-briefcase" aria-hidden="true"></i><span> ' . $row['job_position'] . '</span></a>
          <h5 class="header-five">
            <i class="fa fa-map-marker" aria-hidden="true"></i><span>' . $row['job_location'] . '</span></h5>
        </div>
  
        <div class="application">';

      if ($numrows['emp_cvlink'] == '') {
        echo '<a href="#" class="apply-button resume">RESUME</a>';
      } else {
        echo '<a href="' . $numrows['emp_cvlink'] . '" class="apply-button resume" target="_blank">RESUME</a>';
      }
      echo '<a href="companyhome.php?job_id=' . $row['job_id'] . ' &emp_no=' . $row['emp_no'] . ' &val=1" class="apply-button toggle-accepted">Accept</a>
          <a href="companyhome.php?job_id=' . $row['job_id'] . ' &emp_no=' . $row['emp_no'] . ' &val=-1" class="apply-button toggle-rejected">Reject</a>
        </div>
      </div>';
    }
    ?>

  </div>

  <script src="../js/employee.js"></script>
</body>

</html>
<!-- <img src="./web_dev_img/082-bell.png" alt="N" /> -->