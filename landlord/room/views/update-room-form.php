<?php
session_start(); // Start the session
include('../../database/config.php'); // Include the database configuration

// Ensure the landlord is logged in
if (!isset($_SESSION['landlord_id'])) {
    die("Error: You must be logged in as a landlord to update rooms.");
}

$landlord_id = $_SESSION['landlord_id'];

// Fetch rooms for the dropdown
$query = "SELECT room_id, room_number FROM room WHERE landlord_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $landlord_id);
$stmt->execute();
$result = $stmt->get_result();

$rooms = [];
while ($row = $result->fetch_assoc()) {
    $rooms[] = $row;
}

// Check if a specific room is selected for update
$selected_room = null;
if (isset($_POST['room_id'])) {
    $room_id = $_POST['room_id'];
    $query = "SELECT * FROM room WHERE room_id = ? AND landlord_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $room_id, $landlord_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $selected_room = $result->fetch_assoc();
    } else {
        echo "Error: Room not found or permission denied.";
    }
}
?>

<main id="main" class="main">

<div class="pagetitle">
  <h1>Update your BH Room!</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Update</a></li>
      <li class="breadcrumb-item">Forms</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Update Room Form!</h5>

    <!-- Form for selecting room to update -->
    <form method="POST" class="row g-3" action="">
      <div class="col-12">
        <label for="roomSelect" class="form-label">Select Room</label>
        <select id="roomSelect" name="room_id" class="form-control" onchange="this.form.submit()">
          <option value="">-- Select Room --</option>
          <?php foreach ($rooms as $room): ?>
            <option value="<?php echo $room['room_id']; ?>"
                    <?php echo ($selected_room && $room['room_id'] == $selected_room['room_id']) ? 'selected' : ''; ?>>Room: 
              <?php echo $room['room_number']; ?>
            </option>
         <?php endforeach; ?>
        </select>
      </div>
    </form>

    <br>
    <hr>
    

    <!-- Form for updating the selected room -->
    <?php if ($selected_room): ?>
    <form class="row g-3" action="views/tasks/update-room-process.php" method="post" enctype="multipart/form-data">
      <!-- Hidden input for room_id -->
      <input type="hidden" name="room_id" value="<?php echo $selected_room['room_id']; ?>">

      <!-- Room Number -->
      <div class="col-md-6">
        <label for="inputRoomNumber" class="form-label">Room Number</label>
        <input type="number" name="room_number" class="form-control" placeholder="Enter Room Number" required value="<?php echo $selected_room['room_number']; ?>">
      </div>

      <!-- Description -->
      <div class="col-12">
        <label for="inputDescription" class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3" placeholder="Enter Room Description" required><?php echo $selected_room['description']; ?></textarea>
      </div>

      <!-- Capacity -->
      <div class="col-md-6">
        <label for="inputCapacity" class="form-label">Capacity</label>
        <input type="number" name="capacity" class="form-control" placeholder="Enter Room Capacity" required value="<?php echo $selected_room['capacity']; ?>">
      </div>

      <!-- Room Price -->
      <div class="col-md-6">
        <label for="inputRoomPrice" class="form-label">Room Price</label>
        <input type="number" step="0.01" name="room_price" class="form-control" placeholder="Enter Room Price" required value="<?php echo $selected_room['room_price']; ?>">
      </div>

      <!-- Room Photos -->
      <div class="col-md-6">
        <label for="inputRoomPhoto1" class="form-label">Room Photo 1</label>
        <input type="file" name="room_photo1" class="form-control">
      </div>

      <div class="col-md-6">
        <label for="inputRoomPhoto2" class="form-label">Room Photo 2</label>
        <input type="file" name="room_photo2" class="form-control">
      </div>

      <!-- Submit and-->
      <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    <?php endif; ?>

  </div>
</div>

</section>

</main><!-- End #main -->
