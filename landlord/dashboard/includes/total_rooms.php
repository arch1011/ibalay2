<!-- Total Rooms Card -->
<div class="col-xxl-4 col-xl-12">
  <div class="card info-card customers-card">
    <div class="card-body">
      <h5 class="card-title">Total Rooms</h5>
      <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
          <i class="bi bi-door-open"></i>
        </div>
        <div class="ps-3">
          <h6 id="totalRooms">Loading...</h6>
        </div>
      </div>
    </div>
  </div>
</div><!-- End Total Rooms Card -->

<script>
document.addEventListener("DOMContentLoaded", function() {
  fetchTotalRooms();
});

function fetchTotalRooms() {
  // Fetch data from server using fetch API
  fetch("includes/config/fetch-room.php")
    .then(response => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then(data => {
      document.getElementById("totalRooms").textContent = data.total_rooms;
    })
    .catch(error => {
      console.error("Fetch error:", error);
    });
}
</script>
