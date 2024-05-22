<?php require 'sidebar.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SASO ADMIN</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/evsu.png" rel="icon">
    <link href="assets/img/evsu.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
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
</head>

<body>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Warning Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/iBalay.com/iBalay-saso/index.php">Home</a></li>
                    <li class="breadcrumb-item active">Warning Page</li>
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

            $sqlOwners = "SELECT b.BH_name, b.BH_address, b.Status, CONCAT(l.first_name, ' ', l.last_name) AS landlord_name, l.email, b.warnings, b.close_account, l.landlord_id
            FROM bh_information b
            INNER JOIN landlord_acc l ON b.landlord_id = l.landlord_id
            WHERE b.Status = '1'";
            
            $resultOwners = mysqli_query($conn, $sqlOwners);

            if ($resultOwners && mysqli_num_rows($resultOwners) > 0) {
            ?>
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Landlords BH Information</h5>
                            <table class="table table-borderless datatable" id="roomTable">
                                <thead>
                                    <tr>
                                        <th scope="col">BH Name</th>
                                        <th scope="col">BH Address</th>
                                        <th scope="col">Landlord Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Warning Level</th>
                                        <th scope="col">Actions</th> <!-- New column for actions -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($rowOwner = mysqli_fetch_assoc($resultOwners)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $rowOwner['BH_name']; ?></td>
                                            <td><?php echo $rowOwner['BH_address']; ?></td>
                                            <td><?php echo $rowOwner['landlord_name']; ?></td>
                                            <td><?php echo $rowOwner['email']; ?></td>
                                            <td><?php echo $rowOwner['warnings']; ?></td>
                                            <td>
                                                <?php if ($rowOwner['close_account'] == 1) { ?>
                                                    Account Terminated
                                                <?php } else { ?>
                                                    <form action="set_warning_level.php" method="post">
                                                        <input type="hidden" name="landlord_id" value="<?php echo $rowOwner['landlord_id']; ?>">
                                                        <button class="btn btn-danger btn-sm" name="warning_level" value="1" <?php echo $rowOwner['warnings'] >= 1 ? 'disabled' : ''; ?>>1</button>
                                                        <button class="btn btn-danger btn-sm" name="warning_level" value="2" <?php echo $rowOwner['warnings'] >= 2 ? 'disabled' : ''; ?>>2</button>
                                                        <button class="btn btn-danger btn-sm" name="warning_level" value="3" <?php echo $rowOwner['warnings'] >= 3 ? 'disabled' : ''; ?>>3</button>
                                                    </form>
                                                    <form action="terminate.php" method="post">
                                                        <input type="hidden" name="landlord_id" value="<?php echo $rowOwner['landlord_id']; ?>">
                                                        <input type="hidden" name="close_account" value="<?php echo $rowOwner['close_account']; ?>">
                                                        <button class="btn btn-danger btn-sm" name="terminate_owner" <?php echo $rowOwner['warnings'] < 3 || $rowOwner['close_account'] == 1 ? 'disabled' : ''; ?>>Terminate</button>
                                                    </form>
                                                <?php } ?>
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

            <?php
            } else {
                // Display a message if there are no owners
                echo '<p>No Boarding House found found.</p>';
            }

            // Close the database connection if needed
            mysqli_close($conn);
            ?>
            <!--========================================================= end Owner List ============================================-->

        </section>

    </main><!-- End #main -->


  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

 <!-- Add jQuery library -->
 <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Add these lines to include necessary DataTables and Buttons JS files -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.min.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<script>
    $(document).ready(function () {
        // Initialize DataTable with buttons
        var table = $('#roomTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'pdf', 'excel', 'copy', 'print'
            ]
        });

        // Move the buttons to the desired position (right end of the header)
        table.buttons().container().appendTo($('#roomTable_wrapper .dataTables_filter'));
    });
</script>

</body>

</html>