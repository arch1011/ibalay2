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

// Number of items per page
$items_per_page = 6;

// Determine current page from query string, defaulting to 1 if not set
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) {
    $current_page = 1;
}

// Calculate the offset for SQL query
$offset = ($current_page - 1) * $items_per_page;

// Get the total number of boarding houses
$total_bhs_query = "SELECT COUNT(*) as total FROM bh_information";
$total_bhs_result = mysqli_query($conn, $total_bhs_query);
$total_bhs_data = mysqli_fetch_assoc($total_bhs_result);
$total_bhs = (int)$total_bhs_data['total'];

// Calculate total pages
$total_pages = ceil($total_bhs / $items_per_page);

// Fetch the boarding houses for the current page
$query = "
    SELECT 
        bh_id,
        BH_name,
        BH_address
    FROM 
        bh_information
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
$boarding_houses = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result); // Free the result set
mysqli_close($conn); // Close the connection
?>

<div class="row mb-5 align-items-center">
    <div class="col-lg-6 text-center mx-auto">
        <h2 class="font-weight-bold text-primary heading">
            Registered Boarding Houses
        </h2>
    </div>
</div>

<!-- HTML and Pagination Controls -->
<div class="section section-properties">
    <div class="container">
    <div class="row">
    <?php foreach ($boarding_houses as $bh): ?>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 mb-4">
            <div class="property-item mb-30">
                <div class="property-content">
                    <div>
                        <span class="d-block mb-2 text-black-50" style="font-size: 20px">BH Name: <?= htmlspecialchars($bh['BH_name']) ?></span>
                        <span class="d-block mb-2 text-black-50" style="font-size: 15px">BH Address: <?= htmlspecialchars($bh['BH_address']) ?></span>
                        <a href="../public/bh-rooms.php?bh_id=<?= htmlspecialchars($bh['bh_id']) ?>" class="btn btn-primary py-2 px-3">See rooms</a>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
        

        <!-- Pagination Controls -->
        <div class="row align-items-center py-5">
            <div class="col-lg-3">Page <?= $current_page ?> of <?= $total_pages ?></div>
            <div class="col-lg-6 text-center">
                <div class="custom-pagination">
                    <!-- Displaying Pagination Links -->
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?= $i ?>" <?= $i === $current_page ? 'class="active"' : '' ?>><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>



