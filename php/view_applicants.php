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
  $sql = "SELECT ej.emp_no, ej.name, ej.dob, ej.resume, ej.ar_val, ej.comment
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
  <style>
    /* Add the custom CSS here */
    form button {
      margin-right: 10px;
      padding: 10px 20px;
      font-size: 16px;
    }
    form {
      display: inline-block;
      margin-right: 10px;
    }
  </style>
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
          <th scope="col">Comments</th>
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
          
          // Display comment text area
          echo '<td>
                  <textarea name="comment_' . $row['emp_no'] . '" class="form-control" placeholder="Enter comments" rows="3"></textarea>
                </td>';
          
          echo '<td>
                  <!-- Form for Accepting/Rejecting with the comment -->
                  <form action="change_status.php" method="GET">
                    <input type="hidden" name="job_id" value="' . $job_id . '">
                    <input type="hidden" name="emp_no" value="' . $row['emp_no'] . '">
                    <input type="hidden" name="val" value="1">
                    <input type="hidden" name="comment" id="comment_' . $row['emp_no'] . '" value="">
                    <button type="submit" class="btn btn-success" onclick="updateComment(' . $row['emp_no'] . ', 1)">Accept</button>
                  </form>
                  <form action="change_status.php" method="GET">
                    <input type="hidden" name="job_id" value="' . $job_id . '">
                    <input type="hidden" name="emp_no" value="' . $row['emp_no'] . '">
                    <input type="hidden" name="val" value="-1">
                    <input type="hidden" name="comment" id="comment_reject_' . $row['emp_no'] . '" value="">
                    <button type="submit" class="btn btn-danger" onclick="updateCommentReject(' . $row['emp_no'] . ', -1)">Reject</button>
                  </form>
                </td>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Function to update the hidden comment field for Accept button
    function updateComment(emp_no, status) {
      var comment = document.querySelector('[name="comment_' + emp_no + '"]').value; // Get the comment from the textarea
      document.getElementById('comment_' + emp_no).value = comment; // Set the comment value in the hidden input field
    }

    // Function to update the hidden comment field for Reject button
    function updateCommentReject(emp_no, status) {
      var comment = document.querySelector('[name="comment_' + emp_no + '"]').value; // Get the comment from the textarea
      document.getElementById('comment_reject_' + emp_no).value = comment; // Set the comment value in the hidden input field
    }
  </script>
</body>

</html>
