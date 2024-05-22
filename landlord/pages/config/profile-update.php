<div class="card">
  <div class="card-body">
    <h5 class="card-title">Update Landlord Information</h5>

    <!-- Form for updating landlord information -->
    <form class="row g-3" action="config/update_landlord_process.php" method="post">
      <!-- Fetch and display landlord's personal details -->
      <?php
        // Check if landlord_id is set in the session
        if (!isset($_SESSION['landlord_id'])) {
            // Redirect or handle the case where landlord_id is not set
            exit('landlord_id not set in session');
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

        $landlord_id = $_SESSION['landlord_id'];
        $sql = "SELECT * FROM landlord_acc WHERE landlord_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $landlord_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $landlord_details = mysqli_fetch_assoc($result);
      ?>

      <!-- Display fetched landlord's details -->
      <div class="col-md-6">
        <label for="inputFirstName" class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control" value="<?php echo $landlord_details['first_name']; ?>" required>
      </div>

      <div class="col-md-6">
        <label for="inputLastName" class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control" value="<?php echo $landlord_details['last_name']; ?>" required>
      </div>

      <div class="col-12">
        <label for="inputEmail" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo $landlord_details['email']; ?>" required>
      </div>

      <div class="col-md-6">
        <label for="inputPhoneNumber" class="form-label">Phone Number</label>
        <input type="text" name="phone_number" class="form-control" value="<?php echo $landlord_details['phone_number']; ?>">
      </div>

      <div class="col-12">
        <label for="inputAddress" class="form-label">Address</label>
        <input type="text" name="address" class="form-control" value="<?php echo $landlord_details['address']; ?>">
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
