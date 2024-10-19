<?php
session_start();
include '_dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $job_id = $_POST['job_id'];
    $emp_no = $_POST['emp_no'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];

    // Handle file upload
    $resume = $_FILES['resume'];
    $resumeName = $resume['name'];
    $resumeTmpName = $resume['tmp_name'];
    $resumeError = $resume['error'];

    // Check for errors
    if ($resumeError === 0) {
        // Generate a unique name for the resume
        $resumeExt = pathinfo($resumeName, PATHINFO_EXTENSION); // Get file extension
        $newResumeName = "resume_{$emp_no}_job_{$job_id}_" . time() . ".{$resumeExt}"; // Format: resume_empID_jobID_timestamp.ext
        $uploadDir = '../uploads/'; // Make sure this directory exists and is writable
        $resumeDestination = $uploadDir . basename($newResumeName);

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($resumeTmpName, $resumeDestination)) {
            // Insert data into the database
            $sql = "INSERT INTO `employee_job`(`emp_no`, `job_id`, `ar_val`,`name`,`dob`,`resume`) VALUES (?, ?, 0, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iisss", $emp_no, $job_id, $name, $dob, $resumeDestination);
            
            if ($stmt->execute()) {
                // Set session variable to indicate success
                $_SESSION['application_success'] = "Application submitted successfully!";
                // Redirect back to employee_home.php
                header("Location: employeehome.php");
                exit(); // Ensure no further code is executed after redirection
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Failed to upload resume.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>
