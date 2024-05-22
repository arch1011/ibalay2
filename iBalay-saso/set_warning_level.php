<?php
include '../database/config.php';

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the warning level and owner ID from the AJAX request
$warningLevel = $_POST['warning_level'];
$ownerId = $_POST['landlord_id'];

// Perform the database update query to set warning level
$sql = "UPDATE bh_information SET warnings = $warningLevel WHERE landlord_id = $ownerId";

if (mysqli_query($conn, $sql)) {
    // If the query is successful, redirect to the specified URL
    header('Location: owner-list-warning.php');
    exit(); // Terminate script execution after redirection
} else {
    // If there is an error in the query, send an error response
    echo json_encode(array('success' => false, 'message' => 'Error updating warning level: ' . mysqli_error($conn)));
}

// Close the database connection
mysqli_close($conn);
?>
