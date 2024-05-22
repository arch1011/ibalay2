<?php
// Include database connection file
include 'connect_db/connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $contactNumber = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);

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

    // Insert data into the owners table
    $insertQuery = "INSERT INTO owners (username, password, name, contact_number, email, photo, location) VALUES ('$username', '$password', '$name', '$contactNumber', '$email', '$photo', '$location')";

    if (mysqli_query($conn, $insertQuery)) {
        header('location: /iBalay.com/iBalay-saso/owner-list.php');
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
