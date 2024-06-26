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
      <h1>Boarders</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/iBalay.com/iBalay-saso/index.php">Home</a></li>
          <li class="breadcrumb-item active">Boarders List</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

 <!--========================================================= Start Tenant List ============================================-->
 <?php
include '../database/config.php';

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Your SQL query to get distinct tenants with checked_out = 0 and join them with rented_rooms table
$sqlTenants = "SELECT DISTINCT
                t.FirstName, 
                t.LastName, 
                t.Email, 
                t.PhoneNumber, 
                t.gender, 
                t.student_id
              FROM tenant t
              INNER JOIN rented_rooms rr ON t.TenantID = rr.TenantID
              WHERE t.checked_out = 0";

$resultTenants = mysqli_query($conn, $sqlTenants);

if ($resultTenants && mysqli_num_rows($resultTenants) > 0) {
    ?>
    <div class="col-12">
        <div class="card recent-sales overflow-auto">
            <div class="card-body">
                <h5 class="card-title">Boarders Information</h5>
                <table class="table table-borderless datatable" id="roomTable">
                    <thead>
                        <tr>
                            <th scope="col">Boarder Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Gender</th>
                            <th scope="col"> Student ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($rowTenant = mysqli_fetch_assoc($resultTenants)) {
                            ?>
                            <tr>
                                <td><?php echo $rowTenant['FirstName'] . ' ' . $rowTenant['LastName']; ?></td>
                                <td><?php echo $rowTenant['Email']; ?></td>
                                <td><?php echo $rowTenant['PhoneNumber']; ?></td>
                                <td><?php echo $rowTenant['gender']; ?></td>
                                <td><?php echo $rowTenant['student_id']; ?></td>
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
        // JavaScript to handle button click and redirect
        document.addEventListener("DOMContentLoaded", () => {
            const viewTenantButtons = document.querySelectorAll('.view-tenant-btn');

            viewTenantButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tenantId = button.getAttribute('data-tenant-id');

                    // Store tenant ID in session storage
                    sessionStorage.setItem('selectedTenantId', tenantId);

                    // Redirect to tenant-details.php
                    window.location.href = 'tenant-details.php';
                });
            });
        });
    </script>
    <?php
} else {
    // Display a message if there are no tenants with checked_out = 0
    echo '<div class="alert" style="background-color: #fff3cd; border: 1px solid #ffeeba; color: #856404;">';
    echo '<p>No Boarders in iBalay.</p>';
    echo '</div>';
}

// Close the database connection if needed
mysqli_close($conn);
?>

<!--========================================================= End Tenant List ============================================-->




      </div>
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