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
                    <h1 class="heading" data-aos="fade-up">Inquired Properties</h1>
                    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                        <ol class="breadcrumb text-center justify-content-center">
                            <li class="breadcrumb-item"><a href="/iBalay/tenant/public/home.php">Home</a></li>
                            <li class="breadcrumb-item active text-white-50" aria-current="page">Inquiries</li>
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

    // Query to fetch inquiries for the logged-in tenant
    $query = "SELECT i.inquiry_id, i.room_id, r.room_number, i.message, i.sent_by, i.timestamp
              FROM inquiry AS i
              INNER JOIN room AS r ON i.room_id = r.room_id
              WHERE i.tenant_id = $tenant_id";

    $result = mysqli_query($conn, $query);

    $inquiries = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $roomKey = $row['room_id'];
            if (!isset($inquiries[$roomKey])) {
                $inquiries[$roomKey] = [
                    'room_number' => $row['room_number'],
                    'messages' => [],
                ];
            }
            $inquiries[$roomKey]['messages'][] = $row;
        }
    }

    // Close the result set
    mysqli_free_result($result);

    // Close the database connection
    mysqli_close($conn);
    ?>

    <div class="container mt-5">
        <h3>Inquiries</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inquiries as $roomKey => $roomData): ?>
                    <tr>
                        <td><?= htmlspecialchars($roomData['room_number']) ?></td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inquiryModal<?= htmlspecialchars($roomKey) ?>">
                                <i class="fas fa-envelope"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
                                <p><strong>Room Number:</strong> <?= htmlspecialchars($roomData['room_number']) ?></p>
                            </div>
                        </div>
                        <hr>
                        <?php foreach ($roomData['messages'] as $message): ?>
                            <div class="message-box">
                                <p><strong><?= htmlspecialchars(ucfirst($message['sent_by'])) ?>:</strong> <?= htmlspecialchars($message['message']) ?></p>
                                <small class="text-muted"><?= htmlspecialchars($message['timestamp']) ?></small>
                            </div>
                            <hr>
                        <?php endforeach; ?>

                        <!-- Reply form -->
                        <form method="post" action="tenant_reply.php">
                            <div class="mb-3">
                                <label for="replyMessage" class="form-label">Reply</label>
                                <textarea class="form-control" id="replyMessage" name="message" rows="3" required></textarea>
                            </div>
                            <input type="hidden" name="room_id" value="<?= htmlspecialchars($roomKey) ?>">
                            <button type="submit" class="btn btn-primary">Send Reply</button>
                        </form>
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
