<?php
// Start a session to manage user login state
session_start();

// Include the database connection file
include ('../../../database/config.php');
// Check if the user is already logged in; if so, redirect to the dashboard
if (isset($_SESSION['TenantID'])) {
    header("Location: /iBalay/tenant/index.php"); // Replace with your actual dashboard page URL
    exit();
}

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (
        isset($_POST['FirstName']) &&
        isset($_POST['LastName']) &&
        isset($_POST['Email']) &&
        isset($_POST['PhoneNumber']) &&
        isset($_POST['Password']) &&
        isset($_POST['student_id']) &&
        isset($_POST['address']) &&
        isset($_POST['gender'])
    ) {
        // Retrieve user input from the form
        $FirstName = $_POST['FirstName'];
        $LastName = $_POST['LastName'];
        $Email = $_POST['Email'];
        $PhoneNumber = $_POST['PhoneNumber'];
        $Password = $_POST['Password'];
        $student_id = $_POST['student_id'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];

        // Perform any necessary validation on the input

        // Hash the password before storing it in the database
        $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

        // Insert user data into the "tenant" table
        $query = "INSERT INTO tenant (FirstName, LastName, Email, PhoneNumber, Password, student_id, address, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Execute the query (Note: Use prepared statements to prevent SQL injection)
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            die('Error in preparing statement: ' . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param('ssssssss', $FirstName, $LastName, $Email, $PhoneNumber, $hashedPassword, $student_id, $address, $gender);

    // Execute the statement
    $stmt->execute();
    
    if ($stmt->error) {
        die('Error in executing statement: ' . $stmt->error);
    }
    
    $stmt->close();
    
    // After successful registration, update the checked_out column to 1
    $updateQuery = "UPDATE tenant SET checked_out = 1, Evsu_student = 1 WHERE Email = ?";
    $updateStmt = $conn->prepare($updateQuery);
    
    if ($updateStmt === false) {
        die('Error in preparing update statement: ' . $conn->error);
    }
    
    // Bind parameter
    $updateStmt->bind_param('s', $Email);
    
    // Execute the update statement
    $updateStmt->execute();
    
    if ($updateStmt->error) {
        die('Error in executing update statement: ' . $updateStmt->error);
    }
    
    $updateStmt->close();
    
    // Redirect to the login page after successful registration
    header("Location: /iBalay.com/iBalay-student/login.php");
    exit();

    } else {
        // Print an error message if form data is not set
        die('Form data not received.');
    }
}
?>