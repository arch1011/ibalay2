<?php
// Start a session to manage user login state
session_start();

// Helper function to send JSON response
function send_json_response($success, $message = '', $redirectURL = '') {
    header('Content-Type: application/json');
    $response = ['success' => $success];
    if ($message) {
        $response['message'] = $message;
    }
    if ($redirectURL) {
        $response['redirectURL'] = $redirectURL;
    }
    echo json_encode($response);
    exit();
}

// Check if the user is already logged in; if so, redirect to the dashboard
if (isset($_SESSION['TenantID'])) {
    send_json_response(true, '', '/iBalay/tenant/public/home.php');
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include the database connection file
    include ('../../../database/config.php');

    // Get the submitted email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Perform authentication using the database connection
    $sql = "SELECT TenantID, Password FROM tenant WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($TenantID, $stored_password);
        $stmt->fetch();

        // Check if the stored password matches the submitted password
        if (password_verify($password, $stored_password)) {
            // Password is hashed and correct, set session variables
            $_SESSION['TenantID'] = $TenantID;
            send_json_response(true, '', '/iBalay/tenant/index.php');
        } elseif ($password === $stored_password) {
            // Password is in plaintext and correct, set session variables
            $_SESSION['TenantID'] = $TenantID;
            send_json_response(true, '', '/iBalay/tenant/index.php');
        } else {
            // Password is incorrect, display an error message
            send_json_response(false, 'Invalid email or password.');
        }
    } else {
        // If login fails, you can display an error message here.
        send_json_response(false, 'Invalid email or password.');
    }
}

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Redirect to error page if the dashboard URL is not found
send_json_response(false, 'An error occurred.');
?>
