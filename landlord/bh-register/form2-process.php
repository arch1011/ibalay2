<?php
// Start session handling to retrieve session variables
session_start();

// Include the database connection configuration
include('../../database/config.php');

// Ensure the landlord's ID is available in the session
if (!isset($_SESSION['landlord_id'])) {
    die('Unauthorized access. Please log in to continue.'); // Proper error handling
}

// Retrieve the landlord's ID from the session
$landlord_id = $_SESSION['landlord_id'];

// Collect form data from POST request
$monthly_payment_rate = $_POST['monthly_payment_rate']; 
$number_of_kitchen = intval($_POST['number_of_kitchen']);
$number_of_living_room = intval($_POST['number_of_living_room']);
$number_of_students = intval($_POST['number_of_students']);
$number_of_cr = intval($_POST['number_of_cr']);
$number_of_beds = intval($_POST['number_of_beds']);
$number_of_rooms = intval($_POST['number_of_rooms']);
$bh_max_capacity = intval($_POST['bh_max_capacity']);
$gender_allowed = $_POST['gender_allowed'];

// Check if mandatory fields are empty
if (empty($monthly_payment_rate) || empty($gender_allowed)) {
    die('Required fields are missing. Please fill in the required information.');
}

// Prepare a parameterized SQL query to update the existing record
$query = "UPDATE bh_information 
          SET monthly_payment_rate = ?, number_of_kitchen = ?, 
              number_of_living_room = ?, number_of_students = ?, 
              number_of_cr = ?, number_of_beds = ?, number_of_rooms = ?, 
              bh_max_capacity = ?, gender_allowed = ?
          WHERE landlord_id = ?";

// Prepare the statement to avoid SQL injection
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('Database preparation error: ' . $conn->error);
}

// Bind parameters to the SQL query, including landlord_id at the end
$stmt->bind_param(
  "siiiiiiisi",
  $monthly_payment_rate,
  $number_of_kitchen,
  $number_of_living_room,
  $number_of_students,
  $number_of_cr,
  $number_of_beds,
  $number_of_rooms,
  $bh_max_capacity,
  $gender_allowed,
  $landlord_id // This should link to the record to be updated
);

// Execute the query and check for errors
if ($stmt->execute()) {
    header('location: /iBalay/landlord/dashboard/home.php');
    exit;
} else {
    echo "Error updating data: " . $stmt->error;
}

// Clean up resources
$stmt->close();
$conn->close();

?>
