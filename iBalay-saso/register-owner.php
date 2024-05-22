<?php require 'sidebar.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SASO ADMIN</title>
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
    <link href="assets/css/style.css" rel="stylesheet">

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

    <?php
include '../database/config.php';

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

    // Fetch boarding houses with status 0 from the database
    $query = "SELECT bh.*, la.first_name, la.last_name, la.email, la.phone_number
            FROM bh_information bh
            INNER JOIN landlord_acc la ON bh.landlord_id = la.landlord_id
            WHERE bh.Status = '0'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($conn));
    }
    ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Pending Boarding House Request</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="https://ibalay-project.000webhostapp.com/iBalay.com/iBalay-saso/index.php">Home</a></li>
                    <li class="breadcrumb-item">List</li>
                    <li class="breadcrumb-item active">Data</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Landlords Boarding House Request Pending</h5>
                            <!-- Table with dynamic data from the database -->
                            <table id="ownersTable" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>BoardingHouse Name</th>
                                        <th>Landlord</th>
                                        <th>Email</th>
                                        <th>Contact Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Inside the while loop where you generate the DataTable rows -->
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>';
                                        echo '<td>' . $row['BH_name'] . '</td>';
                                        echo '<td>' . $row['first_name'] . ' ' . $row['last_name'] . '</td>';
                                        echo '<td>' . $row['email'] . '</td>';
                                        echo '<td>' . $row['phone_number'] . '</td>';
                                        echo '<td>';

                                        // View Documents Icon
                                        echo '<button class="btn btn-primary" onclick="viewDocuments(' . $row['bh_id'] . ')">';
                                        echo '<i class="bi bi-file-text"></i>'; // Bootstrap Icons file-text icon
                                        echo '</button>';

                                        // Add space between icons
                                        echo '<span style="margin-right: 5px;"></span>';

                                            // Approve Icon
                                            echo '<button class="btn btn-success" onclick="confirmApprove(' . $row['bh_id'] . ')">';
                                            echo '<i class="bi bi-check-lg"></i>'; // Bootstrap Icons check-lg icon
                                            echo '</button>';

                                            // Add space between icons
                                            echo '<span style="margin-right: 5px;"></span>';

                                            // Disapprove Icon
                                            echo '<button class="btn btn-danger" onclick="confirmDisapprove(' . $row['bh_id'] . ')">';
                                            echo '<i class="bi bi-x-lg"></i>'; // Bootstrap Icons x-lg icon for disapprove
                                            echo '</button>';


                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                    ?>


                                </tbody>
                            </table>
                            <!-- End Table with dynamic data from the database -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Modal for displaying documents -->
        <div class="modal fade" id="documentsModal" tabindex="-1" role="dialog" aria-labelledby="documentsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="documentsModalLabel">landlord Uploaded Documents</h5>
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

        <!-- Modal for confirmation -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cancelConfirmation()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="confirmationMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="cancelConfirmation()">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmAction">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <script>
        var currentDocumentIndex = 0;
        var documentsCount = 0;

        function viewDocuments(ownerId) {
            // Use AJAX to fetch the document list
            $.ajax({
                type: 'POST',
                url: 'fetch_documents.php',
                data: { ownerId: ownerId },
                success: function (response) {
                    // Update the modal body with the fetched documents
                    $('#documentsModalBody').html(response);

                    // Show the modal
                    $('#documentsModal').modal('show');

                    // Initialize document navigation
                    currentDocumentIndex = 0;
                    documentsCount = $('.document').length;
                    updateDocumentNavigation();
                },
                error: function (error) {
                    console.error('Error fetching documents:', error);
                }
            });
        }

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


    <script>
        // Function to handle canceling the confirmation modal
        function cancelConfirmation() {
            $('#confirmationModal').modal('hide'); // Hide the modal
        }

        function confirmApprove(bhId) {
    $('#confirmationMessage').text('Are you sure you want to approve this owner?');
    $('#confirmAction').attr('onclick', 'confirmAction(' + bhId + ', "approve")');
    $('#confirmationModal').modal('show');
}

function confirmDisapprove(bhId) {
    $('#confirmationMessage').text('Are you sure you want to disapprove this owner?');
    $('#confirmAction').attr('onclick', 'confirmAction(' + bhId + ', "disapprove")');
    $('#confirmationModal').modal('show');
}

function confirmAction(bhId, action) {
    console.log('Confirm Action:', action, 'for BH ID:', bhId); // Add this line
    $.ajax({
        type: 'POST',
        url: action === 'approve' ? 'approve_owner.php' : 'disapprove_owner.php',
        data: { bh_id: bhId }, // Pass bh_id instead of ownerId
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

    </script>

</body>

</html>

