<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    header("location: ../index.php");
}
include '_dbconnect.php'; 

if (isset($_GET['r_id'])) {
    $id = $_GET['r_id'];
    $sql = "UPDATE `company` SET `verified` = '-1' WHERE `company_no` = '$id'";
    $result = mysqli_query($conn, $sql);
}

if (isset($_GET['v_id'])) {
    $id = $_GET['v_id'];
    $sql = "UPDATE `company` SET `verified` = '1' WHERE `company_no` = '$id'";
    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <title>Home Company</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <a class="navbar-brand" href="#">
            <img src="../web_dev_img/dailysmarty.png" class="logo" height="30" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION['navname']; ?></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Admin Panel</h2>
        <div class="row">

        <?php
            $sql = "SELECT * FROM `company` WHERE `verified` = 0;";
            $result = mysqli_query($conn, $sql);
            $numrows = mysqli_num_rows($result);
            if ($numrows == 0) {
                echo '<div class="col-12"><div class="alert alert-info text-center">No Company Available</div></div>';
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    $company_id = $row['company_no'];
                    $company_name = $row['company_name'];
                    $company_email = $row['company_email'];
                    $company_phone = $row['company_phnumber'];

                    echo '<div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">'. $company_name .'</h5>
                                <p class="card-text"><i class="fa fa-envelope" aria-hidden="true"></i> '. $company_email .'</p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#companyModal'.$company_id.'">View</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal fade" id="companyModal'.$company_id.'" tabindex="-1" role="dialog" aria-labelledby="companyModalLabel'.$company_id.'" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="companyModalLabel'.$company_id.'">Company Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Company Name:</strong> '.$company_name.'</p>
                                    <p><strong>Email:</strong> '.$company_email.'</p>
                                    <p><strong>Phone Number:</strong> '.$company_phone.'</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="admin.php?v_id='.$company_id.'" class="btn btn-success">Verify</a>
                                    <a href="admin.php?r_id='.$company_id.'" class="btn btn-danger">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            }
        ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
