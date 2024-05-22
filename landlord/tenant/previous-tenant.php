<?php
  include('../layouts/header.php');
  ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Add Room</title>

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <link href="../../assets/css/style.css" rel="stylesheet">

</head>

<body> 

  <?php
    require('../layouts/sidebar.php');
  ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Your Previous Boarders!</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Boarder List</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

  <?php
    include('views/get-history-tenant.php');
  ?>

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

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-button');
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tenantId = this.getAttribute('data-id');
            fetch(`tasks/get-tenant-info.php?tenant_id=${tenantId}`)
                .then(response => response.json())
                .then(data => {
                    const modalBody = document.querySelector('#tenantModal .modal-body');
                    modalBody.innerHTML = `
                        <p><strong>Name:</strong> ${data.FirstName} ${data.LastName}</p>
                        <p><strong>Email:</strong> ${data.Email}</p>
                        <p><strong>Phone Number:</strong> ${data.PhoneNumber}</p>
                        <p><strong>Student ID:</strong> ${data.student_id}</p>
                        <p><strong>Gender:</strong> ${data.gender}</p>
                        <p><strong>Address:</strong> ${data.address}</p>
                    `;
                    const tenantModal = new bootstrap.Modal(document.getElementById('tenantModal'));
                    tenantModal.show();
                });
        });
    });
});
</script>


  <script src="../../assets/js/main.js"></script>
</body>

</html>