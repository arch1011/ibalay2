<?php
// Include the database connection file
include 'connect_db/connection.php';

// Check if the report ID is provided through a POST request
if (isset($_POST['report_id'])) {
    $reportID = $_POST['report_id'];

    // Prepare the DELETE query
    $deleteQuery = "DELETE FROM report WHERE ReportID = $reportID";

    // Perform the deletion
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        // Report successfully deleted
        header("Location: /iBalay.com/iBalay-saso/report-page.php"); // Redirect to the desired page after deletion
        exit();
    } else {
        // Handle the deletion error
        echo 'Error deleting report: ' . mysqli_error($conn);
    }
} else {
    // If report ID is not provided, redirect to an error page or handle accordingly
    header("Location: /iBalay.com/iBalay-saso/error.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
