<?php
session_start(); // Start the session if not already started

// Check if user is logged in
if (!isset($_SESSION['TenantID'])) {
    // If not logged in, redirect to login page or show an error message
    header("Location: login.php");
    exit;
}

// Check if room ID is provided
if (!isset($_POST['room_id'])) {
    // Handle the case where room ID is not provided
    echo "Error: Room ID is required.";
    exit;
}

$room_id = $_POST['room_id'];
$tenant_id = $_SESSION['TenantID'];

$host = 'localhost';
$dbname = 'iBalay_System';
$username = 'root';
$password = '';

// Create a connection using MySQLi
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check for successful connection
if (!$conn) {
    // Handle database connection error
    echo "Database connection failed. Please try again later.";
    exit;
}

// Set character set to UTF-8
mysqli_set_charset($conn, 'utf8');

// Prepare delete query
$delete_query = "DELETE FROM reserved_room WHERE TenantID = ? AND room_id = ?";
$stmt = mysqli_prepare($conn, $delete_query);

// Bind parameters and execute query
mysqli_stmt_bind_param($stmt, 'ii', $tenant_id, $room_id);
$result = mysqli_stmt_execute($stmt);

if ($result) {
    // reserved_room successfully deleted
    // You can redirect the user back to the previous page or show a success message
    header("Location: /iBalay/tenant/public/reserved.php");
    exit;
} else {
    // Error occurred while deleting reserved_room
    echo "Error deleting reserved_room. Please try again.";
    exit;
}

// Close database connection
mysqli_close($conn);
?>
