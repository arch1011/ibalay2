<?php
session_start();

include '../database/config.php';

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if landlord_id is set and is a valid number
if (isset($_POST['landlord_id']) && is_numeric($_POST['landlord_id'])) {
    $landlord_id = mysqli_real_escape_string($conn, $_POST['landlord_id']);

    // Directory handling for document uploads
    $landlord_folder = 'landlord_' . $landlord_id;
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/iBalay/uploads/documents/' . $landlord_folder;

    // Fetch documents for the specified landlord ID from bh_information table
    $query = "SELECT Document1, Document2 FROM bh_information WHERE landlord_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $landlord_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Generate HTML for displaying documents with icons and download buttons
            $documentsHTML = '<ul class="documents-list">';
            
            // Loop through each document and display it
            foreach ($row as $document) {
                if ($document) {
                    // Get the file name from the path
                    $documentName = basename($document);
                    // Construct the file path relative to the target directory
                    $documentPath = '/iBalay/uploads/documents/' . $landlord_folder . '/' . $documentName;
                    // Generate HTML for the document
                    $documentsHTML .= '<li>';
                    $documentsHTML .= '<i class="bi bi-file-text"></i>';
                    $documentsHTML .= '<span class="document-name">' . $documentName . '</span>';
                    $documentsHTML .= '<a href="' . $documentPath . '" download="' . $documentName . '" class="btn btn-primary btn-download">Download</a>';
                    $documentsHTML .= '</li>';
                }
            }
            $documentsHTML .= '</ul>';

            // Return the HTML
            echo $documentsHTML;
        } else {
            echo 'No documents found for this landlord';
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
} else {
    echo 'Invalid landlord_id';
}

// Close the database connection
mysqli_close($conn);
?>
