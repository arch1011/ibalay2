<!-- Total Boarders Card -->
<div class="col-xxl-4 col-md-6">
  <div class="card info-card sales-card">
    <div class="filter">
      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
          <h6>Filter</h6>
        </li>
        <li><a class="dropdown-item filter-option-tenant" data-gender="Male" href="#">Male</a></li>
        <li><a class="dropdown-item filter-option-tenant" data-gender="Female" href="#">Female</a></li>
        <li><a class="dropdown-item filter-option-tenant" data-gender="All" href="#">All</a></li>
      </ul>
    </div>
    <div class="card-body">
      <h5 class="card-title">Total Boarders</h5>
      <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
          <i class="bi bi-people"></i>
        </div>
        <div class="ps-3">
          <h6 id="total-boarders-count">
            <!-- Total boarders count will be updated here -->
          </h6>
          <span class="text-muted small pt-2 ps-1">Boarders</span>
        </div>
      </div>
    </div>
  </div>
</div><!-- End Card -->

<script>
document.addEventListener('DOMContentLoaded', function() {
  const filterOptions = document.querySelectorAll('.filter-option-tenant');
  const totalBoardersElement = document.getElementById('total-boarders-count');

  filterOptions.forEach(option => {
    option.addEventListener('click', function(event) {
      event.preventDefault();
      const gender = this.getAttribute('data-gender');
      
      fetch(`includes/config/fetch-boarder.php?gender=${gender}`)
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            console.error(data.error);
            return;
          }
          console.log('Total boarders:', data.total_boarders); // Debugging line
          totalBoardersElement.textContent = data.total_boarders;
        })
        .catch(error => console.error('Error fetching data:', error));
    });
  });

  // Trigger the default filter option (All) on page load
  document.querySelector('.filter-option-tenant[data-gender="All"]').click();
});
</script>
