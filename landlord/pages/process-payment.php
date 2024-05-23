<?php
session_start(); // Start the session if not already started

// Check if LandlordID is set in the session
if (!isset($_SESSION['landlord_id'])) {
    // Redirect or handle the case where LandlordID is not set
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

// Retrieve form data
$tenant_id = $_POST['tenant_id'];
$room_id = $_POST['room_id'];
$landlord_id = $_POST['landlord_id'];
$room_price = $_POST['room_price'];
$payment = $_POST['payment'];
$due_date = $_POST['due_date'];

// Insert record into rented_rooms table
$query1 = "INSERT INTO rented_rooms (room_id, TenantID, landlord_id, start_date, end_date) 
           VALUES (?, ?, ?, CURDATE(), ?)";

$stmt1 = mysqli_prepare($conn, $query1);

if ($stmt1) {
    // Calculate end date (due date) based on due_date input
    $end_date = date('Y-m-d', strtotime($due_date . ' +1 month'));

    // Bind parameters
    mysqli_stmt_bind_param($stmt1, "iiis", $room_id, $tenant_id, $landlord_id, $end_date);

    // Execute the statement
    if (mysqli_stmt_execute($stmt1)) {
        // Close the statement
        mysqli_stmt_close($stmt1);

        // Insert record into tenant_payments table
        $query2 = "INSERT INTO tenant_payments (rented_id, TenantID, room_id, landlord_id, payment_date, amount) 
                   VALUES (LAST_INSERT_ID(), ?, ?, ?, CURDATE(), ?)";

        $stmt2 = mysqli_prepare($conn, $query2);

        if ($stmt2) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt2, "iiid", $tenant_id, $room_id, $landlord_id, $payment);

            // Execute the statement
            mysqli_stmt_execute($stmt2);

            // Close the statement
            mysqli_stmt_close($stmt2);
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Decrement room capacity by 1
        $query3 = "UPDATE room SET capacity = capacity - 1 WHERE room_id = ?";
        $stmt3 = mysqli_prepare($conn, $query3);
        if ($stmt3) {
            mysqli_stmt_bind_param($stmt3, "i", $room_id);
            mysqli_stmt_execute($stmt3);
            mysqli_stmt_close($stmt3);
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Delete tenant's record from reserved_room table
        $query4 = "DELETE FROM reserved_room WHERE TenantID = ? AND room_id = ?";
        $stmt4 = mysqli_prepare($conn, $query4);
        if ($stmt4) {
            mysqli_stmt_bind_param($stmt4, "ii", $tenant_id, $room_id);
            mysqli_stmt_execute($stmt4);
            mysqli_stmt_close($stmt4);
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Update tenant's checked_out status to 0
        $query5 = "UPDATE tenant SET checked_out = 0 WHERE TenantID = ?";
        $stmt5 = mysqli_prepare($conn, $query5);
        if ($stmt5) {
            mysqli_stmt_bind_param($stmt5, "i", $tenant_id);
            mysqli_stmt_execute($stmt5);
            mysqli_stmt_close($stmt5);
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);

// Redirect to landlord dashboard after successful renting
header("Location: /iBalay/landlord/dashboard/home.php");
exit;
?>
