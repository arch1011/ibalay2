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

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Set character set to UTF-8
mysqli_set_charset($conn, 'utf8');

// Get the landlord ID from the session
$landlord_id = $_SESSION['landlord_id'];

// Fetch tenants and their payment details
$tenants = [];
$query = "
    SELECT 
        t.TenantID, t.FirstName, t.LastName, t.checked_out, tp.payment_date, tp.amount
    FROM 
        rented_rooms rr
    INNER JOIN 
        tenant t ON rr.TenantID = t.TenantID
    LEFT JOIN 
        tenant_payments tp ON t.TenantID = tp.TenantID
    WHERE 
        rr.landlord_id = $landlord_id
    ORDER BY 
        t.TenantID, tp.payment_date
";


$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tenantID = $row['TenantID'];
        $tenants[$tenantID]['name'] = $row['FirstName'] . ' ' . $row['LastName'];
        $tenants[$tenantID]['checked_out'] = $row['checked_out']; // Add checked_out value for debugging
        if ($row['payment_date']) {
            $tenants[$tenantID]['payments'][] = [
                'payment_date' => $row['payment_date'],
                'amount' => $row['amount']
            ];
        } else {
            $tenants[$tenantID]['payments'] = [];
        }
    }
}


// Close the result set and database connection
mysqli_free_result($result);
mysqli_close($conn);
?>


<main id="main" class="main">
    <div class="pagetitle">
        <h1>Boarders payments history</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Payment History</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card" >
        <div class="card-body">
            <h5 class="card-title" style="font-size: 18px;">Select a Boarder</h5>

            <form method="GET" action="">
                <div class="mb-3">
                    <label for="tenantSelect" class="form-label">Select Tenant</label>
                    <select class="form-select" id="tenantSelect" name="tenant_id" onchange="this.form.submit()">
                        <option selected disabled>Select a tenant</option>
                        <?php foreach ($tenants as $tenantId => $tenant): ?>
                            <option value="<?= $tenantId ?>" <?= isset($_GET['tenant_id']) && $_GET['tenant_id'] == $tenantId ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tenant['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>

            <?php if (isset($_GET['tenant_id']) && isset($tenants[$_GET['tenant_id']])): ?>
                <!-- Card for displaying payments -->
                <div id="paymentCard" class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 18px;">Payments</h5>
                        <?php if (!empty($tenants[$_GET['tenant_id']]['payments'])): ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Payment date</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $totalAmount = 0;
                                        foreach ($tenants[$_GET['tenant_id']]['payments'] as $payment): 
                                            $totalAmount += $payment['amount'];
                                    ?>
                                    <tr>
                                        <td><?= $payment['payment_date'] ?></td>
                                        <td>₱ <?= $payment['amount'] ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td><strong>Total</strong></td>
                                        <td><strong>₱ <?= $totalAmount ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No payments found for this tenant.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>


</main><!-- End #main -->
