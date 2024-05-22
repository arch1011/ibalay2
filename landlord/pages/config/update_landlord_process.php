<?php
session_start(); // Start the session if not already started

        // Check if landlord_id is set in the session
        if (!isset($_SESSION['landlord_id'])) {
            // Redirect or handle the case where landlord_id is not set
            exit('landlord_id not set in session');
        }
        
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
    // Include database connection
    include_once "db_connection.php";

    // Get the landlord ID from the session
    $landlord_id = $_SESSION['landlord_id'];

    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    // Update landlord information in the database
    $sql = "UPDATE landlord_acc SET first_name = ?, last_name = ?, email = ?, phone_number = ?, address = ? WHERE landlord_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssssi', $first_name, $last_name, $email, $phone_number, $address, $landlord_id);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to a success page or show a success message
        header("Location: /iBalay/landlord/pages/profile.php?update=success");
        exit;
    } else {
        // Redirect to an error page or show an error message
        header("Location: /iBalay/landlord/pages/profile.php?update=error");
        exit;
    }

    // Close statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // If the form is not submitted, redirect to an error page or show an error message
    header("Location: error.php");
    exit;
}
?>
