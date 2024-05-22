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
    echo json_encode(array('success' => false, 'message' => 'Database connection failed. Please try again later.'));
    exit;
}

// Set character set to UTF-8
mysqli_set_charset($conn, 'utf8');

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    if(isset($_POST['room_id'])) {
        $room_id = $_POST['room_id'];
        
        // Debug: Output the value of $room_id
        error_log("Room ID: " . $room_id);

        // Assuming you have a way to identify the current tenant ID
        // For example, if the tenant is logged in and you have a session variable for tenant_id
        if(isset($_SESSION['TenantID'])) {
            $tenant_id = $_SESSION['TenantID'];

            // Debug: Output the value of $tenant_id
            error_log("TenantID: " . $tenant_id);

            // Check if the tenant already has a rented room
            $check_rented_query = "SELECT * FROM rented_rooms WHERE TenantID = ? AND room_id != NULL";
            $check_rented_stmt = mysqli_prepare($conn, $check_rented_query);
            mysqli_stmt_bind_param($check_rented_stmt, 'i', $tenant_id);
            mysqli_stmt_execute($check_rented_stmt);
            mysqli_stmt_store_result($check_rented_stmt);
            if (mysqli_stmt_num_rows($check_rented_stmt) > 0) {
                echo json_encode(array('success' => false, 'message' => 'You already have a rented room.'));
                exit;
            }

            // Check if the room is already reserved by the same tenant
            $check_reserved_query = "SELECT * FROM reserved_room WHERE TenantID = ? AND room_id = ?";
            $check_reserved_stmt = mysqli_prepare($conn, $check_reserved_query);
            mysqli_stmt_bind_param($check_reserved_stmt, 'ii', $tenant_id, $room_id);
            mysqli_stmt_execute($check_reserved_stmt);
            mysqli_stmt_store_result($check_reserved_stmt);
            if (mysqli_stmt_num_rows($check_reserved_stmt) > 0) {
                echo json_encode(array('success' => false, 'message' => 'Room already reserved.'));
                exit;
            }

            // Proceed to insert reserved_room into the database
            $query = "INSERT INTO reserved_room (TenantID, room_id) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            if (!$stmt) {
                throw new Exception("Error preparing SQL query: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, 'ii', $tenant_id, $room_id);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                // If reservation was successful, return success message
                echo json_encode(array('success' => true, 'message' => 'Room reserved successfully.'));
                exit;
            } else {
                // If reservation failed, return error message
                throw new Exception("Reservation failed. Please try again.");
            }
            
        } else {
            // If tenant_id is not set in session, return error message
            echo json_encode(array('success' => false, 'message' => 'Tenant ID is not set.'));
            exit;
        }
    }
} catch (Exception $e) {
    // Handle exceptions
    error_log("Error: " . $e->getMessage(), 0);
    echo json_encode(array('success' => false, 'message' => $e->getMessage()));
    exit;
}
?>
