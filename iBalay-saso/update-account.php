<?php
// Include your database connection
include 'connect_db/connection.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['saso_id'])) {
    // Redirect to the login page if not logged in
    header("Location: /iBalay.com/iBalay-saso/login.php");
    exit();
}

// Get the SASO ID from the session
$sasoID = $_SESSION['saso_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['password']);

    // Update username and password
    $updateSql = "UPDATE saso SET username = '$username'";
    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateSql .= ", password = '$hashedPassword'";
    }
    $updateSql .= " WHERE saso_id = '$sasoID'";

    $result = mysqli_query($conn, $updateSql);

    if ($result) {
        // Handle photo upload
        if ($_FILES['photo']['size'] > 0) {
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/iBalay.com/uploads/';
            $uniqueFilename = uniqid() . '_' . basename($_FILES['photo']['name']);
            $targetFile = $targetDir . $uniqueFilename;
        
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                // Update the database with the new photo filename
                $updatePhotoSql = "UPDATE saso SET photo = '$uniqueFilename' WHERE saso_id = '$sasoID'";
                mysqli_query($conn, $updatePhotoSql);
            } else {
                // Handle photo upload failure
                echo 'Error uploading photo';
            }
        }

        header("Location: /iBalay.com/iBalay-saso/account-setting.php"); // Redirect to the profile page
    } else {
        echo 'Error updating account';
    }
}

// Close the database connection
mysqli_close($conn);
?>
