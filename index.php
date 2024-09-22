<?php
$showerror = false;
$login = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'php/_dbconnect.php';
    if (isset($_POST['category'])) {
        $category = $_POST['category'];
    } else {
        if (($_POST['email'] == 'admin@gmail.com') && ($_POST['password'] == 'admin123')) {
            session_start();
            $login = true;
            $_SESSION['loggedin'] = true;
            $_SESSION['navname'] = 'Admin';
            header("location: php/admin.php");
        } else {
            $category = '';
        }
    }
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($category == '') {
        $showerror = "Choose a Option";
    } else {
        if ($category == 'Company') {
            $existsql = "SELECT * FROM `company` WHERE `company_email` = '$email'";
            $result = mysqli_query($conn, $existsql);
            $numrows = mysqli_num_rows($result);
            if ($numrows == 1) {
                $row = mysqli_fetch_assoc($result);
                if ($row['verified'] == 1) {
                    if (password_verify($password, $row['company_pass'])) {
                        session_start();
                        $login = true;
                        $_SESSION['loggedin'] = true;
                        $_SESSION['navname'] = $row['company_name'];
                        $_SESSION['sess_id'] = $row['company_no'];
                        header("location: php/companyhome.php");
                    } else {
                        $showerror = "Unable to login";
                    }
                } else if ($row['verified'] == -1) {
                    $showerror = "Contact Admin for Verification";
                } else {
                    $showerror = "Wait for verification";
                }
            } else {
                $showerror = "Invalid Credentials";
            }
        } else {
            $existsql = "SELECT * FROM `employee` WHERE `emp_email` = '$email'";
            $result = mysqli_query($conn, $existsql);
            $numrows = mysqli_num_rows($result);
            if ($numrows == 1) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($password, $row['emp_password'])) {
                    session_start();
                    $login = true;
                    $_SESSION['loggedin'] = true;
                    $_SESSION['navname'] = $row['emp_name'];
                    $_SESSION['sess_id'] = $row['emp_no'];
                    header("location: php/employeehome.php");
                } else {
                    $showerror = "Unable to login";
                }
            } else {
                $showerror = "Invalid Credentials";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans&family=Poppins:wght@400;800&display=swap" rel="stylesheet">
    <title>SIGN IN</title>
</head>

<body>
    <div class="wholebody">
        <div class="navbar1">
            <div class="head1"><img src="web_dev_img/dailysmarty.png" class="logo"></div>
            <div class="head"><span>JobGuru</span></div>
        </div>
        <?php
        if ($login) {
            echo '<div class="mb-0 alert alert-success alert-dismissible fade show " role="alert">
                        <strong>Success&nbsp!&nbsp</strong>You Are logged In ' . $_SESSION['navname'] . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        }
        if ($showerror) {
            echo '<div class="mb-0 alert alert-danger alert-dismissible fade show " role="alert">
                         <strong>Error ! </strong>' . $showerror . '
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>';
        }

        ?>
        <div class="container-login">
            <div class="wrap-login">
                <div class="headerimg">
                    <span>
                        SIGN IN
                    </span>
                </div>
                <form class="loginform" action="index.php" method="POST">
                    <div class="login-input">
                        <span class="radio-label">Select one:</span>
                        <input type="radio" class="radio-btn" name="category" value="Employee"><span class="radio-label">Employee</span>
                        <input type="radio" class="radio-btn" name="category" value="Company"><span class="radio-label">Company</span>
                    </div>
                    <div class="login-input">
                        <input class="input100" type="email" name="email" placeholder="Enter Email" required />
                    </div>
                    <div class="login-input">
                        <input class="input100" type="password" name="password" placeholder="Enter Password" required />
                    </div>
                    <div class="login-btn">
                        <button class="sub-btn" name="submit">Login</button>
                    </div>
                    <div class="txt">
                        Don't have an account?&nbsp
                        <a href="php/register.php">
                            Sign Up
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>