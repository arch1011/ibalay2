<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'iBalay_System';
$username = 'root';
$password = '';

// Create a connection using MySQLi
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check for successful connection
if (!$conn) {
    error_log("Database connection failed: " . mysqli_connect_error(), 0);
    die("Connection failed. Please try again later.");
}

mysqli_set_charset($conn, 'utf8'); // Set character set to UTF-8

// Fetch room details
$room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : null;
$room = null;

if ($room_id) {
    // Fetch room reviews
    $reviews_query = "
        SELECT 
            rr.review_comment,
            rr.room_rating,
            rr.review_date,
            t.FirstName,
            t.LastName
        FROM 
            room_reviews rr
        JOIN 
            tenant t
        ON 
            rr.TenantID = t.TenantID
        WHERE 
            rr.room_id = ?
    ";
    
    $stmt = mysqli_prepare($conn, $reviews_query);
    if (!$stmt) {
        error_log("SQL Prepare Error: " . mysqli_error($conn), 0);
        die("Error preparing SQL query.");
    }
    
    mysqli_stmt_bind_param($stmt, 'i', $room_id);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    if ($result === false) {
        error_log("Get Result Error: " . mysqli_error($conn), 0);
        die("Error retrieving results.");
    }

    $reviews = mysqli_fetch_all($result, MYSQLI_ASSOC); // Fetch all reviews
    
    mysqli_free_result($result); // Free result set
}

mysqli_close($conn); // Close connection
?>