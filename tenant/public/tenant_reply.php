<?php
include('../../tenant/session.php');

// Check if TenantID is set in the session
if (!isset($_SESSION['TenantID'])) {
    // Redirect or handle the case where TenantID is not set
    exit('TenantID not set in session');
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['room_id']) && isset($_POST['message'])) {
    $tenant_id = $_SESSION['TenantID'];
    $room_id = intval($_POST['room_id']);
    $message = trim($_POST['message']);

    // Validate message
    if (empty($message)) {
        exit('Message cannot be empty');
    }

    // Get landlord ID from the room ID
    $host = 'localhost';
    $dbname = 'iBalay_System';
    $username = 'root';
    $password = '';

    // Create a connection using MySQLi
    $conn = mysqli_connect($host, $username, $password, $dbname);

    // Check for successful connection
    if (!$conn) {
        error_log("Database connection failed: " . mysqli_connect_error(), 0);
        die("Database connection failed. Please try again later.");
    }

    // Set character set to UTF-8
    mysqli_set_charset($conn, 'utf8');

    // Turn on error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Query to fetch the landlord ID for the given room
    $query = "SELECT landlord_id FROM room WHERE room_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $room_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $landlord_id);

        if (mysqli_stmt_fetch($stmt)) {
            mysqli_stmt_close($stmt);

            // Insert reply into inquiry table
            $query = "INSERT INTO inquiry (room_id, tenant_id, landlord_id, message, sent_by, timestamp) VALUES (?, ?, ?, ?, 'tenant', NOW())";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'iiis', $room_id, $tenant_id, $landlord_id, $message);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    header('Location: /iBalay/tenant/public/inquiry.php');
                    exit;
                } else {
                    error_log("Query execution failed: " . mysqli_stmt_error($stmt), 0);
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    die("Query execution failed. Please try again later.");
                }
            } else {
                error_log("Statement preparation failed: " . mysqli_error($conn), 0);
                mysqli_close($conn);
                die("Statement preparation failed. Please try again later.");
            }
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            die("Failed to fetch landlord ID.");
        }
    } else {
        error_log("Statement preparation failed: " . mysqli_error($conn), 0);
        mysqli_close($conn);
        die("Statement preparation failed. Please try again later.");
    }
} else {
    die('Invalid form submission');
}
