<?php
session_start();

// Check if landlord_id is in the session
if (!isset($_SESSION['landlord_id'])) {
    die("Error: Landlord ID not found in the session.");
}

$landlord_id = $_SESSION['landlord_id'];

// Include database connection script
include('../../../../database/config.php');

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure all required POST and FILES data is set
if (
    isset($_POST['inputRoomNumber']) && !empty($_POST['inputRoomNumber']) &&
    isset($_POST['inputDescription']) && !empty($_POST['inputDescription']) &&
    isset($_POST['inputCapacity']) && !empty($_POST['inputCapacity']) &&
    isset($_POST['inputRoomPrice']) && !empty($_POST['inputRoomPrice']) &&
    isset($_FILES['inputRoomPhoto1']) && isset($_FILES['inputRoomPhoto2'])
) {
    // Sanitize and retrieve form data
    $room_number = (int)$_POST['inputRoomNumber'];
    $description = mysqli_real_escape_string($conn, $_POST['inputDescription']);
    $capacity = (int)$_POST['inputCapacity'];
    $room_price = (float)$_POST['inputRoomPrice'];

    // Define the room-specific upload directory
    $room_directory = $_SERVER['DOCUMENT_ROOT'] . "/iBalay/uploads/roomphotos/room{$room_number}_landlord{$landlord_id}/";

    // Ensure the directory exists
    if (!file_exists($room_directory)) {
        mkdir($room_directory, 0777, true); // Create the directory with appropriate permissions
    }

    // Function to create a unique filename
    function create_unique_filename($room_directory, $original_filename) {
        $file_extension = pathinfo($original_filename, PATHINFO_EXTENSION);
        $base_name = "photo_" . uniqid(); // Generate a unique ID
        $final_name = "$base_name.$file_extension";
        while (file_exists($room_directory . $final_name)) {
            // If a conflict occurs, generate a new unique ID
            $base_name = "photo_" . uniqid();
            $final_name = "$base_name.$file_extension";
        }
        return $final_name;
    }

    // Create unique filenames for the uploaded photos
    $filename1 = create_unique_filename($room_directory, $_FILES['inputRoomPhoto1']['name']);
    $filename2 = create_unique_filename($room_directory, $_FILES['inputRoomPhoto2']['name']);

    // Define the full paths to save the files
    $filepath1 = $room_directory . $filename1;
    $filepath2 = $room_directory . $filename2;

    // Move uploaded files to their designated location
    $uploaded1 = move_uploaded_file($_FILES['inputRoomPhoto1']['tmp_name'], $filepath1);
    $uploaded2 = move_uploaded_file($_FILES['inputRoomPhoto2']['tmp_name'], $filepath2);

    if ($uploaded1 && $uploaded2) {
        // If both files are successfully uploaded, insert the data into the database
        $sql = "INSERT INTO room (landlord_id, room_number, description, capacity, room_price, room_photo1, room_photo2)
                VALUES ('$landlord_id', '$room_number', '$description', '$capacity', '$room_price', '$filename1', '$filename2')";

        if (mysqli_query($conn, $sql)) {
            echo "Room added successfully!";
        } else {
            echo "Error: Could not insert room data into the database. " . mysqli_error($conn);
        }
    } else {
        echo "Error: File upload failed.";
    }
} else {
    echo "Error: Missing required data.";
}

// Close the database connection
mysqli_close($conn);
?>
