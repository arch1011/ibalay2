<?php
// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if reservation ID and action are set
    if (isset($_POST["reservation_id"]) && isset($_POST["action"])) {
        // Include database connection script
        include('../../database/config.php');
        
        // Sanitize and validate inputs
        $reservationId = mysqli_real_escape_string($conn, $_POST["reservation_id"]);
        $action = mysqli_real_escape_string($conn, $_POST["action"]);
        
        // Update the declined column in the reserved_room table
        if ($action === "decline") {
            // Start a transaction
            mysqli_begin_transaction($conn);
            
            // Update the declined column to 1 and other fields to null
            $query = "UPDATE reserved_room SET declined = 1, TenantID = NULL, room_id = NULL WHERE reserved_id = $reservationId";
            $result = mysqli_query($conn, $query);
            
            if ($result) {
                // Commit the transaction
                mysqli_commit($conn);
                echo "Success";
            } else {
                // Rollback the transaction in case of an error
                mysqli_rollback($conn);
                echo "Error updating reservation: " . mysqli_error($conn);
            }
        } else {
            echo "Invalid action";
        }
        
        // Close the connection
        mysqli_close($conn);
    } else {
        echo "Reservation ID and action not provided";
    }
} else {
    echo "Invalid request method";
}
?>
