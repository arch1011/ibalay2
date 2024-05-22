<?php
include('session.php');

$targetAuthLog = "/iBalay/tenant/authlog/authlog.php"; // Auth log page path
$targetHome = "/iBalay/tenant/public/home.php"; // Home page path

$currentScript = basename($_SERVER['PHP_SELF']); // Current script's basename

if (!isset($_SESSION['TenantID'])) {
    if ($currentScript !== 'authlog.php') {
        // If no session and not on auth log page, redirect to auth log
        header("Location: $targetAuthLog");
        exit();
    }
} else {
    if ($currentScript !== 'home.php') {
        // If session exists and not on home page, redirect to home
        header("Location: $targetHome");
        exit();
    }
}

// If session exists and you're on the desired page, no need to redirect

?>