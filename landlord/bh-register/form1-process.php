<?php
session_start(); // Ensure session is started to get the landlord_id

// Redirect to login if not authenticated
if (!isset($_SESSION['landlord_id'])) {
    header('Location: /iBalay/landlord/authlog/login.php');
    exit;
}

include('../../database/config.php'); // Database configuration

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validate and sanitize form data
$BH_name = htmlspecialchars($_POST['BH_name'], ENT_QUOTES, 'UTF-8');
$BH_Address = htmlspecialchars($_POST['User_Address'], ENT_QUOTES, 'UTF-8');
$landlord_id = $_SESSION['landlord_id'];

$latitude = isset($_POST['Latitude']) ? (float)$_POST['Latitude'] : null;
$longitude = isset($_POST['Longitude']) ? (float)$_POST['Longitude'] : null;


// Allowed document MIME types
$allowed_mime_types = [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

// Function to handle document uploads with MIME type validation
function uploadDocument($file, $target_dir, $allowed_mime_types, $max_size = 2000000) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'File upload error'];
    }

    $tmp_name = $file['tmp_name'];
    $name = uniqid() . "_" . basename($file['name']); // Unique file name
    $target_file = $target_dir . '/' . $name;

    // Validate MIME type
    $file_mime_type = mime_content_type($tmp_name);
    if (!in_array($file_mime_type, $allowed_mime_types)) {
        return ['success' => false, 'message' => 'Invalid file type'];
    }

    // Check file size
    if ($file['size'] > $max_size) {
        return ['success' => false, 'message' => 'File size exceeds limit'];
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($tmp_name, $target_file)) {
        return ['success' => true, 'path' => $target_file];
    } else {
        return ['success' => false, 'message' => 'Error moving uploaded file'];
    }
}

// Directory handling for document uploads
$landlord_folder = 'landlord_' . $landlord_id;
$target_dir = $_SERVER['DOCUMENT_ROOT'] . '/iBalay/uploads/documents/' . $landlord_folder;

if (!is_dir($target_dir)) {
    if (!mkdir($target_dir, 0777, true)) {
        die("Error: Could not create the directory for uploads.");
    }
}

// Handle document uploads
$document1 = $_FILES['Document1'] ?? null;
$document2 = $_FILES['Document2'] ?? null;

$doc1_result = $document1 ? uploadDocument($document1, $target_dir, $allowed_mime_types) : null;
$doc2_result = $document2 ? uploadDocument($document2, $target_dir, $allowed_mime_types) : null;

if ($doc1_result && !$doc1_result['success']) {
    die("Error with Document1: " . $doc1_result['message']);
}

if ($doc2_result && !$doc2_result['success']) {
    die("Error with Document2: " . $doc2_result['message']);
}

// Function to extract file name from path
function extractFileName($path) {
    return basename($path);
}

// Insert into the database, including longitude and latitude
$query = "INSERT INTO bh_information (BH_name, BH_Address, Document1, Document2, landlord_id, latitude, longitude) 
          VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);

// Extract file names
$doc1_name = $doc1_result ? extractFileName($doc1_result['path']) : null;
$doc2_name = $doc2_result ? extractFileName($doc2_result['path']) : null;

$stmt->bind_param("ssssidd", $BH_name, $BH_Address, $doc1_name, $doc2_name, $landlord_id, $latitude, $longitude);

if ($stmt->execute()) {
    header('Location: /iBalay/landlord/bh-register/bh-status.php'); 
    exit;
} else {
    echo "Error registering boarding house: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
