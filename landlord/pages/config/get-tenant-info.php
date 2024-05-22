<?php
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

// Fetch tenant details based on TenantID
$tenant_id = $_GET['tenant_id'];
$query = "SELECT * FROM tenant WHERE TenantID = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $tenant_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $tenant = mysqli_fetch_assoc($result);
    echo json_encode($tenant);
} else {
    echo json_encode(['error' => 'No tenant found']);
}

// Close the result set
mysqli_free_result($result);

// Close the database connection
mysqli_close($conn);
?>
