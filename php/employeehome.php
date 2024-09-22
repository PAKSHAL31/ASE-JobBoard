<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] = false) {
  header("location: ../index.php");
}
include '_dbconnect.php';
$e_id = $_SESSION['sess_id'];
if (isset($_GET['job_id'])) {
  $j_id = $_GET['job_id'];
  $sqls = "INSERT INTO `employee_job`(`emp_no`, `job_id`, `ar_val`) VALUES ('$e_id','$j_id',0);";
  $result = mysqli_query($conn, $sqls);
  unset($_GET['job_id']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/employeehome.css" />
  <link rel="stylesheet" href="../css/navbar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <title>HOME</title>
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
        <a href="cv.php" class="nav-links"><i class="fa fa-file" aria-hidden="true"></i> Resume</a>
      </li>
      <li>
        <a href="employeenotifications.php" class="nav-links"><i class="fa fa-bell" aria-hidden="true"></i> Notifications</a>
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

  <div class="container">
    <div class="header-text">
      <h2>Find A Job At Your Comfortable Location</h2>
    </div>
    <form action="employeehome.php" method="POST">
      <div class="quickbar-search-form">
        <div class="suggestor-skill">
          <input type="text" class="input1" placeholder="Eg: Javascript,WebDeveloper" name="job_position" />
        </div>

        <div class="suggestor-location">
          <input type="text" class="input2" placeholder="Eg;Mumbai,Navi Mumbai" name="job_location" />
        </div>

        <div style="margin-left: 3%;">
          <button class="fa fa-search search-btn" aria-hidden="true"></button>
        </div>
      </div>
    </form>
  </div>

  <div class="super-container">
    <?php
    $sql = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $job_position = $_POST['job_position'];
      $job_location = $_POST['job_location'];
      if ($job_position == '' && $job_location == '') {
        $sql = "SELECT * FROM postajob WHERE job_id NOT IN (SELECT job_id FROM employee_job WHERE emp_no = '$e_id');";
      } else if ($job_position == '') {
        $sql = "SELECT * FROM postajob WHERE job_id NOT IN (SELECT job_id FROM employee_job WHERE emp_no = '$e_id') AND `job_location` LIKE '%$job_location%';";
      } else if ($job_location == '') {
        $sql = "SELECT * FROM postajob WHERE job_id NOT IN (SELECT job_id FROM employee_job WHERE emp_no = '$e_id') AND `job_position` LIKE '%$job_position%';";
      } else {
        $sql = "SELECT * FROM postajob WHERE job_id NOT IN (SELECT job_id FROM employee_job WHERE emp_no = '$e_id') AND `job_position` LIKE '%$job_position%' AND `job_location` LIKE '%$job_location%'; ";
      }
    } else {
      $sql = "SELECT * FROM postajob WHERE job_id NOT IN (SELECT job_id FROM employee_job WHERE emp_no = '$e_id');";
    }
    $result = mysqli_query($conn, $sql);
    $numrows = mysqli_num_rows($result);
    if ($numrows == 0) {
      echo '<h4 style = "color:black;">No Job Available</h4>';
    }
    while ($row = mysqli_fetch_assoc($result)) {
      $sql = "SELECT `company_name` FROM `company` WHERE `company_no`='" . $row['company_no'] . "' ;";
      $ans = mysqli_query($conn, $sql);
      $numrows = mysqli_fetch_assoc($ans);
      echo '<div class="component">
        <div class="job">
          <h3>' . $row['job_position'] . ' </h3>
          <h4 class="job-type">' . $row['job_type'] . '</h4>
        </div>

        <div class="company-location">
          <a class="locate"><i class="fa fa-server" aria-hidden="true"></i><span>' . $numrows['company_name'] . '</span></a>
          <h5 class="header-five">
            <i class="fa fa-map-marker" aria-hidden="true"></i><span>' . $row['job_location'] . '</span></h5>
        </div>

        <div class="application">
          <a href="employeehome.php?job_id=' . $row['job_id'] . '" class="apply-button">Apply Now</a>
        </div>
      </div> ';
    }
    ?>
  </div>
  <script src="../js/employee.js"></script>
</body>

</html>
<!-- <img src="./web_dev_img/082-bell.png" alt="N" /> -->