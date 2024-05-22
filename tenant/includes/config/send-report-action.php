<?php
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in (adjust this as per your session handling)
    if (!isset($_SESSION['TenantID'])) {
        // Redirect or handle the case when the user is not logged in
        // For example, redirect to login page
        header("Location: /iBalay/login.php");
        exit;
    }

    $host = 'localhost';
    $dbname = 'iBalay_System';
    $username = 'root';
    $password = '';
    
    // Create a connection using MySQLi
    $conn = mysqli_connect($host, $username, $password, $dbname);
    
    // Check for successful connection
    if (!$conn) {
        error_log("Database connection failed: " . mysqli_connect_error(), 0);
        die("Connection failed. Please try again later.");
    }
    
    mysqli_set_charset($conn, 'utf8'); // Set character set to UTF-8

    // Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

    // Get the form data
    $room_id = $_POST['room_id'];
    $report_text = $_POST['report_text'];

    // Sanitize the data (prevent SQL injection)
    $room_id = mysqli_real_escape_string($conn, $room_id);
    $report_text = mysqli_real_escape_string($conn, $report_text);

    // Insert the report into the database
    $query = "INSERT INTO report (room_id, TenantID, ReportDate, ReportText, Acknowledge, Notified) 
              VALUES ('$room_id', '{$_SESSION['TenantID']}', CURDATE(), '$report_text', 0, 0)";

    if (mysqli_query($conn, $query)) {
        header ('location: /iBalay/tenant/public/rented.php');
        exit;
    } else {
        // Error in adding report
        // You can redirect or show an error message here
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
