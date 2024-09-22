<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
  header("location: ../index.php");
}
$success = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include '_dbconnect.php';
  $jobtype = $_POST['jobtype'];
  $jobposition = $_POST['jobposition'];
  $joblocation = $_POST['joblocation'];
  $companyid = $_SESSION['sess_id'];
  $sql = "INSERT INTO `postajob` (`job_position`, `job_location`, `job_type`, `company_no`) VALUES ('$jobposition', '$joblocation', '$jobtype', '$companyid');";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $success = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <link rel="stylesheet" href="../css/companypostajob.css" />
  <link rel="stylesheet" href="../css/navbar.css" />
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
        <a href="companyhome.php" class="nav-links"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
      </li>

      <li>
        <a href="#" class="nav-links select-page"><i class="fa fa-bell" aria-hidden="true"></i> Post a Job</a>
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
    <div class="bottom-left">Post a Job</div>
  </div>


  <div id="container">
    <form id="form" action="companypostajob.php" method="POST">
      <div id="emptydiv"></div>

      <div class="form-box">
        <label>Job Title</label>
        <input type="text" class="input" id="username" placeholder="Professional UI/UX Designer" name="jobposition" required />
      </div>

      <div class="form-box">
        <label>Location</label>
        <input type="text" class="input" id="location" placeholder="eg. Andheri,Dadar" name="joblocation" required />
      </div>

      <div class="form-box">
        <label id="last">Job Type</label>
        <div class="radio">
          <input type="radio" class="opt" name="jobtype" value="Full Time" required /><span>Full Time</span>
        </div>
        <div class="radio">
          <input type="radio" class="opt" name="jobtype" value="Internship" required /><span>Internship</span>
        </div>
        <div class="radio">
          <input type="radio" class="opt" name="jobtype" value="Part Time" required /><span>Part Time</span>
        </div>
        <div class="radio">
          <input type="radio" class="opt" name="jobtype" value="Freelancer" required /><span>Freelancer</span>
        </div>
      </div>

      <div class="form-box">
        <button id="send" name="postjob">Post</button>
      </div>
    </form>
    <?php
    if ($success) {
      echo '<div id="post">
      <span>Posted!!!</span>
    </div>';
    }
    ?>
  </div>

  <script src="../js/employee.js"></script>
</body>

</html>