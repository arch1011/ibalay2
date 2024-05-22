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

// Get the landlord ID from the session
$landlord_id = $_SESSION['landlord_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $tenant_id = isset($_POST['tenant_id']) ? intval($_POST['tenant_id']) : null;
    $payment_date = isset($_POST['payment_date']) ? $_POST['payment_date'] : null;
    $new_due_date = isset($_POST['new_due_date']) ? $_POST['new_due_date'] : null;
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : null;

    if ($tenant_id && $payment_date && $new_due_date && $amount) {
        // Fetch the rented_id and room_id from rented_rooms table for this tenant
        $stmt_fetch = $conn->prepare("SELECT rented_id, room_id FROM rented_rooms WHERE TenantID = ?");
        $stmt_fetch->bind_param("i", $tenant_id);
        $stmt_fetch->execute();
        $result_fetch = $stmt_fetch->get_result();

        if ($result_fetch->num_rows > 0) {
            $row = $result_fetch->fetch_assoc();
            $rented_id = $row['rented_id'];
            $room_id = $row['room_id'];

            // Insert new payment data into tenant_payments table
            $stmt_insert = $conn->prepare("INSERT INTO tenant_payments (rented_id, TenantID, room_id, landlord_id, payment_date, amount) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt_insert->bind_param("iiiisi", $rented_id, $tenant_id, $room_id, $landlord_id, $payment_date, $amount);

            if ($stmt_insert->execute()) {
                // Update the end_date in the rented_rooms table
                $stmt_update = $conn->prepare("UPDATE rented_rooms SET end_date = ? WHERE rented_id = ?");
                $stmt_update->bind_param("si", $new_due_date, $rented_id);

                if ($stmt_update->execute()) {
                    header ('location: /iBalay/landlord/tenant/payment-history.php');
                    exit;
                } else {
                    echo "Error updating due date: " . $stmt_update->error;
                }

                $stmt_update->close();
            } else {
                echo "Error recording payment: " . $stmt_insert->error;
            }

            $stmt_insert->close();
        } else {
            echo "Tenant record not found.";
        }

        $stmt_fetch->close();
    } else {
        echo "Invalid input data.";
    }
}

// Close the database connection
$conn->close();

?>
