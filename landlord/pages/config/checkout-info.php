<?php
// Ensure tenant_id is set in the URL
if (!isset($_GET['tenant_id'])) {
    echo "Error: Missing parameter 'tenant_id' in the URL.";
    exit; // Stop execution if parameter is missing
}

// Retrieve tenant_id from the URL parameter
$tenant_id = $_GET['tenant_id'];


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

// Fetch tenant name, boarding start date, and room number
$query = "SELECT t.FirstName, t.LastName, rr.start_date, r.room_number
          FROM tenant t
          INNER JOIN rented_rooms rr ON t.TenantID = rr.TenantID
          INNER JOIN room r ON rr.room_id = r.room_id
          WHERE t.TenantID = $tenant_id";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result); // Fetch the data
} else {
    // Handle error if data retrieval fails
    echo "Error: Unable to fetch tenant details.";
    exit; // Stop execution
}

// Fetch total payments made by the tenant
$query = "SELECT SUM(amount) AS total_payments
          FROM tenant_payments
          WHERE TenantID = $tenant_id";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $payment_row = mysqli_fetch_assoc($result);
    $total_payments = $payment_row['total_payments'];
} else {
    $total_payments = 0;
}

// Close the result set
mysqli_free_result($result);

// Close the connection
mysqli_close($conn);
?>

<section class="section">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Checkout Details</h5>

                    <!-- Display Tenant Name -->
                    <p>Tenant Name: <?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></p>

                    <!-- Display Boarding Start Date -->
                    <p>Boarding since: <?php echo $row['room_number']; ?></p>


                    <!-- Display Boarding Start Date -->
                    <p>Boarding since: <?php echo $row['start_date']; ?></p>

                    <!-- Display Total Payments -->
                    <p>Total Payments: $<?php echo $total_payments; ?></p>

                    <!-- Checkout Button -->
                    <a href="config/checkout-process.php?tenant_id=<?php echo $tenant_id; ?>" class="btn btn-danger">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</section>
