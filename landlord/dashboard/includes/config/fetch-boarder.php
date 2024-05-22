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

$landlord_id = $_SESSION['landlord_id'];

// Get the gender filter from the AJAX request if set
$gender_filter = isset($_GET['gender']) ? $_GET['gender'] : 'All';

// Build the query based on the gender filter
$query = "
  SELECT COUNT(*) AS total_boarders
  FROM rented_rooms rr
  INNER JOIN tenant t ON rr.TenantID = t.TenantID
  WHERE rr.landlord_id = $landlord_id
  AND rr.room_id IS NOT NULL";

if ($gender_filter !== 'All') {
    $query .= " AND t.gender = '$gender_filter'";
}

// Execute the query
$result = mysqli_query($conn, $query);

// Fetch the result
$row = mysqli_fetch_assoc($result);

// Get the total number of boarders
$total_boarders = $row['total_boarders'];

// Log the query and result for debugging
error_log("Query: $query");
error_log("Total boarders: $total_boarders");

// Return the result as a JSON response
echo json_encode(['total_boarders' => $total_boarders]);

?>
