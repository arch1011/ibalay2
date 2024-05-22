<?php
                    include '../database/config.php';
                    
// Check if the report ID is received via POST
if(isset($_POST['report_id'])) {
    // Sanitize the input to prevent SQL injection
    $reportID = mysqli_real_escape_string($conn, $_POST['report_id']);

    // Update the report to mark it as acknowledged
    $updateQuery = "UPDATE report SET Acknowledge = 1 WHERE ReportID = $reportID";

    if(mysqli_query($conn, $updateQuery)) {
        // Report acknowledged successfully
        echo "Report acknowledged successfully";
    } else {
        // Error occurred while acknowledging the report
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Report ID not received
    echo "Report ID not provided";
}
?>
