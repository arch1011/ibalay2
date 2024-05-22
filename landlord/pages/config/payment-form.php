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

// Fetch tenants and their last payment details along with due date
$tenants = [];
$query = "
    SELECT 
        t.TenantID, t.FirstName, t.LastName, MAX(tp.payment_date) AS last_payment_date, MAX(tp.amount) AS last_payment_amount, rr.end_date AS due_date
    FROM 
        rented_rooms rr
    INNER JOIN 
        tenant t ON rr.TenantID = t.TenantID
    LEFT JOIN 
        tenant_payments tp ON t.TenantID = tp.TenantID
    WHERE 
        rr.landlord_id = $landlord_id 
    AND 
        t.checked_out = 0
    GROUP BY 
        t.TenantID, t.FirstName, t.LastName, rr.end_date
    ORDER BY 
        t.TenantID
";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tenantID = $row['TenantID'];
        $tenants[$tenantID]['name'] = $row['FirstName'] . ' ' . $row['LastName'];
        $tenants[$tenantID]['last_payment_date'] = $row['last_payment_date'];
        $tenants[$tenantID]['last_payment_amount'] = $row['last_payment_amount'];
        $tenants[$tenantID]['due_date'] = $row['due_date'];
    }
}

// Close the result set and database connection
mysqli_free_result($result);
mysqli_close($conn);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Add New Payment</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Payment History</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            <h5 class="card-title" style="font-size: 18px;">Select a Tenant for New Payment</h5>
            <form method="GET" action="">
                <div class="mb-3">
                    <label for="tenantSelect" class="form-label">Select Tenant:</label>
                    <select class="form-select" id="tenantSelect" name="tenant_id" required>
                        <option value="" selected disabled>Select Tenant</option>
                        <?php foreach ($tenants as $tenantID => $tenant): ?>
                            <option value="<?= $tenantID ?>"><?= htmlspecialchars($tenant['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Choose Tenant</button>
            </form>
        </div>
    </div>

    <div class="card">
  <div class="card-body">
    <?php if (isset($_GET['tenant_id']) && isset($tenants[$_GET['tenant_id']])): ?>
        <h5 class="card-title" style="font-size: 18px;">Payment Section</h5>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Last Payment Date</th>
                    <th scope="col">Due Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($tenants[$_GET['tenant_id']]['last_payment_date']) ?></td>
                    <td><?= htmlspecialchars($tenants[$_GET['tenant_id']]['due_date']) ?></td>
                </tr>
            </tbody>
        </table>
        <p>Last Payment Amount: <?= htmlspecialchars($tenants[$_GET['tenant_id']]['last_payment_amount']) ?></p>
        <p>Boarder Name: <?= htmlspecialchars($tenants[$_GET['tenant_id']]['name']) ?></p>

        <form action="config/payment-process.php" method="POST">
            <div class="mb-3">
                <label for="newDueDate" class="form-label">New Due Date</label>
                <input type="date" class="form-control" id="newDueDate" name="new_due_date" required>
            </div>
            <div class="mb-3" hidden>
                <label for="paymentDate" class="form-label">Payment Date</label>
                <input type="date" class="form-control" id="paymentDate" name="payment_date" value="<?= date('Y-m-d') ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="paymentAmount" class="form-label">Payment Amount</label>
                <input type="number" class="form-control" id="paymentAmount" name="amount" required>
            </div>
            <input type="hidden" name="tenant_id" value="<?= htmlspecialchars($_GET['tenant_id']) ?>">
            <button type="submit" class="btn btn-primary">Submit Payment</button>
        </form>
    <?php endif; ?>
  </div>
</div>



</main><!-- End #main -->
