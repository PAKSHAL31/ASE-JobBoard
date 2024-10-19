<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
  header("location: ../index.php");
}
include '_dbconnect.php';

if (isset($_GET['job_id'])) {
  $job_id = $_GET['job_id'];

  $job_query = "SELECT job_position FROM postajob WHERE job_id = '$job_id'";
  $job_result = mysqli_query($conn, $job_query);

  if ($job_row = mysqli_fetch_assoc($job_result)) {
    $job_title = $job_row['job_position']; // Get the job title
  }


  // Fetch applicants for the job
  $sql = "SELECT ej.emp_no, ej.name, ej.dob, ej.resume, ej.ar_val 
          FROM employee_job ej 
          WHERE ej.job_id = '$job_id' AND ej.ar_val = 0";
  $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Job Applicants</title>
</head>

<body>
  <div class="container mt-5">
    <!-- Display the Job Title -->
    <h2 class="mb-4">Applicants for <?php echo $job_title; ?></h2>
    
    <!-- Table for displaying applicants -->
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
        <tr>
          <th scope="col">Employee Name</th>
          <th scope="col">Date of Birth</th>
          <th scope="col">Resume</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<tr>';
          echo '<td>' . $row['name'] . '</td>';
          echo '<td>' . $row['dob'] . '</td>';
          echo '<td><a href="' . $row['resume'] . '" class="btn btn-primary" target="_blank">Download</a></td>';
          echo '<td>
                  <a href="change_status.php?job_id=' . $job_id . '&emp_no=' . $row['emp_no'] . '&val=1" class="btn btn-success">Accept</a>
                  <a href="change_status.php?job_id=' . $job_id . '&emp_no=' . $row['emp_no'] . '&val=-1" class="btn btn-danger">Reject</a>
                </td>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
