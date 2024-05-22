<?php
include('../../tenant/session.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Untree.co" />
    <link rel="shortcut icon" href="../../assets/img/evsufav.png" />

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap5" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href=".././../Resources/fonts/icomoon/style.css" />
    <link rel="stylesheet" href="../../Resources/fonts/flaticon/font/flaticon.css" />
    <link rel="stylesheet" href="../../Resources/css/tiny-slider.css" />
    <link rel="stylesheet" href="../../Resources/css/aos.css" />
    <link rel="stylesheet" href="../../Resources/css/style.css" />
    <link rel="stylesheet" href="../includes/css/property-list.css" />

    <title>Property All</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close">
                <span class="icofont-close js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <?php include('../includes/nav-top.php'); ?>

    <div class="hero page-inner overlay" style="background-image: url('../../Resources/images/hero_bg_1_copy.jpg')">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-9 text-center mt-5">
                    <h1 class="heading" data-aos="fade-up">Reported Issues</h1>
                    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                        <ol class="breadcrumb text-center justify-content-center">
                            <li class="breadcrumb-item"><a href="/iBalay/tenant/public/home.php">Home</a></li>
                            <li class="breadcrumb-item active text-white-50" aria-current="page">Reports</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <?php
    // Check if TenantID is set in the session
    if (!isset($_SESSION['TenantID'])) {
        // Redirect or handle the case where TenantID is not set
        exit('TenantID not set in session');
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

    // Get the tenant ID from the session
    $tenant_id = $_SESSION['TenantID'];

    // Query to fetch reports for the logged-in tenant
    $query = "SELECT r.ReportID, r.room_id, rm.room_number, r.ReportDate, r.ReportText, r.Acknowledge, r.Notified
              FROM report AS r
              INNER JOIN room AS rm ON r.room_id = rm.room_id
              WHERE r.TenantID = $tenant_id";

    $result = mysqli_query($conn, $query);

    $reports = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $reports[] = $row;
        }
    }

    // Close the result set
    mysqli_free_result($result);

    // Close the database connection
    mysqli_close($conn);
    ?>

    <div class="container mt-5">
        <h3>Reports</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?= htmlspecialchars($report['room_number']) ?></td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reportModal<?= htmlspecialchars($report['ReportID']) ?>">
                                <i class="fas fa-envelope"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php foreach ($reports as $report): ?>
        <!-- Modal -->
        <div class="modal fade" id="reportModal<?= htmlspecialchars($report['ReportID']) ?>" tabindex="-1" aria-labelledby="reportModalLabel<?= htmlspecialchars($report['ReportID']) ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportModalLabel<?= htmlspecialchars($report['ReportID']) ?>">Report Details</h5>
                    </div>
                    <div class="modal-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Room Number:</strong> <?= htmlspecialchars($report['room_number']) ?></p>
                                <p><strong>Report Date:</strong> <?= htmlspecialchars($report['ReportDate']) ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="message-box">
                            <p><strong>Report Text:</strong> <?= htmlspecialchars($report['ReportText']) ?></p>
                            <small class="text-muted">Acknowledged: <?= htmlspecialchars($report['Acknowledge']) ? 'Yes' : 'No' ?></small><br>
                        </div>
                        <hr>

                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
    <?php endforeach; ?>

    <!-- Preloader -->
    <div id="overlayer"></div>
    <div class="loader">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <script src="../../Resources/js/bootstrap.bundle.min.js"></script>
    <script src="../../Resources/js/tiny-slider.js"></script>
    <script src="../../Resources/js/aos.js"></script>
    <script src="../../Resources/js/navbar.js"></script>
    <script src="../../Resources/js/counter.js"></script>
    <script src="../../Resources/js/custom.js"></script>
</body>
</html>
