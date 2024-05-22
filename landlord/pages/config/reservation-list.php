<?php
// Check if landlord_id is in the session
if (!isset($_SESSION['landlord_id'])) {
    die("Error: Landlord ID not found in the session.");
}

$landlord_id = $_SESSION['landlord_id'];

// Include database connection script
include('../../database/config.php');

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
$query = "SELECT t.FirstName, t.LastName, t.TenantID, r.room_id, r.room_number, r.room_price, rr.reserved_id, r.room_photo1, r.room_photo2, r.landlord_id
          FROM tenant t
          INNER JOIN reserved_room rr ON t.TenantID = rr.TenantID
          INNER JOIN room r ON rr.room_id = r.room_id
          WHERE r.landlord_id = $landlord_id
          AND rr.declined = 0";

$result = mysqli_query($conn, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="card">
                <div class="card-body">
                  <h5 class="card-title">Tenants Who Reserved Rooms</h5>
                  <table class="table table-sm">
                    <thead>
                      <tr>
                        <th scope="col">Tenant Name</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>';
        while ($row = mysqli_fetch_assoc($result)) {
            // Construct file paths for room photos
            $photo1 = "/iBalay/uploads/roomphotos/room{$row['room_number']}_landlord{$landlord_id}/{$row['room_photo1']}";
            $photo2 = "/iBalay/uploads/roomphotos/room{$row['room_number']}_landlord{$landlord_id}/{$row['room_photo2']}";
            
            echo '<tr>
                    <td>' . $row['FirstName'] . ' ' . $row['LastName'] . '</td>
                    <td><button type="button" class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#roomModal' . $row['room_number'] . '">View</button></td>
                  </tr>';
        }
        echo '</tbody>
              </table>
            </div>
          </div>';

        // Modal for room details
        mysqli_data_seek($result, 0); // Reset result pointer to the beginning
        while ($row = mysqli_fetch_assoc($result)) {
            // Construct file paths for room photos
            $photo1 = "/iBalay/uploads/roomphotos/room{$row['room_number']}_landlord{$landlord_id}/{$row['room_photo1']}";
            $photo2 = "/iBalay/uploads/roomphotos/room{$row['room_number']}_landlord{$landlord_id}/{$row['room_photo2']}";
            
            echo '<div class="modal fade" id="roomModal' . $row['room_number'] . '" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Room Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>Room Number: ' . $row['room_number'] . '</h5>
                        <div id="carouselExampleControls' . $row['room_number'] . '" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="' . $photo1 . '" class="d-block w-100" alt="Room Photo 1">
                                </div>
                                <div class="carousel-item">
                                    <img src="' . $photo2 . '" class="d-block w-100" alt="Room Photo 2">
                                </div>
                            </div>
                            <h5 style="margin-top:10px;">Room Price: $' . $row['room_price'] . '</h5>
                            <hr>
                            <h5>Tenant Name: ' . $row['FirstName'] . ' ' . $row['LastName'] . '</h5>
                            <hr>
                            <button type="button" class="btn btn-primary" onclick="storeIDsAndRedirect(' . $row['room_id'] . ', ' . $row['TenantID'] . ', ' . $row['landlord_id'] . ')">Process</button>
                            <button type="button" class="btn btn-danger" onclick="declineReservation(' . $row['reserved_id'] . ')" data-bs-dismiss="modal">Decline</button>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls' . $row['room_number'] . '" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls' . $row['room_number'] . '" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>';
        
        
         
        }
    } else {
        echo "There is no reservation at the moment.";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>


            <?php
                include('config/decline-modal.php');
            ?>

            <script src="config/decline.js"></script>

            <script>
function storeIDsAndRedirect(roomId, tenantId, landlordId) {
    // Construct the URL with query parameters
    var url = "final-stage.php?room_id=" + roomId + "&tenant_id=" + tenantId + "&landlord_id=" + landlordId;
    // Redirect to the final-stage.php page
    window.location.href = url;
}

</script>
