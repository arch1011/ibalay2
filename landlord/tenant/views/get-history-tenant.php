<?php
    include ('tasks/history-config.php');
?>



    <div class="card" style="font-size: 10px;">
        <div class="card-body">
            <h5 class="card-title" style="font-size: 18px;">Boarder History</h5>
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


