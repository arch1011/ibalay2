<?php
  include('../layouts/header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Profile</title>

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <link href="../../assets/css/style.css" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <style>
  .carousel-item img {
    object-fit: cover; 
    width: 100%; 
    height: 250px; 
  }
    .btn-icon i {
        font-size: 0.8em; /* Adjust the size as needed */
    }
    .btn-icon {
        display: inline-block; /* Ensure buttons are inline */
        margin-right: 5px; /* Add some space between buttons */
    }
    .carousel-item img {
        object-fit: cover; /* Ensure the image covers the entire container */
        width: 100%; /* Ensure the image fills the entire container horizontally */
        height: 250px; /* Adjust the height as needed */
    }
  </style>

</head>

<body>

<?php
    require('../layouts/sidebar.php');
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Room inquiries</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inquire page</a></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  
  <?php
    session_start(); // Start the session if not already started

    // Check if LandlordID is set in the session
    if (!isset($_SESSION['landlord_id'])) {
        // Redirect or handle the case where LandlordID is not set
        exit('landlord_id not set in session');
    }

    $host = 'localhost';
    $dbname = 'iBalay_System';
    $username = 'root';
    $password = '';

    // Create a connection using MySQLi
    $conn = mysqli_connect($host, $username, $password, $dbname);

    // Check for successful connection
    if (!$conn) {
        error_log("Database connection failed: " . mysqli_connect_error(), 0);
        die("Database connection failed. Please try again later.");
    }

    // Set character set to UTF-8
    mysqli_set_charset($conn, 'utf8');

    // Turn on error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Get the landlord ID from the session
    $landlord_id = $_SESSION['landlord_id'];

    // Query to fetch inquiries along with related information
    $query = "SELECT i.inquiry_id, i.message, i.sent_by,  CONCAT(t.FirstName, ' ', t.LastName) AS TenantName, CONCAT(la.first_name, ' ', la.last_name) AS LandlordName, r.room_number, i.timestamp, i.tenant_id
              FROM inquiry AS i
              INNER JOIN tenant AS t ON i.tenant_id = t.TenantID
              INNER JOIN room AS r ON i.room_id = r.room_id
              INNER JOIN landlord_acc AS la ON i.landlord_id = la.landlord_id
              WHERE i.landlord_id = $landlord_id";

    $result = mysqli_query($conn, $query);

    $inquiries = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $key = $row['room_number'] . '-' . $row['tenant_id'];
            if (!isset($inquiries[$key])) {
                $inquiries[$key] = [
                    'TenantName' => $row['TenantName'],
                    'room_number' => $row['room_number'],
                    'inquiries' => [],
                ];
            }
            $inquiries[$key]['inquiries'][] = $row;
        }
    }

    // Close the result set
    mysqli_free_result($result);

    // Close the database connection
    mysqli_close($conn);
  ?>

<div class="card" style="font-size: 10px;">
    <div class="card-body">
        <h5 class="card-title" style="font-size: 18px;">Datatables</h5>
        <!-- Table with stripped rows -->
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Room Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inquiries as $roomKey => $roomData): ?>
                    <?php $firstInquiry = reset($roomData['inquiries']); ?>
                    <tr>
                        <td><?= htmlspecialchars($roomData['TenantName']) ?></td>
                        <td><?= htmlspecialchars($roomData['room_number']) ?></td>
                        <td>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-icon" data-bs-toggle="modal" data-bs-target="#inquiryModal<?= htmlspecialchars($roomKey) ?>" aria-label="View Inquiry">
        <i class="bi bi-eye"></i>
    </button>
    <form method="post" action="delete_inquiry.php" style="display:inline;">
        <input type="hidden" name="tenant_id" value="<?= htmlspecialchars($firstInquiry['tenant_id']) ?>">
        <input type="hidden" name="room_number" value="<?= htmlspecialchars($roomData['room_number']) ?>">
        <button type="submit" class="btn btn-danger btn-icon" aria-label="Delete Inquiry">
            <i class="bi bi-trash"></i>
        </button>
    </form>
</td>


                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>

    <?php foreach ($inquiries as $roomKey => $roomData): ?>
    <!-- Modal -->
    <div class="modal fade" id="inquiryModal<?= htmlspecialchars($roomKey) ?>" tabindex="-1" aria-labelledby="inquiryModalLabel<?= htmlspecialchars($roomKey) ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inquiryModalLabel<?= htmlspecialchars($roomKey) ?>">Inquiry Details</h5>
                </div>
                <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tenant Name:</strong> <?= htmlspecialchars($roomData['TenantName']) ?></p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p><strong>Room Number:</strong> <?= htmlspecialchars($roomData['room_number']) ?></p>
                        </div>
                    </div>
                    <hr>
                    <?php foreach ($roomData['inquiries'] as $inquiry): ?>
                        <div class="message-box">
                            <p><strong><?= ($inquiry['sent_by'] === 'landlord') ? 'Landlord' : 'Tenant' ?>:</strong> <?= htmlspecialchars($inquiry['message']) ?></p>
                        </div>

                        <?php if (!empty($inquiry['reply'])): ?>
                            <p><strong>Owner's Reply:</strong></p>
                            <p><?= htmlspecialchars($inquiry['reply']) ?></p>
                            <hr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    
                    <!-- Reply Form -->
                    <form method="post" action="submit_reply.php">
                        <div class="mb-3">
                            <label for="replyMessage" class="form-label">Your Reply</label>
                            <textarea class="form-control" id="replyMessage" name="replyMessage" rows="3" required></textarea>
                        </div>
                        <input type="hidden" name="inquiry_id" value="<?= htmlspecialchars($inquiry['inquiry_id']) ?>">
                        <button type="submit" class="btn btn-primary">Submit Reply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
<?php endforeach; ?>


</div>

</main><!-- End #main -->
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<script src="../../assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/vendor/chart.js/chart.umd.js"></script>
<script src="../../assets/vendor/echarts/echarts.min.js"></script>
<script src="../../assets/vendor/quill/quill.js"></script>
<script src="../../assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="../../assets/vendor/tinymce/tinymce.min.js"></script>
<script src="../../assets/vendor/php-email-form/validate.js"></script>
<script src="../../assets/js/main.js"></script>

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
