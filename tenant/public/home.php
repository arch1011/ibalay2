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
    <link
      href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <link rel="stylesheet" href=".././../Resources/fonts/icomoon/style.css" />
    <link rel="stylesheet" href="../../Resources/fonts/flaticon/font/flaticon.css" />

    <link rel="stylesheet" href="../../Resources/css/tiny-slider.css" />
    <link rel="stylesheet" href="../../Resources/css/aos.css" />
    <link rel="stylesheet" href="../../Resources/css/style.css" />

    <!-- CSS to set consistent image size -->
    <link rel="stylesheet" href="../includes/css/property-list.css" />
    
<title>
      home
    </title>
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

    <?php
      include('../includes/nav-top.php');
    ?>
    
    <?php
      include('../includes/search.php');
    ?>
    
    <?php
      include('../includes/property-list.php');
    ?>
    



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

    <?php

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

// Query to fetch the maximum end date
$query = "SELECT MAX(end_date) AS max_end_date FROM rented_rooms WHERE TenantID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $TenantID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$max_end_date = $row['max_end_date'];
echo "console.log('Retrieved end date:', '$max_end_date');";
?>

<script>
// Convert the PHP end date to JavaScript date format
var endDate = new Date("<?php echo $max_end_date; ?>");

// Debug output to check the converted end date
console.log("Converted end date:", endDate);

// Calculate the difference in days between today and the end date
var timeDifference = endDate.getTime() - Date.now();
var daysDifference = Math.floor(timeDifference / (1000 * 3600 * 24));

// Debug output to check the calculated days difference
console.log("Days difference:", daysDifference);

// If the difference is 5 days or less, show the popup alert
if (daysDifference <= 5) {
var formattedEndDate = endDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
alert("Your due date is on " + formattedEndDate);
}
</script>



  </body>
</html>
