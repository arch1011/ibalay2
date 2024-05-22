
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
        <h1>Terminaed Boarding House Page</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/iBalay.com/iBalay-saso/index.php">Home</a></li>
            <li class="breadcrumb-item active">Terminated Boarding House Lists</li>
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

  $sqlOwners = "SELECT 
                      b.BH_name, 
                      CONCAT(l.first_name, ' ', l.last_name) AS landlord_name,
                      l.email, 
                      b.landlord_id,
                      l.phone_number, 
                      b.BH_address, 
                      CASE 
                          WHEN b.Status = '0' THEN 'Inactive'
                          WHEN b.Status = '1' THEN 'Active'
                          WHEN b.Status = '2' THEN 'Pending'
                          ELSE 'Unknown'
                      END AS status
              FROM bh_information b
              INNER JOIN landlord_acc l ON b.landlord_id = l.landlord_id
              WHERE b.close_account = 1";

  $resultOwners = mysqli_query($conn, $sqlOwners);

  if ($resultOwners && mysqli_num_rows($resultOwners) > 0) {
  ?>
      <div class="col-12">
          <div class="card recent-sales overflow-auto">
              <div class="card-body">
                  <h5 class="card-title">Terminated Landlords Information</h5>
                  <table class="table table-borderless datatable" id="roomTable">
                      <thead>
                          <tr>
                              <th scope="col">BH Name</th>
                              <th scope="col">Landlord Name</th>
                              <th scope="col">Email</th>
                              <th scope="col">Phone Number</th>
                              <th scope="col">BH Address</th>
                              <th scope="col">Status</th>
                              <th scope="col">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          while ($rowOwner = mysqli_fetch_assoc($resultOwners)) {
                          ?>
                              <tr>
                                  <td><?php echo $rowOwner['BH_name']; ?></td>
                                  <td><?php echo $rowOwner['landlord_name']; ?></td>
                                  <td><?php echo $rowOwner['email']; ?></td>
                                  <td><?php echo $rowOwner['phone_number']; ?></td>
                                  <td><?php echo $rowOwner['BH_address']; ?></td>
                                  <td><?php echo $rowOwner['status']; ?></td>
                                  <td>
                                   <button class="btn btn-primary btn-unterminate" data-owner-id="<?php echo $rowOwner['landlord_id']; ?>" data-bs-toggle="modal" data-bs-target="#confirmModal">Unterminate Account</button>
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
      // Display a message if there are no terminated landlords
      echo '<p>No Terminated Landlords Yet.</p>';
  }

  // Close the database connection if needed
  mysqli_close($conn);
  ?>

        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Are you sure you want to unterminate this account?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmUnterminate">Unterminate</button>
              </div>
            </div>
          </div>
        </div>
        <!--========================================================= end Owner List ============================================-->



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

    <!-- Bootstrap Bundle JS library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <!-- Custom Script for initializing the modal -->
  <script>
$(document).ready(function () {
    var landlord_idToUnterminate;

    // Function to capture owner ID when modal is shown
    $('#confirmModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        landlord_idToUnterminate = button.data('owner-id'); // Extract info from data-* attributes
    });

    $('#confirmUnterminate').click(function () {
        if (landlord_idToUnterminate) {
            $.ajax({
                url: 'unterminate_owner.php',
                method: 'POST',
                data: { landlord_id: landlord_idToUnterminate }, // Send the owner ID to the server
                success: function (response) {
                    // Handle success response, maybe reload the table or show a message
                    alert('Owner account unterminated successfully.');
                    $('#confirmModal').modal('hide');
                    // Reload the page
                    location.reload();
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    alert('Error occurred while unterminating owner account.');
                    console.error(xhr.responseText);
                    $('#confirmModal').modal('hide');
                }
            });
        }
    });
});

  </script>


    
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



