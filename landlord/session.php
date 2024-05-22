<?php
session_start();

// Check if the landlord is logged in
if (!isset($_SESSION['landlord_id'])) {
    // If not logged in, redirect to the login page
    header('Location: /iBalay/landlord/authlog/login.php');
    exit;
}
?>