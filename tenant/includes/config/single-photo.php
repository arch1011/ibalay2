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

// Set character set to UTF-8
mysqli_set_charset($conn, 'utf8');

// Ensure room details are fetched
$room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : null;
$room = null;

if ($room_id) {
    $query = "
        SELECT 
            r.room_id,
            r.room_price,
            r.room_number,
            r.landlord_id,
            r.capacity,
            r.room_photo1,
            r.room_photo2,
            r.description AS room_description,   
            b.BH_address,
            b.number_of_kitchen
        FROM 
            room r
        JOIN 
            bh_information b
        ON 
            r.landlord_id = b.landlord_id
        WHERE
            r.room_id = ?
    ";
    $stmt = mysqli_prepare($conn, $query);
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

    if (mysqli_num_rows($result) > 0) {
        $room = mysqli_fetch_assoc($result);
    } else {
        $room = null; // If no results found, set room to null
    }

    mysqli_free_result($result);
}

mysqli_close($conn); // Close connection

if ($room) {
  $room_photo_path1 = "/iBalay/uploads/roomphotos/room{$room['room_number']}_landlord{$room['landlord_id']}/{$room['room_photo1']}";
  $room_photo_path2 = "/iBalay/uploads/roomphotos/room{$room['room_number']}_landlord{$room['landlord_id']}/{$room['room_photo2']}";
} else {
  // Fallback path
  $room_photo_path1 = "/iBalay/uploads/default_photo.jpeg"; // Default photo for first image
  $room_photo_path2 = "/iBalay/uploads/default_photo.jpeg"; // Default photo for second image
}

$image_path1 = file_exists($_SERVER['DOCUMENT_ROOT'] . $room_photo_path1) ? $room_photo_path1 : "/iBalay/uploads/default_photo.jpeg";
$image_path2 = file_exists($_SERVER['DOCUMENT_ROOT'] . $room_photo_path2) ? $room_photo_path2 : "/iBalay/uploads/default_photo.jpeg";


// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>