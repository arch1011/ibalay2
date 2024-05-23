<?php
session_start(); // Start the session if not already started

require('../session.php');

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

// Fetch landlord information
$sql = "SELECT * FROM landlord_acc WHERE landlord_id = $landlord_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $landlord_info = mysqli_fetch_assoc($result);
} else {
    $landlord_info = array();
}

// Fetch notifications (reserved rooms where declined is not set)
$notifications_sql = "
    SELECT rr.reserved_id, rr.room_id, rr.TenantID, rr.declined, t.FirstName
    FROM reserved_room rr
    INNER JOIN room r ON rr.room_id = r.room_id 
    INNER JOIN tenant t ON rr.TenantID = t.TenantID
    WHERE rr.declined = 0 AND r.landlord_id = $landlord_id

";
$notifications_result = mysqli_query($conn, $notifications_sql);
$notifications = mysqli_fetch_all($notifications_result, MYSQLI_ASSOC);
$notification_count = count($notifications);

// Fetch messages (inquiries)
$messages_sql = "
    SELECT i.inquiry_id, i.room_id, i.tenant_id, i.message, i.sent_by, i.timestamp, t.FirstName, t.LastName
    FROM inquiry i
    INNER JOIN tenant t ON i.tenant_id = t.TenantID
    WHERE i.landlord_id = $landlord_id
    ORDER BY i.timestamp DESC
    LIMIT 3
";
$messages_result = mysqli_query($conn, $messages_sql);
$messages = mysqli_fetch_all($messages_result, MYSQLI_ASSOC);
$message_count = count($messages);

mysqli_close($conn);
?>
<head>
    <!-- Favicons -->
    <link href="../../assets/img/evsufav.png" rel="icon">
    <link href="../../assets/img/evsufav.png" rel="apple-touch-icon">
</head>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="#" class="logo d-flex align-items-center">
            <img src="../../assets/img/evsufav.png" alt="">
            <img src=".././assets/img/evsufav.png" alt="">
            <span class="d-none d-lg-block">iBalay Landlord</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <!-- Notification Bell -->
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number"><?php echo $notification_count; ?></span>
                </a><!-- End Notification Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        You have <?php echo $notification_count; ?> new notifications
                        <a href="/iBalay/landlord/pages/reservation.php"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <?php foreach ($notifications as $notification): ?>
                    <li class="notification-item">
                        <i class="bi bi-exclamation-circle text-warning"></i>
                        <div>
                            <h4>Room Reserved</h4>
                            <p>reserved by: <?php echo $notification['FirstName']; ?></p>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <?php endforeach; ?>
                </ul><!-- End Notification Dropdown Items -->

            </li><!-- End Notification Nav -->

            <!-- Messages Icon -->
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-chat-left-text"></i>
                    <span class="badge bg-success badge-number"><?php echo $message_count; ?></span>
                </a><!-- End Messages Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                    <li class="dropdown-header">
                        You have <?php echo $message_count; ?> new messages
                        <a href="/iBalay/landlord/pages/room_inquiry.php"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <?php foreach ($messages as $message): ?>
                    <li class="message-item">
                        <a href="#">
                            <div>
                                <h4><?php echo $message['FirstName'] . ' ' . $message['LastName']; ?></h4>
                                <p><?php echo $message['message']; ?></p>
                                <p><?php echo date('d M Y, h:i A', strtotime($message['timestamp'])); ?></p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <?php endforeach; ?>
                </ul><!-- End Messages Dropdown Items -->

            </li><!-- End Messages Nav -->

            <!-- Profile Icon -->
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="../../assets/img/evsufav.png" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $landlord_info['first_name'] . ' ' . $landlord_info['last_name']; ?></span>
                </a><!-- End Profile Image Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?php echo $landlord_info['first_name'] . ' ' . $landlord_info['last_name']; ?></h6>
                        <span>LandLord</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/iBalay/landlord/pages/profile.php">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/iBalay/landlord/layouts/logout.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>

</header>
