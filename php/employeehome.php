<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] = false) {
  header("location: ../index.php");
}
if (isset($_SESSION['application_success'])) {
  echo '<script>alert("' . $_SESSION['application_success'] . '");</script>';
  unset($_SESSION['application_success']); // Unset the session variable after displaying
}
include '_dbconnect.php';
$e_id = $_SESSION['sess_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/employeehome.css" />
  <link rel="stylesheet" href="../css/navbar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
    integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
    crossorigin="anonymous" />
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
        <a href="employeenotifications.php" class="nav-links"><i class="fa fa-bell" aria-hidden="true"></i>
          Notifications</a>
      </li>
      <li>
        <a href="rate_company.php" class="nav-links"><i class="fa fa-comment" aria-hidden="true"></i>
          Reviews</a>
      </li>
      <li>
        <a href="logout.php" class="nav-links"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
      </li>
      <li>
        <a href="#" class="nav-links"><i class="fa fa-user" aria-hidden="true"></i>
          <?php echo $_SESSION['navname']; ?></a>
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
          <input type="text" class="input2" placeholder="Eg;Arlington,TX" name="job_location" />
        </div>

        <div class="suggestor-jobtype">
          <select name="job_type" class="input3">
            <option value="">Select Job Type</option>
            <option value="Full time">Full-time</option>
            <option value="Part time">Part-time</option>
            <option value="Internship">Internship</option>
            <option value="Freelancer">Freelancer</option>
          </select>
        </div>

        <div style="margin-left: 3%;">
          <button class="search" aria-hidden="true">Search</button>
        </div>
      </div>
    </form>
  </div>

  <div class="job-cards-container">
    <?php
    $sql = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $job_position = $_POST['job_position'];
      $job_location = $_POST['job_location'];
      $job_type = $_POST['job_type'];

      // Construct the SQL query based on user inputs
      $sql = "SELECT * FROM postajob WHERE job_id NOT IN (SELECT job_id FROM employee_job WHERE emp_no = '$e_id')";

      // Add filters if they are set
      if ($job_position != '') {
        $sql .= " AND `job_position` LIKE '%$job_position%'";
      }

      if ($job_location != '') {
        $sql .= " AND `job_location` LIKE '%$job_location%'";
      }

      if ($job_type != '') {
        $sql .= " AND `job_type` = '$job_type'";
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
      echo '<div class="job-card">
              <div class="job-card-header">
                <h3 class="job-title">' . $row['job_position'] . '</h3>
                <span class="job-type">' . $row['job_type'] . '</span>
              </div>
              <div class="job-card-body">
                <p class="company-name"><i class="fa fa-building"></i> ' . $numrows['company_name'] . '</p>
                <p class="job-location"><i class="fa fa-map-marker-alt"></i> ' . $row['job_location'] . '</p>
              </div>
              <div class="job-card-footer">
                <button onclick="openModal(\'' . htmlspecialchars($row['job_id']) . '\', \'' . htmlspecialchars($row['job_position']) . '\', \'' . htmlspecialchars($numrows['company_name']) . '\', \'' . htmlspecialchars($row['job_type']). '\', \'' . htmlspecialchars($row['job_location']) . '\', \'' . htmlspecialchars($row['job_description']) . '\');" class="apply-button">Apply Now</button>
              </div>
            </div>';
    }
    ?>

    <div id="jobDetailsModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2><span id ="companyHome"></span></h2>
        <p><strong>Position:</strong> <span id="jobPosition"></span></p>
        <p><strong>Type:</strong> <span id="jobType"></span></p>
        <p><strong>Location:</strong> <span id="jobLocation"></span></p>
        <p><strong>Description:</strong> <span id="jobDescription"></span></p>

        <!-- Form to submit application -->
        <form action="apply_job.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="job_id" id="modalJobId">
          <input type="hidden" name="emp_no" value="<?php echo $e_id; ?>">
          <!-- Assuming the employee ID is stored in $e_id -->

          <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
          </div>
          <div>
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>
          </div>
          <div>
            <label for="resume">Upload Resume:</label>
            <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required>

          </div>
          <button type="submit">Apply</button>
        </form>
      </div>
    </div>

  </div>
  <script src="../js/employee.js"></script>
</body>

</html>
<!-- <img src="./web_dev_img/082-bell.png" alt="N" /> -->