<?php
include '../database/config.php';

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the owner ID from the POST data
    $ownerId = $_POST['bh_id'];

    // Update the approval status in the database
    $updateQuery = "UPDATE bh_information SET Status = '1' WHERE bh_id = $ownerId";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo 'Owner approved successfully';
    } else {
        echo 'Error approving owner: ' . mysqli_error($conn);
    }
} else {
    echo 'Invalid request method';
}
?>
 