<?php
// Database configuration
include('../../database/config.php');

// Start the session and get the landlord_id
session_start();

if (!isset($_SESSION['landlord_id'])) {
    header('Location: /iBalay/landlord/authlog/login.php');
    exit;
}

$landlord_id = $_SESSION['landlord_id'];

// Fetch room data for the current landlord
$query = "SELECT room_id, room_number, description, capacity, room_price, room_photo1, room_photo2, landlord_id FROM room WHERE landlord_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $landlord_id);

$rooms = [];

if ($stmt->execute()) {
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
} else {
    echo "Error retrieving rooms: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>