<?php

$host = 'localhost';
$dbname = 'iBalay_System';
$username = 'root';
$password = '';

// Connect to the database using MySQLi
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

$tenant_id = $_SESSION['TenantID'];

// Query to fetch inquiries
$query = "SELECT i.*, r.room_number, r.room_photo1, r.room_photo2, r.room_price, r.capacity, 
                 bh.BH_address, bh.number_of_kitchen 
          FROM inquiry i
          INNER JOIN room r ON i.room_id = r.room_id
          INNER JOIN bh_information bh ON r.landlord_id = bh.landlord_id
          WHERE i.tenant_id = $tenant_id";

$result = mysqli_query($conn, $query);

// Fetch all inquiries
$inquiries = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $inquiries[] = $row;
    }
}

// Close the result set
mysqli_free_result($result);

?>

