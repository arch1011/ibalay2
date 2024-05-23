<?php
session_start(); // Start the session if not already started

// Check if LandlordID is set in the session
if (!isset($_SESSION['landlord_id'])) {
    // Redirect or handle the case where LandlordID is not set
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

// Get the landlord ID from the session
$landlord_id = $_SESSION['landlord_id'];

// Query to fetch tenant details, ensuring each tenant is only listed once
$query = "
    SELECT DISTINCT t.TenantID, t.FirstName, t.LastName, t.Email, t.PhoneNumber, t.student_id, t.gender, t.address, t.checked_out
    FROM rented_rooms rr
    INNER JOIN tenant t ON rr.TenantID = t.TenantID
    WHERE rr.landlord_id = $landlord_id
    AND t.checked_out = 0";

$result = mysqli_query($conn, $query);

$tenants = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tenants[] = $row;
    }
}

// Close the result set
mysqli_free_result($result);

// Close the database connection
mysqli_close($conn);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Your Boarders!</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Boarder List</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card" style="font-size: 10px;">
        <div class="card-body">
            <h5 class="card-title" style="font-size: 18px;">Datatables</h5>
            <!-- Table with stripped rows -->
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tenants as $tenant): ?>
                        <tr>
                            <td><?= htmlspecialchars($tenant['FirstName'] . ' ' . $tenant['LastName']) ?></td>
                            <td>
                                <button type="button" class="btn btn-primary view-button" data-id="<?= $tenant['TenantID'] ?>">
                                    View
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- End Table with stripped rows -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tenantModal" tabindex="-1" aria-labelledby="tenantModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tenantModalLabel">Tenant Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tenant details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</main><!-- End #main -->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-button');
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tenantId = this.getAttribute('data-id');
            fetch(`tasks/get-tenant-info.php?tenant_id=${tenantId}`)
                .then(response => response.json())
                .then(data => {
                    const modalBody = document.querySelector('#tenantModal .modal-body');
                    modalBody.innerHTML = `
                        <p><strong>Name:</strong> ${data.FirstName} ${data.LastName}</p>
                        <p><strong>Email:</strong> ${data.Email}</p>
                        <p><strong>Phone Number:</strong> ${data.PhoneNumber}</p>
                        <p><strong>Student ID:</strong> ${data.student_id}</p>
                        <p><strong>Gender:</strong> ${data.gender}</p>
                        <p><strong>Address:</strong> ${data.address}</p>
                    `;
                    const tenantModal = new bootstrap.Modal(document.getElementById('tenantModal'));
                    tenantModal.show();
                });
        });
    });
});
</script>
