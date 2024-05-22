<?php
include '../database/config.php';

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to get icon class based on file extension
function getIconClass($filename) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    switch ($extension) {
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return 'fas fa-image'; // Icon class for image files
        case 'pdf':
            return 'fas fa-file-pdf'; // Icon class for PDF files
        case 'doc':
        case 'docx':
            return 'fas fa-file-word'; // Icon class for Word documents
        case 'txt':
            return 'fas fa-file-alt'; // Icon class for text files
        default:
            return 'fas fa-file'; // Default icon class for other file types
    }
}

// Check if landlord_id is set and is a valid number
if (isset($_POST['landlord_id']) && is_numeric($_POST['landlord_id'])) {
    $landlord_id = mysqli_real_escape_string($conn, $_POST['landlord_id']);

    // Fetch documents for the specified landlord ID from bh_information table
    $query = "SELECT Document1, Document2 FROM bh_information WHERE landlord_id = $landlord_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Extract document filenames from the result
        $documentsList = array_filter([$row['Document1'], $row['Document2']]);

        // Generate HTML for displaying documents with icons and download buttons
        $documentsHTML = '<ul class="documents-list">';
        foreach ($documentsList as $document) {
            // Trim to remove leading/trailing whitespaces
            $document = trim($document);

            // Use relative path for documents
            $documentPath = '/iBalay/uploads/documents/' . $document;

            // Get icon class based on file extension
            $iconClass = getIconClass($document);

            // Check if the file exists before displaying it
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $documentPath)) {
                // Use htmlspecialchars to prevent XSS attacks
                $document = htmlspecialchars($document);
                $documentsHTML .= '<li>';
                $documentsHTML .= '<i class="' . $iconClass . '"></i>';
                $documentsHTML .= '<span class="document-name">' . $document . '</span>';
                $documentsHTML .= '<a href="' . $documentPath . '" download="' . $document . '" class="btn btn-primary btn-download">Download</a>';
                $documentsHTML .= '</li>';
            } else {
                // Use htmlspecialchars to prevent XSS attacks
                $document = htmlspecialchars($document);
                $documentsHTML .= '<li>File not found: ' . $document . '</li>';
            }
        }
        $documentsHTML .= '</ul>';

        // Return the HTML
        echo $documentsHTML;
    } else {
        echo 'No documents found for this landlord';
    }
} else {
    echo 'Invalid landlord_id';
}

// Close the database connection
mysqli_close($conn);

?>
