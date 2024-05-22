<?php
session_start();

if (!isset($_SESSION['landlord_id'])) {
    exit('landlord_id not set in session');
}

$landlord_id = $_SESSION['landlord_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenant_id = $_POST['tenant_id'];
    $room_number = $_POST['room_number'];

    $host = 'localhost';
    $dbname = 'iBalay_System';
    $username = 'root';
    $password = '';

    $conn = mysqli_connect($host, $username, $password, $dbname);

    if (!$conn) {
        error_log("Database connection failed: " . mysqli_connect_error(), 0);
        die("Database connection failed. Please try again later.");
    }

    $query = "DELETE i
              FROM inquiry i
              INNER JOIN room r ON i.room_id = r.room_id
              WHERE i.tenant_id = ? AND r.room_number = ? AND i.landlord_id = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'isi', $tenant_id, $room_number, $landlord_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Inquiries deleted successfully.";
    } else {
        echo "No inquiries found or deletion failed.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("Location: /iBalay/landlord/pages/room_inquiry.php");
    exit();
}
?>
