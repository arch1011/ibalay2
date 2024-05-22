<?php
session_start();

// Check if the landlord is logged in
if (!isset($_SESSION['TenantID'])) {
    // If not logged in, redirect to the login page
    header('Location: /iBalay/tenant/authlog/authlog.php');
    exit;
}
?>