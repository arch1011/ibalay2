<?php
// Retrieve landlord_id from session
session_start();

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


// Check if tenant_id is provided in the URL
if (!isset($_GET['tenant_id'])) {
    echo "Error: Missing tenant ID in the URL.";
    exit;
}

$tenant_id = $_GET['tenant_id'];


if (!isset($_SESSION['landlord_id'])) {
    echo "Error: Landlord ID not found in the session.";
    exit;
}

$landlord_id = $_SESSION['landlord_id'];

// Step 1: Update rented_rooms table
$update_rented_rooms_query = "UPDATE rented_rooms SET room_id = NULL WHERE TenantID = $tenant_id";
$result_update_rented_rooms = mysqli_query($conn, $update_rented_rooms_query);
if (!$result_update_rented_rooms) {
    echo "Error updating rented rooms: " . mysqli_error($conn);
    exit;
}

// Step 1: Update rented_rooms table
$update_tenant_query = "UPDATE tenant SET checked_out = 1 WHERE TenantID = $tenant_id";
$result_tenant = mysqli_query($conn, $update_tenant_query);
if (!$result_tenant) {
    echo "Error updating tenant checked out: " . mysqli_error($conn);
    exit;
}

// Step 2: Increment capacity in room table if room is assigned
$select_room_query = "SELECT room_id FROM rented_rooms WHERE TenantID = $tenant_id";
$result_select_room = mysqli_query($conn, $select_room_query);
if (!$result_select_room) {
    echo "Error selecting room: " . mysqli_error($conn);
    exit;
}

$row = mysqli_fetch_assoc($result_select_room);
$room_id = $row['room_id'];

if ($room_id) { // Check if a room is assigned to the tenant
    $update_room_capacity_query = "UPDATE room SET capacity = capacity + 1 WHERE room_id = $room_id";
    $result_update_room_capacity = mysqli_query($conn, $update_room_capacity_query);
    if (!$result_update_room_capacity) {
        echo "Error updating room capacity: " . mysqli_error($conn);
        exit;
    }
}

// Step 3: Insert into previous_landlords table
$insert_previous_landlord_query = "INSERT INTO previous_landlords (tenant_id, landlord_id) VALUES ($tenant_id, $landlord_id)";
$result_insert_previous_landlord = mysqli_query($conn, $insert_previous_landlord_query);
if (!$result_insert_previous_landlord) {
    echo "Error inserting into previous landlords: " . mysqli_error($conn);
    exit;
}

// Close database connection
mysqli_close($conn);

// Redirect to a success page
header("Location: checkout-success.php");
exit;
?>
