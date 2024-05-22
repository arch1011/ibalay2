<?php
session_start();

include ('../../database/config.php');

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM landlord_acc WHERE email = ?"; 
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {

        $_SESSION['landlord_id'] = $user['landlord_id']; 

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid password.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
}

$stmt->close();
$conn->close();
?>
