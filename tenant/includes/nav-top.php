<?php
session_start();

$host = 'localhost';
$dbname = 'iBalay_System';
$username = 'root';
$password = '';

// Connect to the database using MySQLi
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check for successful connection
if (!$conn) {
    error_log("Database connection failed: " . mysqli_connect_error(), 0);
    die("Connection failed. Please try again later.");
}

// Set character set to UTF-8
mysqli_set_charset($conn, 'utf8');

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Assuming the tenant's ID is stored in the session
$TenantID = $_SESSION['TenantID'];

// Initialize counts
$favorites_count = 0;
$reservation_count = 0;
$inquiries_count = 0;
$my_room_count = 0;

// Fetch count for My Favorites
$query = "SELECT COUNT(*) as count FROM bookmark WHERE tenant_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $TenantID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$favorites_count = $row['count'];

// Fetch count for My Reservation
$query = "SELECT COUNT(*) as count FROM reserved_room WHERE TenantID = ? AND declined = 0";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $TenantID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$reservation_count = $row['count'];

// Fetch count for Room Inquiries
$query = "SELECT COUNT(*) as count FROM inquiry WHERE tenant_id = ? AND sent_by = 'landlord'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $TenantID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$inquiries_count = $row['count'];

// Fetch count for My Room
$query = "SELECT COUNT(*) as count FROM rented_rooms WHERE TenantID = ? AND room_id IS NOT NULL";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $TenantID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$my_room_count = $row['count'];

// Fetch count for My Room
$query = "SELECT COUNT(*) as count FROM report WHERE TenantID = ? AND room_id IS NOT NULL AND Acknowledge = 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $TenantID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$report_count = $row['count'];


// Calculate total count for the burger menu
$total_count = $favorites_count + $reservation_count + $inquiries_count + $my_room_count + $report_count;
?>

<style>
    .notification-number {
      color: #660000;
      font-weight: bold;
    }

    .burger {
  position: relative;
}

.burger span {
  position: relative;
}

.burger span::after {
  content: "<?php echo $total_count > 0 ? '.' : ''; ?>";
  position: absolute;
  bottom: -40px;
  right: 20px;
  color: red; /* Change the color as needed */
  font-size: 60px;
  font-weight: bold;
}


  </style>

<nav class="site-nav">
  <div class="container">
    <div class="menu-bg-wrap">
      <div class="site-navigation">
        <a href="/iBalay/tenant/index.php" class="logo m-0 float-start">iBalay</a>

        <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu float-end">
          <li class="active">
            <a href="/iBalay/tenant/public/home.php" style="font-size:20px;">
              <i class="fas fa-home"></i> Home
            </a>
          </li>
          <li class="active">
            <a href="/iBalay/tenant/public/properties.php" style="font-size:20px;">
              <i class="fas fa-door-open"></i> Rooms
            </a>
          </li>
          <li>
            <a href="/iBalay/tenant/public/bh-list.php" style="font-size:20px;">
              <i class="fas fa-building"></i> Boarding Houses
            </a>
          </li>
          <li style="border-top: 1px solid #ccc; padding-top: 10px; margin-top: 10px;"></li>
          <li>
            <a href="/iBalay/tenant/public/bookmark.php" style="font-size:20px;">
              <i class="fas fa-heart"></i> My Favorites <span class="notification-number"><?php echo $favorites_count; ?></span>
            </a>
          </li>
          <li>
            <a href="/iBalay/tenant/public/reserved.php" style="font-size:20px;">
              <i class="fas fa-calendar-check"></i> My Reservation <span class="notification-number"><?php echo $reservation_count; ?></span>
            </a>
          </li>
          <li>
            <a href="/iBalay/tenant/public/inquiry.php" style="font-size:20px;">
              <i class="fas fa-question-circle"></i> Room Inquiries <span class="notification-number"><?php echo $inquiries_count; ?></span>
            </a>
          </li>
          <li class="active">
            <a href="/iBalay/tenant/public/rented.php" style="font-size:20px;">
              <i class="fas fa-key"></i> My Room <span class="notification-number"><?php echo $my_room_count; ?></span>
            </a>
          </li>
          <li>
            <a href="/iBalay/tenant/public/profile.php" style="font-size:20px;">
              <i class="fas fa-user"></i> My Profile
            </a>
          </li>
          <li>
            <a href="/iBalay/tenant/public/report-page.php" style="font-size:20px;">
              <i class="fas fa-file"></i> My Reports <span class="notification-number"><?php echo $report_count; ?></span>
            </a>
          </li>
          <li>
            <a href="/iBalay/tenant/includes/config/logout.php" style="font-size:20px;">
              <i class="fas fa-sign-out"></i> Logout
            </a>
          </li>
        </ul>

  <!-- Navbar content -->
            <a
              href="#"
              class="burger light me-auto float-end mt-1 site-menu-toggle js-menu-toggle d-inline-block d-lg-none <?php echo $total_count > 0 ? 'has-notification' : ''; ?>"
              data-toggle="collapse"
              data-target="#main-navbar"
            >

    <span></span>
  </a>
      </div>
    </div>
  </div>
</nav>