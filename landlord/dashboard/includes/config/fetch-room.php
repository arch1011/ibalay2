<?php
session_start(); // Start the session if not already started

// Check if LandlordID is set in the session
if (!isset($_SESSION['landlord_id'])) {
    // Return an error response if LandlordID is not set
    echo json_encode(['error' => 'landlord_id not set in session']);
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
    echo json_encode(['error' => 'Database connection failed. Please try again later.']);
    exit;
}

// Set character set to UTF-8
mysqli_set_charset($conn, 'utf8');

// Prepare SQL query to fetch total number of rooms owned by the logged-in landlord
$landlord_id = $_SESSION['landlord_id'];

$sql = "SELECT COUNT(*) AS total_rooms FROM room WHERE landlord_id = $landlord_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_rooms = $row["total_rooms"];
} else {
    $total_rooms = 0; // If no records found, set total rooms to 0
}

$conn->close();

// Return the total number of rooms as JSON
echo json_encode(['total_rooms' => $total_rooms]);
?>
