<?php
header('Content-Type: application/json'); // Ensure the response is JSON

// Start session (if not already started)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if tenant ID is set in the session
if (!isset($_SESSION['TenantID'])) {
    // Redirect or handle the case when tenant ID is not set
    echo json_encode(['success' => false, 'message' => 'Tenant ID not set. Please log in.']);
    exit();
}

// Retrieve other form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure that the form fields are set
    if (isset($_POST['message']) && isset($_POST['room_id'])) {
        // Assign form data to variables
        $message = $_POST['message'];
        $room_id = $_POST['room_id'];

        // Database connection parameters
        $host = 'localhost';
        $dbname = 'iBalay_System';
        $username = 'root';
        $password = '';

        // Create connection using MySQLi
        $conn = new mysqli($host, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
            exit();
        }

        // Assuming landlord_id is not available in the session, you need to retrieve it based on the room_id
        $landlord_id = fetchLandlordId($conn, $room_id); // Implement this function

        if (!$landlord_id) {
            echo json_encode(['success' => false, 'message' => 'Failed to retrieve landlord ID.']);
            exit();
        }

        // Prepare SQL statement to insert inquiry data
        $sql = "INSERT INTO inquiry (room_id, landlord_id, tenant_id, message, sent_by) VALUES (?, ?, ?, ?, 'tenant')";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Statement preparation failed: ' . $conn->error]);
            exit();
        }
        $stmt->bind_param("iiis", $room_id, $landlord_id, $_SESSION['TenantID'], $message);

        // Execute the statement
        if ($stmt->execute()) {
            // Inquiry successfully submitted
            echo json_encode(['success' => true, 'message' => 'Inquiry sent successfully!']);
        } else {
            // Error handling if the inquiry submission fails
            echo json_encode(['success' => false, 'message' => 'Failed to send inquiry: ' . $stmt->error]);
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        // Handle case when form fields are not set
        echo json_encode(['success' => false, 'message' => 'Form fields are not set.']);
    }
} else {
    // Handle case when form method is not POST
    echo json_encode(['success' => false, 'message' => 'Form method is not POST.']);
}

function fetchLandlordId($conn, $room_id) {
    // Query to fetch landlord_id based on room_id
    $sql = "SELECT landlord_id FROM room WHERE room_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $room_id);
        $stmt->execute();
        $stmt->bind_result($landlord_id); // idk why this is an eror but its working
        if ($stmt->fetch()) {
            $stmt->close();
            return $landlord_id; //this is working idk why its red error line
        } else {
            $stmt->close();
            return false;
        }
    } else {
        return false;
    }
}

?>
