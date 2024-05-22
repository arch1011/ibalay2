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

// Get the bh_id from the URL parameter
$bh_id = isset($_GET['bh_id']) ? $_GET['bh_id'] : null;

// Fetch the boarding house details
$bh_query = "SELECT BH_name FROM bh_information WHERE bh_id = $bh_id";
$bh_result = mysqli_query($conn, $bh_query);

// Check for query errors
if (!$bh_result) {
    error_log("Boarding house query failed: " . mysqli_error($conn), 0);
    die("Error fetching boarding house data. Please try again later.");
}

$bh_row = mysqli_fetch_assoc($bh_result);
$bh_name = $bh_row['BH_name'];

// Fetch the total number of rooms associated with the specified boarding house
$total_rooms_query = "SELECT COUNT(*) as total FROM room WHERE landlord_id IN (SELECT landlord_id FROM bh_information WHERE bh_id = $bh_id)";
$total_rooms_result = mysqli_query($conn, $total_rooms_query);
$total_rooms_data = mysqli_fetch_assoc($total_rooms_result);
$total_rooms = (int)$total_rooms_data['total'];

// Calculate total pages
$total_pages = ceil($total_rooms / $items_per_page);

// Fetch the rooms for the current page associated with the specified boarding house
$query = "
    SELECT 
        r.room_id,
        r.room_photo1,
        r.room_price,
        r.capacity,
        r.landlord_id,
        r.room_number,
        b.BH_address,
        b.BH_name,
        b.number_of_kitchen,
        r.description
    FROM 
        room r
    JOIN 
        bh_information b
    ON 
        r.landlord_id = b.landlord_id
    WHERE 
        b.bh_id = $bh_id
    LIMIT $items_per_page OFFSET $offset
";

// Prepare and execute the query
$result = mysqli_query($conn, $query);

// Check for query errors
if (!$result) {
    error_log("Query failed: " . mysqli_connect_error(), 0);
    die("Error fetching data. Please try again later.");
}

// Fetch all rooms
$rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result); // Free the result set
mysqli_free_result($bh_result); // Free the boarding house result set
mysqli_close($conn); // Close the connection
?>

<div class="row mb-5 align-items-center">
    <div class="col-lg-6 text-center mx-auto">
        <h2>
            BH Name: 
            <?= isset($bh_name) ? $bh_name : 'Boarding House Rooms' ?>
        </h2>
    </div>
</div>

<hr>

<!-- HTML and Pagination Controls -->
<div class="section section-properties">
    <div class="container">
        <div class="row">
            <?php foreach ($rooms as $room): ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                    <div class="property-item mb-30">
                        <a href="property-single.php?room_id=<?= $room['room_id'] ?>" class="img">
                            <img src="<?= "/iBalay/uploads/roomphotos/room{$room['room_number']}_landlord{$room['landlord_id']}/{$room['room_photo1']}" ?>" alt="Room Image" class="img-fluid" />
                        </a>

                        <div class="property-content">
                            <div class="price mb-2"><span><?= "₱" . number_format($room['room_price'], 2) ?></span></div>
                            <div>
                                <span class="d-block mb-2 text-black-50"><?= $room['BH_address'] ?></span>
                                <div class="specs d-flex mb-4">
                                    <span class="d-block d-flex align-items-center me-3">
                                        <span class="icon-bed me-2"></span>
                                        <span class="caption"><?= $room['capacity'] ?> beds</span>
                                    </span>
                                    <span class="d-block d-flex align-items-center">
                                        <span class="icon-kitchen me-2"></span>
                                        <span class="caption"><?= $room['number_of_kitchen'] ?> kitchen(s)</span>
                                    </span>
                                </div>
                                <a href="property-single.php?room_id=<?= $room['room_id'] ?>" class="btn btn-primary py-2 px-3">See details</a>
                            </div>
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
                        <a href="?page=<?= $i ?>&bh_id=<?= $bh_id ?>" <?= $i === $current_page ? 'class="active"' : '' ?>><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>
