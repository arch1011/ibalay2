<?php
  include '../database/config.php';

  // Turn on error reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

// Check if ownerId is set
if (isset($_POST['landlord_id'])) {
    // Sanitize the input to prevent SQL injection
    $ownerId = mysqli_real_escape_string($conn, $_POST['landlord_id']);

    // Update the close_account status to 0 (unterminated) and reset warnings to 0
    $sql = "UPDATE bh_information SET close_account = 0, warnings = 0 WHERE landlord_id = $ownerId";

    if (mysqli_query($conn, $sql)) {
        // Return success response
        header("Location: /iBalay/iBalay-saso/owner-terminated-accounts.php");
        exit();
    } else {
        // Return error response
        http_response_code(500);
        echo 'Error: ' . mysqli_error($conn);
    }
} else {
    // Return error response if ownerId is not set
    http_response_code(400);
    echo 'Error: Owner ID is required.';
}

// Close the database connection
mysqli_close($conn);
?>
