<?php
            include '../database/config.php';

            // Turn on error reporting
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

// Get the owner ID from the POST request
$ownerId = $_POST['landlord_id'];

// Perform the database update query to set disable to 1
$sql = "UPDATE bh_information SET close_account = 1 WHERE landlord_id = '$ownerId'";

if (mysqli_query($conn, $sql)) {
    // Close the database connection
    mysqli_close($conn);
    
    // Redirect to owner-list-warning.php
    header("Location: /iBalay/iBalay-saso/owner-list-warning.php");
    exit();
} else {
    // If there is an error in the query, send an error response
    echo json_encode(array('success' => false, 'message' => 'Error disabling owner: ' . mysqli_error($conn)));
}

// Close the database connection
mysqli_close($conn);

?>
