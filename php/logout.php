<?php
session_start();
$_SESSION['loggedin'] = false;
$_SESSION['navname'] = '';
$_SESSION['sess_id'] = '';
session_destroy();
header("location: ../index.php");
