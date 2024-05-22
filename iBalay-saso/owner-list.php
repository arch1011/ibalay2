<?php require 'sidebar.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SASO ADMIN</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="assets/img/evsu.png" rel="icon">
    <link href="assets/img/evsu.png" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Add these lines to include necessary DataTables and Buttons CSS files -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    
    <!-- Add jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
    .documents-list {
        list-style-type: none;
        padding: 0;
    }

    .documents-list li {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .documents-list li .document-name {
        margin-right: auto;
        margin-left: 10px;
    }

    .documents-list li .btn-download {
        margin-left: 10px;
    }
    </style>

</head>

<body>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Landlords</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/iBalay/iBalay-saso/index.php">Home</a></li>
                <li class="breadcrumb-item active">Landlord Lists</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <!--========================================================= Start Owner List ============================================-->
        <?php
        include '../database/config.php';

        // Turn on error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Your SQL query to get owners
        $sqlOwners = "SELECT * FROM landlord_acc";

        $resultOwners = mysqli_query($conn, $sqlOwners);

        if ($resultOwners && mysqli_num_rows($resultOwners) > 0) {
        ?>
        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Landlords</h5>
                    <table class="table table-borderless datatable" id="roomTable">
                        <thead>
                            <tr>
                                <th scope="col">Landlord Name</th>
                                <th scope="col">Contact Number</th>
                                <th scope="col">Email</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($rowOwner = mysqli_fetch_assoc($resultOwners)) {
                            ?>
                            <tr>
                                <td><?php echo $rowOwner['first_name']; ?></td>
                                <td><?php echo $rowOwner['phone_number']; ?></td>
                                <td><?php echo $rowOwner['email']; ?></td>
                                <td>
                                    <a href="owner-property.php?landlord_id=<?php echo $rowOwner['landlord_id']; ?>" class="btn btn-primary btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="generate_excel.php?landlord_id=<?php echo $rowOwner['landlord_id']; ?>" class="btn btn-success btn-sm">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <button class="btn btn-primary view-documents-btn" data-landlord-id="<?php echo $rowOwner['landlord_id']; ?>"> 
                                        <i class="bi bi-file-text"></i>
                                    </button>

                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
document.addEventListener("DOMContentLoaded", () => {
    const viewDocumentsButtons = document.querySelectorAll('.view-documents-btn');

    viewDocumentsButtons.forEach(button => {
        button.addEventListener('click', () => {
            const landlordId = button.getAttribute('data-landlord-id');
            viewDocuments(landlordId);
        });
    });
});


            function viewDocuments(landlord_id) {
    // Use AJAX to fetch the document list
    $.ajax({
        type: 'POST',
        url: 'fetch_documents.php',
        data: { landlord_id: landlord_id }, // Change ownerId to landlord_id
        success: function(response) {
            // Update the modal body with the fetched documents
            $('#documentsModalBody').html(response);

            // Show the modal
            $('#documentsModal').modal('show');

            // Initialize document navigation
            currentDocumentIndex = 0;
            documentsCount = $('.document').length;
            updateDocumentNavigation();
        },
        error: function(error) {
            console.error('Error fetching documents:', error);
        }
    });
}

            var currentDocumentIndex = 0;
            var documentsCount = 0;

            function nextDocument() {
                currentDocumentIndex++;
                if (currentDocumentIndex >= documentsCount) {
                    currentDocumentIndex = 0;
                }
                updateDocumentNavigation();
            }

            function prevDocument() {
                currentDocumentIndex--;
                if (currentDocumentIndex < 0) {
                    currentDocumentIndex = documentsCount - 1;
                }
                updateDocumentNavigation();
            }

            function updateDocumentNavigation() {
                $('.document').hide();
                $('.document').eq(currentDocumentIndex).show();
            }
        </script>
        <?php
        } else {
            // Display a message if there are no owners
            echo '<p>No owners found.</p>';
        }

        // Close the database connection if needed
        mysqli_close($conn);
        ?>
        <!--========================================================= end Owner List ============================================-->
    </section>

    <!-- Modal for displaying documents -->
    <div class="modal fade" id="documentsModal" tabindex="-1" role="dialog" aria-labelledby="documentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentsModalLabel">Landlord Uploaded Documents</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="documentsModalBody">
                    <!-- Documents will be displayed here -->
                </div>
            </div>
        </div>
    </div>

</main><!-- End #main -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Add jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>

<!-- Vendor JS Files -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.min.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<script>
$(document).ready(function() {
    var table = $('#roomTable').DataTable({
        dom: 'Bfrtip',
        buttons: ['pdf', 'excel', 'copy', 'print']
    });

    table.buttons().container().appendTo($('#roomTable_wrapper .dataTables_filter'));
});
</script>

</body>
</html>
