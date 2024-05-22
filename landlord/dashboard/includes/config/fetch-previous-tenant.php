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

// Get the period filter from the AJAX request if set
$period_filter = isset($_GET['period']) ? $_GET['period'] : 'This Year';

// Define the date range based on the period filter
$date_range = '';
if ($period_filter === 'Today') {
    $date_range = "AND DATE(rr.end_date) = CURDATE()";
} elseif ($period_filter === 'This Month') {
    $date_range = "AND MONTH(rr.end_date) = MONTH(CURDATE()) AND YEAR(rr.end_date) = YEAR(CURDATE())";
} elseif ($period_filter === 'This Year') {
    $date_range = "AND YEAR(rr.end_date) = YEAR(CURDATE())";
}

// Build the query based on the date range filter
$query = "
  SELECT COUNT(*) AS total_previous_tenants
  FROM previous_landlords pl
  INNER JOIN rented_rooms rr ON pl.tenant_id = rr.TenantID
  WHERE pl.landlord_id = $landlord_id
  AND rr.end_date IS NOT NULL
  $date_range";

// Execute the query
$result = mysqli_query($conn, $query);

// Fetch the result
if ($result) {
    $row = mysqli_fetch_assoc($result);
    // Get the total number of previous tenants
    $total_previous_tenants = $row['total_previous_tenants'] ?? 0;
    // Return the result as a JSON response
    echo json_encode(['total_previous_tenants' => $total_previous_tenants]);
} else {
    echo json_encode(['error' => 'Query failed: ' . mysqli_error($conn)]);
}
?>
