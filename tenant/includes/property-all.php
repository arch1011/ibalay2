       <?php 
         include('config/property-all.php');
       ?>

<div class="row mb-5 align-items-center">
      <div class="col-lg-6 text-center mx-auto">
        <h2 class="font-weight-bold text-primary heading">
          All Listed Rooms
        </h2>
      </div>
    </div>

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
            <a href="?page=<?= $i ?>" <?= $i === $current_page ? 'class="active"' : '' ?>><?= $i ?></a>
          <?php endfor; ?>
        </div>
      </div>
    </div>
  </div>
</div>



<?php
/*$host = 'localhost';
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

// Get the total number of rooms
$total_rooms_query = "SELECT COUNT(*) as total FROM room";
$total_rooms_result = mysqli_query($conn, $total_rooms_query);
$total_rooms_data = mysqli_fetch_assoc($total_rooms_result);
$total_rooms = (int)$total_rooms_data['total'];

// Calculate total pages
$total_pages = ceil($total_rooms / $items_per_page);

// Fetch the rooms for the current page
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
        room r
    JOIN 
        bh_information b
    ON 
        r.landlord_id = b.landlord_id
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

<div class="row mb-5 align-items-center">
      <div class="col-lg-6 text-center mx-auto">
        <h2 class="font-weight-bold text-primary heading">
          All Listed Rooms
        </h2>
      </div>
    </div>

<!-- HTML and Pagination Controls -->
<div class="section section-properties">
  <div class="container">
    <div class="row">
      <?php foreach ($rooms as $room): ?>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
          <div class="property-item mb-30">
            <a href="property-single.php?room_id=<?= $room['room_id'] ?>" class="img">
              <img src="<?= "/iBalay/uploads/roomphotos/room{$room['room_number']}_landlord{$room['landlord_id']}/{$room['room_photo1']}" ?>" alt="Image" class="img-fluid" />
            </a>

            <div class="property-content">
              <div class="price mb-2"><span><?= "$" . number_format($room['room_price'], 2) ?></span></div>
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
            <a href="?page=<?= $i ?>" <?= $i === $current_page ? 'class="active"' : '' ?>><?= $i ?></a>
          <?php endfor; ?>
        </div>
      </div>
    </div>
  </div>
</div> */
