<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $host = 'localhost';
    $dbname = 'iBalay_System';
    $username = 'root';
    $password = '';

    $conn = mysqli_connect($host, $username, $password, $dbname);

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Get the posted data
    $inquiry_id = $_POST['inquiry_id'];
    $replyMessage = mysqli_real_escape_string($conn, $_POST['replyMessage']);
    $landlord_id = $_SESSION['landlord_id'];

    // Update the inquiry with the reply
    $query = "INSERT INTO inquiry (room_id, landlord_id, tenant_id, message, sent_by)
              SELECT room_id, landlord_id, tenant_id, '$replyMessage', 'landlord'
              FROM inquiry
              WHERE inquiry_id = $inquiry_id";

    if (mysqli_query($conn, $query)) {
        echo "Reply submitted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);

    // Redirect back to the inquiries page (or handle as needed)
    header('Location: inquiries_page.php');
    exit;
}
?>
