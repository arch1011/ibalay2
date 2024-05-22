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
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Number of items per page
$items_per_page = 6;

// Determine current page from query string, defaulting to 1 if not set
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) {
    $current_page = 1;
}

// Calculate the offset for SQL query
$offset = ($current_page - 1) * $items_per_page;

// Get the total number of reserved rooms for the current tenant
$tenant_id = $_SESSION['TenantID']; // Assuming you have the tenant ID in the session
$total_reserved_query = "SELECT COUNT(*) as total FROM reserved_room WHERE TenantID = $tenant_id";
$total_reserved_result = mysqli_query($conn, $total_reserved_query);
$total_reserved_data = mysqli_fetch_assoc($total_reserved_result);
$total_reserved = (int)$total_reserved_data['total'];

// Calculate total pages
$total_pages = ceil($total_reserved / $items_per_page);

// Fetch the reserved rooms for the current page
$query = "
    SELECT 
        r.room_id,
        r.room_photo1,
        r.room_price,
        r.capacity,
        r.landlord_id,
        r.room_number,
        b.BH_address,
        b.number_of_kitchen,
        r.description
    FROM 
        reserved_room rs
    JOIN 
        room r ON rs.room_id = r.room_id
    JOIN 
        bh_information b ON r.landlord_id = b.landlord_id
    WHERE 
        rs.TenantID = $tenant_id
    LIMIT $items_per_page OFFSET $offset
";

// Prepare and execute the query
$result = mysqli_query($conn, $query);

// Check for query errors
if (!$result) {
    error_log("Query failed: " . mysqli_connect_error(), 0);
    die("Error fetching data. Please try again later.");
}

// Fetch all results
$rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result); // Free the result set
mysqli_close($conn); // Close the connection
?>
