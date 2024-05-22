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

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

</head>

<body>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Reports</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/iBalay.com/iBalay-saso/index.php">Home</a></li>
                <li class="breadcrumb-item active">Room Reports</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="container">

            <!-- Display reports in DataTable -->
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>BH Name</th>
                        <th>Report Date</th>
                        <th>Report Message</th>
                        <th>Action</th>
                        <th>Acknowledge</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    include '../database/config.php';

                    // Turn on error reporting
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);

                    $reportQuery = "SELECT report.*, room.room_number, tenant.FirstName, tenant.LastName, bh.BH_name, bh.BH_address, landlord_acc.first_name AS ownerName
                            FROM report
                            JOIN room ON report.room_id = room.room_id
                            JOIN tenant ON report.TenantID = tenant.TenantID
                            JOIN bh_information bh ON room.landlord_id = bh.landlord_id
                            JOIN landlord_acc ON room.landlord_id = landlord_acc.landlord_id
                            ORDER BY report.ReportDate ASC";

                    $reportResult = mysqli_query($conn, $reportQuery);

                    if ($reportResult) {
                        while ($report = mysqli_fetch_assoc($reportResult)) {
                            ?>
                            <tr>
                                <td><?php echo $report['BH_name']; ?></td>
                                <td><?php echo $report['ReportDate']; ?></td>
                                <td><?php echo $report['ReportText']; ?></td>
                                <td>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $report['ReportID']; ?>">View Report</button>
                                </td>
                                <td>
                                    <!-- Acknowledge button -->
                                    <button id="acknowledgeBtn<?php echo $report['ReportID']; ?>" class="btn btn-<?php echo $report['Acknowledge'] ? 'success' : 'primary'; ?>" onclick="acknowledgeReport(<?php echo $report['ReportID']; ?>)">
                                        <?php echo $report['Acknowledge'] ? '<i class="bi bi-check"></i>' : 'Acknowledge'; ?>
                                    </button>
                                </td>

                            </tr>

                            <!-- Modal for viewing detailed information -->
                            <div class="modal fade" id="viewModal<?php echo $report['ReportID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Report Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Tenant Name: <?php echo $report['FirstName'] . ' ' . $report['LastName']; ?></p>
                                            <p>Room Number: <?php echo $report['room_number']; ?></p>
                                            <p>Boarding House Name: <?php echo $report['BH_name']; ?></p>
                                            <p>Owner Name: <?php echo $report['ownerName']; ?></p>
                                            <p>Location: <?php echo $report['BH_address']; ?></p>
                                            <p>Report Message: <?php echo $report['ReportText']; ?></p>
                                            <!-- Add other details as needed -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    } else {
                        echo 'Error in SQL query: ' . mysqli_error($conn);
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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
$(document).ready(function() {
  $('.datatable').DataTable();
});

// JavaScript function to handle report deletion
function deleteReport(reportID) {
  // Use AJAX to send the report ID to the delete_report_process.php script
  $.ajax({
    type: "POST",
    url: "delete_report_process.php",
    data: {
      report_id: reportID
    },
    success: function(response) {
      // Reload the page after successful deletion
      location.reload();
    },
    error: function(xhr, ajaxOptions, thrownError) {
      // Handle error if needed
      console.log(xhr.status);
      console.log(thrownError);
    }
  });
}

function acknowledgeReport(reportID) {
  // Use AJAX to send the report ID to the acknowledge_report_process.php script
  $.ajax({
    type: "POST",
    url: "acknowledge_report_process.php",
    data: {
      report_id: reportID
    },
    success: function(response) {
      // Toggle acknowledgment status
      var acknowledgeBtn = document.getElementById('acknowledgeBtn' + reportID);
      if (acknowledgeBtn) {
        if (acknowledgeBtn.classList.contains('btn-primary')) {
          acknowledgeBtn.classList.remove('btn-primary');
          acknowledgeBtn.classList.add('btn-success');
          acknowledgeBtn.innerHTML = '<i class="bi bi-check"></i>';
          // Make the button unclickable
          acknowledgeBtn.disabled = true;
        } else {
          acknowledgeBtn.classList.remove('btn-success');
          acknowledgeBtn.classList.add('btn-primary');
          acknowledgeBtn.innerHTML = 'Acknowledge';
          // Make the button clickable
          acknowledgeBtn.disabled = false;
        }
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      // Handle error if needed
      console.log(xhr.status);
      console.log(thrownError);
    }
  });
}
</script>

</body>

</html>
