<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['saso_id'])) {
    // Include your database connection
    include 'connect_db/connection.php';

    // Get the username and photo from the saso table based on the saso_id in the session
    $sasoID = $_SESSION['saso_id'];
    $sql = "SELECT username, photo FROM saso WHERE saso_id = '$sasoID'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        
        // Check if the photo column is not empty
        if (!empty($row['photo'])) {
            $uploadDir = '/iBalay/uploads/'; // Update this with your actual path
            $photoPath = $uploadDir . trim($row['photo']);
            $photoHTML = '<img src="' . $photoPath . '" alt="Profile Photo" class="rounded-circle">';
        } else {
            // Set a default photo if none is available
            $photoHTML = '<img src="assets/img/default-profile.jpg" alt="Default Photo" class="rounded-circle">';
        }
    } else {
        // Handle the case where the username is not found
        $username = 'Unknown User';
        $photoHTML = '<img src="assets/img/default-profile.jpg" alt="Default Photo" class="rounded-circle">';
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Redirect to the login page if not logged in
    header("Location: /iBalay/iBalay-saso/login.php");
    exit();
}
?>

<head>
      <!-- Favicons -->
  <link href="assets/img/evsu.png" rel="icon">
  <link href="assets/img/evsu.png" rel="apple-touch-icon">

</head>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="/iBalay/iBalay-saso/index.php" class="logo d-flex align-items-center">
        <img src="assets/img/evsu.png" alt="">
        <span class="d-none d-lg-block">SASO - ADMIN</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>

 
<!-- start notification -->
<li class="nav-item dropdown">
    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        <span class="badge bg-primary badge-number" id="notificationCount">0</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
        <li class="dropdown-header">
            You have <span id="notificationCountDrop">0</span> notifications
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <!-- PHP code to fetch and display notifications for Boarding House registrations -->
<!-- PHP code to fetch and display notifications for Boarding House registrations -->
<?php
// Include your database connection
include '../database/config.php';

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch notifications for Boarding House registrations where Status is 0
$bhNotificationsQuery = "SELECT BH_name FROM bh_information WHERE Status = '0'";
$bhNotificationsResult = mysqli_query($conn, $bhNotificationsQuery);

// Get the count of notifications
$totalNotificationsCount = mysqli_num_rows($bhNotificationsResult);

// Update the notification count
echo '<script>document.getElementById("notificationCount").textContent = "' . $totalNotificationsCount . '";</script>';
echo '<script>document.getElementById("notificationCountDrop").textContent = "' . $totalNotificationsCount . '";</script>';

// Check if there are notifications
if ($totalNotificationsCount > 0) {
    while ($row = mysqli_fetch_assoc($bhNotificationsResult)) {
        echo '<li>';
        echo '<a class="dropdown-item text-warning" href="/iBalay/iBalay-saso/register-owner.php">';
        echo '<strong>Boarding House Registration Request:</strong><br>';
        echo '<span><strong>Name:</strong> ' . $row['BH_name'] . '</span><br>';
        echo '</a>';
        echo '</li>';
    }
} else {
    // If no notifications found
    echo '<li>';
    echo '<a class="dropdown-item text-muted" href="#">No new notifications</a>';
    echo '</li>';
}

// Close the database connection
mysqli_close($conn);
?>


        <li>
            <hr class="dropdown-divider">
        </li>
        <!--  to be add if needed
        <li class="dropdown-footer">
            <a href="#">Show all notifications</a>
        </li>
        -->
    </ul>
</li>
<!-- end notification -->


        <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
    <?php echo $photoHTML; ?>
    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $username; ?></span>
</a><!-- End Profile Iamge Icon -->


<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
  <li class="dropdown-header">
    <h6><?php echo $username; ?></h6>
  </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/iBalay/iBalay-saso/account-setting.php">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
  <a class="dropdown-item d-flex align-items-center" href="logout_process.php">
    <i class="bi bi-box-arrow-right"></i>
    <span>Sign Out</span>
  </a>
</li>


          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="/iBalay/iBalay-saso/index.php">
          <i class="bi bi-grid"></i>
          <span>SASO - Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-house-fill"></i><span>Landlord</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/iBalay/iBalay-saso/owner-list.php">
              <i class="bi bi-circle"></i><span>Landlord Lists</span>
            </a>
          </li>
          <li>
            <a href="/iBalay/iBalay-saso/owner-list-warning.php">
              <i class="bi bi-circle"></i><span>Landlord BH Warning Lists</span>
            </a>
          </li>
          <li>
            <a href="/iBalay/iBalay-saso/owner-terminated-accounts.php">
              <i class="bi bi-circle"></i><span>Landlord TerminatedBoarding House</span>
            </a>
          </li>
          <li>
            <a href="/iBalay/iBalay-saso/disapproved_landlord.php">
              <i class="bi bi-circle"></i><span>Disapproved LandlordBoarding House</span>
            </a>
          </li>
          
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people-fill"></i><span>Boarders</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/iBalay/iBalay-saso/tenant-list.php">
              <i class="bi bi-circle"></i><span>List of Boarders</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="register-owner.php">
          <i class="bi bi-person-plus-fill"></i>
          <span>Boarding House Registration Request</span>
        </a>
      </li><!-- End Register Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/iBalay/iBalay-saso/register-saso.php">
          <i class="bi bi-person-plus-fill"></i>
          <span>Register SASO Account</span>
        </a>
      </li><!-- End Register Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/iBalay/iBalay-saso/report-page.php">
          <i class="bi bi-chat-quote-fill"></i>
          <span>Room Reports</span>
        </a>
      </li><!-- End Register Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/iBalay/iBalay-saso/map.php">
          <i class="bi bi-map"></i>
          <span>navigate Map</span>
        </a>
      </li><!-- End Register Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->