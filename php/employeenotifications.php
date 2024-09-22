<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] = false) {
  header("location: ../index.php");
}
include '_dbconnect.php';
$e_id = $_SESSION['sess_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/employeenotifications.css" />
  <link rel="stylesheet" href="../css/navbar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <title>Notifications</title>
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
        <a href="cv.php" class="nav-links"><i class="fa fa-file" aria-hidden="true"></i> Resume</a>
      </li>
      <li>
        <a href="#" class="nav-links select-page"><i class="fa fa-bell" aria-hidden="true"></i> Notifications</a>
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
    <div class="bottom-left">Notifications</div>
  </div>

  <div class="super-container">

    <?php
    $sql = "SELECT j.job_position, j.job_location, j.job_type, j.company_no, ej.ar_val FROM `employee_job` ej JOIN `postajob` j WHERE j.job_id = ej.job_id AND ej.emp_no='$e_id' AND ej.ar_val!= 0;";
    $result = mysqli_query($conn, $sql);
    $numrows = mysqli_num_rows($result);
    if ($numrows == 0) {
      echo '<h4 style = "color:black;">No Notification</h4>';
    }
    while ($row = mysqli_fetch_assoc($result)) {
      $sql = "SELECT `company_name` FROM `company` WHERE `company_no`='" . $row['company_no'] . "' ;";
      $ans = mysqli_query($conn, $sql);
      $numrows = mysqli_fetch_assoc($ans);
      echo '<div class="component">
        <div class="job">
          <h3>' . $row['job_position'] . '</h3>
          <h4 class="job-type">' . $row['job_type'] . '</h4>
        </div>
  
        <div class="company-location">
          <a class="locate"><i class="fa fa-server" aria-hidden="true"></i>
            <span>' . $numrows['company_name'] . '</span></a>
          <h5 class="header-five">
            <i class="fa fa-map-marker" aria-hidden="true"></i>
            <span>' . $row['job_location'] . ' </span>
          </h5>
        </div>';

      if ($row['ar_val'] == 1) {
        echo '<div class="application">
          <span class="toggle-accepted">Accepted</span>
        </div>
      </div>';
      } else {
        echo '<div class="application">
          <span class="toggle-rejected">Rejected</span>
        </div>
      </div>';
      }
    }

    ?>

  </div>

  <script src="../js/employee.js"></script>
</body>

</html>
<!-- <img src="./web_dev_img/082-bell.png" alt="N" /> -->