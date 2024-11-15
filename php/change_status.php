<?php
session_start();
include '_dbconnect.php';

if (isset($_GET['job_id']) && isset($_GET['emp_no']) && isset($_GET['val']) && isset($_GET['comment'])) {
  $job_id = $_GET['job_id'];
  $emp_no = $_GET['emp_no'];
  $val = $_GET['val']; // 1 for Accept, -1 for Reject
  $comment = $_GET['comment']  ;// Sanitize the comment


  // Update the status in the database
  $sql = "UPDATE employee_job SET ar_val = '$val', comment='$comment' WHERE job_id = '$job_id' AND emp_no = '$emp_no'";
  if (mysqli_query($conn, $sql)) {
    header("location: view_applicants.php?job_id=" . $job_id); // Redirect back to the applicants page
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }
}
?>
