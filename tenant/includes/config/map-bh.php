<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'iBalay_System';
$username = 'root';
$password = '';

// Create a connection using MySQLi
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check for successful connection
if (!$conn) {
    error_log("Database connection failed: " . mysqli_connect_error(), 0);
    die("Connection failed. Please try again later.");
}

// Set character set to UTF-8
mysqli_set_charset($conn, 'utf8');

// Ensure room details are fetched
$room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : null;
$coordinates = null; // Initialize coordinates variable

if ($room_id) {
    $query = "
        SELECT 
            longitude, 
            latitude 
        FROM 
            bh_information
        WHERE
            landlord_id = (SELECT landlord_id FROM room WHERE room_id = ?)
    ";
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        error_log("SQL Prepare Error: " . mysqli_error($conn), 0);
        die("Error preparing SQL query.");
    }

    mysqli_stmt_bind_param($stmt, 'i', $room_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if ($result === false) {
        error_log("Get Result Error: " . mysqli_error($conn), 0);
        die("Error retrieving results.");
    }

    if (mysqli_num_rows($result) > 0) {
        $coordinates = mysqli_fetch_assoc($result);
    }

    mysqli_free_result($result);
}

mysqli_close($conn); // Close connection

// $coordinates contains the fetched coordinates
?>

<!-- Title for the map section -->
<h2 class="text-center mb-4">BOARDINGHOUSE MAP</h2>

<!-- Display the map -->
<div id="map" style="height: 200px; width: 100%;"></div>

<script>
// Initialize the map with the fetched coordinates
function loadMapScenario() {
    // Check if coordinates are available
    <?php if ($coordinates && isset($coordinates['latitude']) && isset($coordinates['longitude'])): ?>
        var map = new Microsoft.Maps.Map(document.getElementById('map'), {
            center: new Microsoft.Maps.Location(<?= $coordinates['latitude'] ?>, <?= $coordinates['longitude'] ?>),
            zoom: 15,
            mapTypeId: Microsoft.Maps.MapTypeId.aerial // Set map type to aerial view
        });

        // Define the custom pushpin image URL
        var customIconUrl = '../../Resources/images/pushpin3.png'; // Replace this with the URL of your custom pushpin image

        // Create a custom pushpin using the custom icon
        var customIcon = new Microsoft.Maps.Pushpin(map.getCenter(), {
            icon: customIconUrl, // Set the custom icon URL
            anchor: new Microsoft.Maps.Point(12, 36) // Adjust the anchor point if needed
        });

        // Add the custom pushpin to the map
        map.entities.push(customIcon);
    <?php endif; ?>
}
</script>
<script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?key=AvFonBVo0VcCo1NO806rnp9M7EQkE7zV7fTBkCSlR0hzY-GbYE1w1RCE0emZcsHy&callback=loadMapScenario' async defer></script>
