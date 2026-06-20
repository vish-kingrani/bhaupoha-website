<?php
session_start();

// If the session variable isn't set, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>