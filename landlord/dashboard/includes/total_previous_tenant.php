<!-- Total Previous Tenants Card -->
<div class="col-xxl-4 col-xl-12">
  <div class="card info-card customers-card">
    <div class="filter">
      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
          <h6>Filter</h6>
        </li>
        <li><a class="dropdown-item filter-option-prev" data-period="Today" href="#">Today</a></li>
        <li><a class="dropdown-item filter-option-prev" data-period="This Month" href="#">This Month</a></li>
        <li><a class="dropdown-item filter-option-prev" data-period="This Year" href="#">This Year</a></li>
      </ul>
    </div>
    <div class="card-body">
      <h5 class="card-title">Previous Tenants <span id="filter-period-prev">| This Year</span></h5>
      <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
          <i class="bi bi-people"></i>
        </div>
        <div class="ps-3">
          <h6 id="total-previous-tenants">
            <!-- Total previous tenants count will be updated here -->
          </h6>
          <span class="text-muted small pt-2 ps-1">Previous Tenants</span>
        </div>
      </div>
    </div>
  </div>
</div><!-- End Card -->

<script>
document.addEventListener('DOMContentLoaded', function() {
  const filterOptions = document.querySelectorAll('.filter-option-prev');
  const totalPreviousTenantsElement = document.getElementById('total-previous-tenants');
  const filterPeriodElement = document.getElementById('filter-period-prev'); // Changed to 'filter-period-prev'

  filterOptions.forEach(option => {
    option.addEventListener('click', function(event) {
      event.preventDefault();
      const period = this.getAttribute('data-period');
      filterPeriodElement.textContent = `| ${period}`;

      fetch(`includes/config/fetch-previous-tenant.php?period=${period}`)
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            console.error(data.error);
            return;
          }
          totalPreviousTenantsElement.textContent = data.total_previous_tenants;
        })
        .catch(error => console.error('Error fetching data:', error));
    });
  });

  // Trigger the default filter option (This Year) on page load
  document.querySelector('.filter-option-prev[data-period="This Year"]').click(); // Removed '.previous-tenants-filter'
});

</script>
