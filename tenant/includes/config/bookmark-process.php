<?php
session_start(); // Start the session if not already started

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

// Set character set to UTF-8
mysqli_set_charset($conn, 'utf8');

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['room_id'])) {
    $room_id = $_POST['room_id'];
    
    // Debug: Output the value of $room_id
    error_log("Room ID: " . $room_id);

    // Assuming you have a way to identify the current tenant ID
    // For example, if the tenant is logged in and you have a session variable for tenant_id
    if(isset($_SESSION['TenantID'])) {
        $tenant_id = $_SESSION['TenantID'];

        // Debug: Output the value of $tenant_id
        error_log("Tenant ID: " . $tenant_id);

        // Check if the room is already bookmarked by the same tenant
        $check_query = "SELECT * FROM bookmark WHERE tenant_id = ? AND room_id = ?";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, 'ii', $tenant_id, $room_id);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);
        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            echo json_encode(array('success' => false, 'message' => 'Room already reserved.'));
            exit;
        }
        

        // Proceed to insert bookmark into the database
        $query = "INSERT INTO bookmark (tenant_id, room_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        if (!$stmt) {
            error_log("SQL Prepare Error: " . mysqli_error($conn), 0);
            die("Error preparing SQL query.");
        }

        mysqli_stmt_bind_param($stmt, 'ii', $tenant_id, $room_id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // If bookmarking was successful, return success message
            echo json_encode(array('success' => true, 'message' => 'Room bookmarked successfully.'));
            exit;
        } else {
            // If bookmarking failed, return error message
            echo json_encode(array('success' => false, 'message' => 'Bookmarking failed. Please try again.'));
            exit;
        }
        
    } else {
        // If tenant_id is not set in session, return error message
        echo json_encode(array('success' => false, 'message' => 'tenant_id is not set.'));
        exit;
    }
}


?>
