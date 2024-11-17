<?php
include '_dbconnect.php';

if (isset($_POST['company_no'])) {
    $company_no = $_POST['company_no'];
    $sql = "SELECT cr.rating, cr.commentDescription, cr.created_at 
            FROM `company_reviews` cr 
            WHERE cr.company_no = '$company_no' ORDER BY cr.created_at DESC";
    $result = mysqli_query($conn, $sql);

    $reviews = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
    }

    echo json_encode($reviews);
}
?>
