<?php
include('views/tasks/fetch-room-details.php');
?>

<main id="main" class="main">
        <div class="pagetitle">
            <h1>Your Boarding House!</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Room List</a></li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

                <div class="card"  style="font-size: 10px;">
                    <div class="card-body">
                        <h5 class="card-title">Room List</h5>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Room Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($rooms)): ?>
                                    <?php foreach ($rooms as $room): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($room['room_number']); ?></td>
                                            <td>
                                                <button class="btn btn-primary" data-bs-toggle="modal" 
                                                        data-bs-target="#roomDetailsModal" 
                                                        data-room-details='<?php echo json_encode($room); ?>'>
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2">No rooms available. Add some rooms!</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- End card -->


                    <?php
                         include('views/modal-room.php');
                    ?>

</main><!-- End #main -->

<!-- JavaScript to Populate the Modal -->
<script src="views/tasks/fetch-room.js"></script>
