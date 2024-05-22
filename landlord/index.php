<?php
include('session.php'); // Session handling
include('../database/config.php'); // Database configuration

$landlord_id = $_SESSION['landlord_id']; // Get landlord ID from session

// Query to fetch the boarding house information for the current landlord
$query = "SELECT * FROM bh_information WHERE landlord_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $landlord_id);
$stmt->execute();
$result = $stmt->get_result();

// If no record, redirect to the BH registration page
if ($result->num_rows == 0) {
    header('Location: /iBalay/landlord/bh-register/bh-register.php');
    exit;
}

// Fetch the record if it exists
$bh_info = $result->fetch_assoc();

// Check if the key fields (BH_name, BH_address, Document1, Document2) are not null/empty
$all_fields_present = 
    !empty($bh_info['BH_name']) &&
    !empty($bh_info['BH_address']) &&
    !empty($bh_info['Document1']) &&
    !empty($bh_info['Document2']);

    if (isset($bh_info['number_of_kitchen'])) {
        // If condition is met, redirect to form 2
        header('Location: /iBalay/landlord/dashboard/home.php');
        exit;
    }
    // Check if the status is `1` and all fields are not null/empty
if ($all_fields_present && $bh_info['Status'] == 1) {
    // If condition is met, redirect to form 2
    header('Location: /iBalay/landlord/bh-register/bh_info.php');
    exit;
}

// Check if all basic fields are not null, regardless of status
if ($all_fields_present) {
    header('Location: /iBalay/landlord/bh-register/bh-status.php'); // Redirect to status page
    exit;
}



?>
