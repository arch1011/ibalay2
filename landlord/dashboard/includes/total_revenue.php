<!-- Total Revenue Card -->
<div class="col-xxl-4 col-md-6">
  <div class="card info-card revenue-card">

    <div class="filter">
      <a class="icon" href="#" id="filterDropdown" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
          <h6>Filter</h6>
        </li>

        <li><a class="dropdown-item filter-option" data-filter="today" href="#">Today</a></li>
        <li><a class="dropdown-item filter-option" data-filter="this_month" href="#">This Month</a></li>
        <li><a class="dropdown-item filter-option" data-filter="this_year" href="#">This Year</a></li>
      </ul>
    </div>

    <div class="card-body">
      <h5 class="card-title">Total Earned <span id="filterText">| This Month</span></h5>

      <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
          <i class="bi bi-currency-dollar"></i>
        </div>
        <div class="ps-3">
          <h6 id="totalEarned">$0.00</h6>
        </div>
      </div>
    </div>

  </div>
</div><!-- End Card -->

<script>
document.addEventListener("DOMContentLoaded", function() {
  const filterOptions = document.querySelectorAll(".filter-option");

  filterOptions.forEach(option => {
    option.addEventListener("click", function(event) {
      event.preventDefault();

      const filter = this.dataset.filter;

      fetchTotalEarned(filter);
    });
  });

  function fetchTotalEarned(filter) {
    // Fetch data from server using fetch API
    fetch("includes/config/fetch-revenue.php?filter=" + filter)
      .then(response => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.json();
      })
      .then(data => {
        document.getElementById("totalEarned").textContent = "$" + data.total_earned.toFixed(2);
        document.getElementById("filterText").textContent = "| " + data.filter_text;
      })
      .catch(error => {
        console.error("Fetch error:", error);
      });
  }
});
</script>
