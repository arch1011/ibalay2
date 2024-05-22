<?php include 'sidebar.php'; ?>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Landlord's Property</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/iBalay/iBalay-saso/index.php">Home</a></li>
                    <li class="breadcrumb-item active">Landlord's Property</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <!-- Start Room List -->
            <?php
            include '../database/config.php';

            // Turn on error reporting
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            // Function to shorten room description
            function shortenDescription($description, $maxLength = 50) {
                if (strlen($description) > $maxLength) {
                    return substr($description, 0, $maxLength) . '...';
                }
                return $description;
            }

            // Retrieve the landlord ID from the URL
            if (isset($_GET['landlord_id'])) {
                $landlord_id = $_GET['landlord_id'];
                $landlord_id = mysqli_real_escape_string($conn, $landlord_id); // Sanitize the input

                // Query to get rooms along with boarding house name and gender category
                $sqlRooms = "
                    SELECT r.*, b.BH_name, b.gender_allowed
                    FROM room r
                    JOIN bh_information b ON r.landlord_id = b.landlord_id
                    WHERE r.landlord_id = '$landlord_id'
                ";

                $resultRooms = mysqli_query($conn, $sqlRooms);

                if ($resultRooms && mysqli_num_rows($resultRooms) > 0) {
                ?>
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Rooms</h5>
                                <table class="table table-borderless datatable" id="roomTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Boarding House Name</th>
                                            <th scope="col">Room Number</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Capacity</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($rowRoom = mysqli_fetch_assoc($resultRooms)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $rowRoom['BH_name']; ?></td>
                                                <td><?php echo $rowRoom['room_number']; ?></td>
                                                <td class="room-description"><?php echo shortenDescription($rowRoom['description']); ?></td>
                                                <td><?php echo $rowRoom['capacity']; ?></td>
                                                <td><?php echo $rowRoom['room_price']; ?></td>
                                                <td><?php echo ucfirst($rowRoom['gender_allowed']); ?></td>
                                                <td>
                                                    <!-- Add your room actions buttons here -->
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
                    echo '<div class="alert" style="background-color: #fff3cd; border: 1px solid #ffeeba; color: #856404;">';
                    echo '<p>Landlord has no added Rooms yet!.</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No landlord ID provided.</p>';
            }

            mysqli_close($conn);
            ?>
            <!-- End Room List -->
        </section>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
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
