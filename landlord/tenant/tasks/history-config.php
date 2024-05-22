<?php
session_start(); // Start the session if not already started

// Check if LandlordID is set in the session
if (!isset($_SESSION['landlord_id'])) {
    // Redirect or handle the case where LandlordID is not set
    exit('landlord_id not set in session');
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
    die("Database connection failed. Please try again later.");
}

// Set character set to UTF-8
mysqli_set_charset($conn, 'utf8');

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the landlord ID from the session
$landlord_id = $_SESSION['landlord_id'];

// Query to fetch tenant details
$query = "SELECT t.TenantID, t.FirstName, t.LastName, t.Email, t.PhoneNumber, t.student_id, t.gender, t.address, t.checked_out
          FROM previous_landlords pl
          INNER JOIN tenant t ON pl.tenant_id = t.TenantID
          WHERE pl.landlord_id = $landlord_id
          AND t.checked_out = 1"; // added

$result = mysqli_query($conn, $query);

$tenants = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tenants[] = $row;
    }
}

// Close the result set
mysqli_free_result($result);

// Close the database connection
mysqli_close($conn);
?>