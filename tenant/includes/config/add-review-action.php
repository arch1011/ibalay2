<?php
session_start(); // Start the session if not already started

// Check if TenantID is set in the session
if (!isset($_SESSION['TenantID'])) {
    // Redirect or handle the case where TenantID is not set
    exit('TenantID not set in session');
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
    echo json_encode(array('success' => false, 'message' => 'Database connection failed. Please try again later.'));
    exit;
}

// Set character set to UTF-8
mysqli_set_charset($conn, 'utf8');

// Check if the form is submitted and all required fields are present
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['room_id']) && isset($_POST['review_comment']) && isset($_POST['room_rating']) && isset($_POST['bh_rating']) && isset($_POST['cr_rating']) && isset($_POST['beds_rating']) && isset($_POST['kitchen_rating'])) {
    // Sanitize input data
    $room_id = mysqli_real_escape_string($conn, $_POST['room_id']);
    $review_comment = mysqli_real_escape_string($conn, $_POST['review_comment']);
    $room_rating = (int) $_POST['room_rating']; // Convert to integer for safety
    $bh_rating = (int) $_POST['bh_rating'];
    $cr_rating = (int) $_POST['cr_rating'];
    $beds_rating = (int) $_POST['beds_rating'];
    $kitchen_rating = (int) $_POST['kitchen_rating'];

    // Get TenantID from session
    $tenant_id = $_SESSION['TenantID'];

    // Prepare and execute the SQL statement to insert the review
    $sql = "INSERT INTO room_reviews (room_id, TenantID, review_comment, room_rating, bh_rating, cr_rating, beds_rating, kitchen_rating, review_date) VALUES ('$room_id', '$tenant_id', '$review_comment', '$room_rating', '$bh_rating', '$cr_rating', '$beds_rating', '$kitchen_rating', CURDATE())";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Review successfully inserted
        echo json_encode(array('success' => true, 'message' => 'Review added successfully.'));
    } else {
        // Error inserting review
        echo json_encode(array('success' => false, 'message' => 'Error adding review. Please try again later.'));
    }
} else {
    // Missing required fields
    echo json_encode(array('success' => false, 'message' => 'Missing required fields.'));
}

// Close the database connection
mysqli_close($conn);
?>
