<?php
// Ensure room_id, tenant_id, and landlord_id are set in the URL
if (!isset($_GET['room_id']) || !isset($_GET['tenant_id']) || !isset($_GET['landlord_id'])) {
    echo "Error: Missing parameters in the URL.";
    exit; // Stop execution if parameters are missing
}

// Retrieve room_id, tenant_id, and landlord_id from the URL parameters
$room_id = $_GET['room_id'];
$tenant_id = $_GET['tenant_id'];
$landlord_id = $_GET['landlord_id'];

// Include database connection script
include('../../database/config.php');

// Fetch tenant name, room number, and room price based on room_id and tenant_id
$query = "SELECT t.FirstName, t.LastName, r.room_number, r.room_price, r.landlord_id
          FROM tenant t
          INNER JOIN reserved_room rr ON t.TenantID = rr.TenantID
          INNER JOIN room r ON rr.room_id = r.room_id
          WHERE r.room_id = $room_id
          AND t.TenantID = $tenant_id";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result); // Fetch the data
} else {
    // Handle error if data retrieval fails
    echo "Error: Unable to fetch tenant and room details.";
    exit; // Stop execution
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
                    <h5 class="card-title">BH Registration Form</h5>

                    <!-- Display Tenant Name -->
                    <p>Tenant Name: <?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></p>

                    <!-- Display Room Number -->
                    <p>Room Number: <?php echo $row['room_number']; ?></p>

                    <!-- Display Room Price -->
                    <p>Room Price: $<?php echo $row['room_price']; ?></p>

                    <!-- Form to submit payment details -->
                    <form action="process-payment.php" method="post" enctype="multipart/form-data">
                        <!-- Hidden fields to pass tenant_id, room_id, and room_price -->
                        <input type="hidden" name="tenant_id" value="<?php echo $tenant_id; ?>">
                        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
                        <input type="hidden" name="room_price" value="<?php echo $row['room_price']; ?>">
                        <input type="hidden" name="landlord_id" value="<?php echo $row['landlord_id']; ?>"> <!-- Ensure landlord_id is properly passed -->


                        <!-- Payment Input Field -->
                        <div class="mb-3">
                            <label for="payment" class="form-label">Payment</label>
                            <input type="number" class="form-control" id="payment" name="payment" placeholder="Enter payment amount" required>
                        </div>

                        <!-- Due Date Input Field -->
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" required>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary">Finish</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
