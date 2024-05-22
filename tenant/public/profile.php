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

    <title>Profile</title>
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
                    <h1 class="heading" data-aos="fade-up">My profile</h1>
                    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                        <ol class="breadcrumb text-center justify-content-center">
                            <li class="breadcrumb-item"><a href="/iBalay/tenant/public/home.php">Home</a></li>
                            <li class="breadcrumb-item active text-white-50" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <?php
    // Fetch tenant details from the database
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

// Check if TenantID is set in the session
if (!isset($_SESSION['TenantID'])) {
    // Redirect or handle the case where TenantID is not set
    exit('TenantID not set in session');
}

$TenantID = $_SESSION['TenantID'];
$sql = "SELECT * FROM tenant WHERE TenantID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $TenantID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$tenant_details = mysqli_fetch_assoc($result);

// Construct the path to the profile photo
$photoPath = '/iBalay/uploads/tenant_profile/' . $tenant_details['ProfilePhoto'];
    ?>

    <div class="container mt-5">
    <?php
            // Check if ProfilePhoto exists and is not empty
            if (!empty($tenant_details['ProfilePhoto'])) {
                // Display the image using HTML
                echo '<img src="' . $photoPath . '" class="card-img-top" alt="Tenant\'s Photo">';
            } else {
                // If ProfilePhoto is empty, display a placeholder image or a message
                echo '<p>No photo available</p>';
            }
            ?>

        <div class="card-body">
            <h5 class="card-title">Update Tenant Information</h5>

            <!-- Form for updating tenant information -->
            <form class="row g-3" action="update-profile.php" method="post" enctype="multipart/form-data">
  
                <!-- Fetch and display tenant's personal details -->
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

                    $TenantID = $_SESSION['TenantID'];
                    $sql = "SELECT * FROM tenant WHERE TenantID = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, 'i', $TenantID);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $tenant_details = mysqli_fetch_assoc($result);
                ?>

                <!-- Display fetched tenant's details -->
                <div class="col-12">
        <label for="inputPhoto" class="form-label">Upload Photo</label>
        <input type="file" class="form-control" id="inputPhoto" name="photo">
    </div>
                
                <div class="col-md-6">
                    <label for="inputFirstName" class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="<?php echo $tenant_details['FirstName']; ?>" readonly>
                </div>

                <div class="col-md-6">
                    <label for="inputLastName" class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="<?php echo $tenant_details['LastName']; ?>" readonly>
                </div>

                <div class="col-12">
                    <label for="inputEmail" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $tenant_details['Email']; ?>" readonly>
                </div>

                <div class="col-md-6">
                    <label for="inputPhoneNumber" class="form-label">Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" value="<?php echo $tenant_details['PhoneNumber']; ?>" readonly>
                </div>

                <div class="col-12">
                    <label for="inputAddress" class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" value="<?php echo $tenant_details['address']; ?>" readonly>
                </div>

                <!-- Update Profile Checkbox -->
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="updateProfileCheckbox">
                        <label class="form-check-label" for="updateProfileCheckbox">Update Profile</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary" id="updateButton" disabled>Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const updateProfileCheckbox = document.getElementById("updateProfileCheckbox");
        const updateButton = document.getElementById("updateButton");

        updateProfileCheckbox.addEventListener("change", function() {
            const isChecked = updateProfileCheckbox.checked;
            const formFields = document.querySelectorAll("form input");

            formFields.forEach(field => {
                field.readOnly = !isChecked;
            });

            updateButton.disabled = !isChecked;
        });
    });
</script>


    <!-- Your existing HTML content here -->
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
