<?php
session_start(); // Start the session

// Ensure landlord is logged in
if (!isset($_SESSION['landlord_id'])) {
    die("Error: Landlord ID not found in the session.");
}

$landlord_id = $_SESSION['landlord_id'];

// Include database connection
include('../../../../database/config.php');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure all required POST data is set
if (
    isset($_POST['room_id']) &&
    isset($_POST['room_number']) &&
    isset($_POST['description']) &&
    isset($_POST['capacity']) &&
    isset($_POST['room_price'])
) {
    // Retrieve and sanitize form data
    $room_id = (int)$_POST['room_id'];
    $room_number = (int)$_POST['room_number'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $capacity = (int)$_POST['capacity'];
    $room_price = (float)$_POST['room_price'];

    // Fetch current room data
    $query = "SELECT room_photo1, room_photo2 FROM room WHERE room_id = ? AND landlord_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $room_id, $landlord_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $current_room = $result->fetch_assoc();
        $room_directory = $_SERVER['DOCUMENT_ROOT'] . "/iBalay/uploads/roomphotos/room{$room_number}_landlord{$landlord_id}/";

        // Ensure the directory exists
        if (!file_exists($room_directory)) {
            mkdir($room_directory, 0777, true);
        }

        // File handling
        function create_unique_filename($room_directory, $original_filename) {
            $file_extension = pathinfo($original_filename, PATHINFO_EXTENSION);
            $base_name = "photo_" . uniqid(); 
            $final_name = "$base_name.$file_extension";
            while (file_exists($room_directory . $final_name)) {
                $base_name = "photo_" . uniqid();
                $final_name = "$base_name.$file_extension";
            }
            return $final_name;
        }

        // Update photo filenames if new files are uploaded
        $filename1 = $current_room['room_photo1'];
        if (isset($_FILES['room_photo1']) && $_FILES['room_photo1']['error'] === UPLOAD_ERR_OK) {
            $filename1 = create_unique_filename($room_directory, $_FILES['room_photo1']['name']);
            $filepath1 = $room_directory . $filename1;
            move_uploaded_file($_FILES['room_photo1']['tmp_name'], $filepath1);
        }

        $filename2 = $current_room['room_photo2'];
        if (isset($_FILES['room_photo2']) && $_FILES['room_photo2']['error'] === UPLOAD_ERR_OK) {
            $filename2 = create_unique_filename($room_directory, $_FILES['room_photo2']['name']);
            $filepath2 = $room_directory . $filename2;
            move_uploaded_file($_FILES['room_photo2']['tmp_name'], $filepath2);
        }

        // Update room information
        $sql = "UPDATE room 
                SET room_number = ?, description = ?, capacity = ?, room_price = ?, room_photo1 = ?, room_photo2 = ? 
                WHERE room_id = ? AND landlord_id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isiissii', $room_number, $description, $capacity, $room_price, $filename1, $filename2, $room_id, $landlord_id);
        
        if ($stmt->execute()) {
            echo "Room updated successfully!";
        } else {
            echo "Error updating room: " . $stmt->error;
        }

    } else {
        echo "Error: Room not found or permission denied.";
    }

} else {
    echo "Error: Missing required data.";
}

// Close the database connection
$conn->close();
?>
