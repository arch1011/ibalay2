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

// Prepare SQL query to fetch total amount earned by the logged-in landlord
$landlord_id = $_SESSION['landlord_id'];

// Filter condition
$filter_condition = "";
$filter_text = "";

if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
    switch ($filter) {
        case 'today':
            $filter_condition = "AND DATE(payment_date) = CURDATE()";
            $filter_text = "Today";
            break;
        case 'this_month':
            $filter_condition = "AND YEAR(payment_date) = YEAR(CURDATE()) AND MONTH(payment_date) = MONTH(CURDATE())";
            $filter_text = "This Month";
            break;
        case 'this_year':
            $filter_condition = "AND YEAR(payment_date) = YEAR(CURDATE())";
            $filter_text = "This Year";
            break;
        default:
            break;
    }
}

$sql = "SELECT SUM(amount) AS total_earned FROM tenant_payments WHERE landlord_id = $landlord_id $filter_condition";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_earned = $row["total_earned"];
} else {
    $total_earned = 0; // If no records found, set total earned to 0
}

$conn->close();

// Return the total earned amount and filter text as JSON
echo json_encode(['total_earned' => (float)$total_earned, 'filter_text' => $filter_text]);
?>
