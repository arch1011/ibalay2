<?php
include ('../../database/config.php');

// Validate and sanitize form inputs
$first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
$last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : null;
$address = isset($_POST['address']) ? trim($_POST['address']) : null;

// Ensure required fields are not empty
if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
    die("Error: All required fields must be filled.");
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: Invalid email format.");
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Prepare the SQL statement for insertion
$stmt = mysqli_prepare($conn, "INSERT INTO landlord_acc (first_name, last_name, email, password, phone_number, address) VALUES (?, ?, ?, ?, ?, ?)");

// Bind parameters and execute the statement
mysqli_stmt_bind_param($stmt, 'ssssss', $first_name, $last_name, $email, $hashed_password, $phone_number, $address);

if (mysqli_stmt_execute($stmt)) {
    $inserted_id = mysqli_insert_id($conn);
    header("Location: /iBalay/landlord/aauthlog/login.php");
    exit(); // It is a good practice to call exit() after a header redirect
} else {
    echo "Error registering landlord: " . mysqli_error($conn);
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
