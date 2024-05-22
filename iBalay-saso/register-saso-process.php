<?php
include '../database/config.php';

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $rawPassword = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password
    $hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT);

    // Handle photo upload
    $photo = null;
    if ($_FILES['photo']['size'] > 0) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/iBalay/uploads/';
        $uniqueFilename = uniqid() . '_' . basename($_FILES['photo']['name']);
        $targetFile = $targetDir . $uniqueFilename;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
            $photo = $uniqueFilename;
        } else {
            // Handle photo upload failure
            echo 'Error uploading photo';
            exit; // Stop processing if photo upload fails
        }
    }

    // Insert data into the saso table
    $insertQuery = "INSERT INTO saso (username, password, photo) VALUES ('$username', '$hashedPassword', '$photo')";

    if (mysqli_query($conn, $insertQuery)) {
        header("Location: /iBalay/iBalay-saso/register-saso.php");
    } else {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
 