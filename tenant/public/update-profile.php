<?php
session_start();

$host = 'localhost';
$dbname = 'iBalay_System';
$username = 'root';
$password = '';

// Create a connection using MySQLi
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check for successful connection
if (!$conn) {
    error_log("Database connection failed: " . mysqli_connect_error(), 0);
    die("Database connection failed. Please try again later.");
}

// Set character set to UTF-8
mysqli_set_charset($conn, 'utf8');

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if TenantID is set in the session
    if (!isset($_SESSION['TenantID'])) {
        // Redirect or handle the case where TenantID is not set
        exit('TenantID not set in session');
    }

    // Get the TenantID from the session
    $TenantID = $_SESSION['TenantID'];

    // Check if a file was uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['photo'];

        // Get the file name and extension
        $fileName = basename($file['name']);
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        // Generate a unique filename with TenantID and file extension
        $uniqueFileName = $TenantID . '_' . uniqid() . '.' . $fileExt;

        // Specify the upload directory
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/iBalay/uploads/tenant_profile/';

        // Create the directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Set the destination path
        $destination = $uploadDir . $uniqueFileName;

        // Move the uploaded file to the destination
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            // File uploaded successfully, update tenant's record in the database with the file name
            $query = "UPDATE tenant SET ProfilePhoto = '$uniqueFileName' WHERE TenantID = $TenantID";

            // Execute the update query
            if (mysqli_query($conn, $query)) {
                // Redirect to the profile page or show a success message
                header('Location: /iBalay/tenant/public/profile.php');
                exit;
            } else {
                // Error updating database record, handle accordingly
                echo "Error updating database record.";
            }
        } else {
            // Error moving file, handle accordingly
            echo "Error uploading file.";
        }
    } else {
        // No file uploaded or an error occurred, handle accordingly
        echo "No file uploaded or an error occurred.";
    }
} else {
    // Redirect or handle the case where the form is not submitted
    exit('Form not submitted.');
}
?>
