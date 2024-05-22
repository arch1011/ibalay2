<?php 
         include('config/bookmark-fetch.php');
       ?>

<div class="section section-properties">
    <div class="container">
    <div class="row">
    <?php foreach ($rooms as $room): ?>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
            <div class="property-item mb-30">
                <!-- Room Image -->
                <a href="property-single.php?room_id=<?= $room['room_id'] ?>" class="img">
                    <img src="<?= "/iBalay/uploads/roomphotos/room{$room['room_number']}_landlord{$room['landlord_id']}/{$room['room_photo1']}" ?>" alt="Room Image" class="img-fluid" />
                </a>
                <!-- Property Content -->
                <div class="property-content">
                    <div class="price mb-2"><span><?= "₱" . number_format($room['room_price'], 2) ?></span></div>
                    <div>
                        <span class="d-block mb-2 text-black-50"><?= $room['BH_address'] ?></span>
                        <!-- Beds and Kitchens -->
                        <div class="specs d-flex mb-4">
                            <span class="d-block d-flex align-items-center me-3">
                                <span class="icon-bed me-2"></span>
                                <span class="caption"><?= $room['capacity'] ?> beds</span>
                            </span>
                            <span class="d-block d-flex align-items-center">
                                <span class="icon-kitchen me-2"></span>
                                <span class="caption"><?= $room['number_of_kitchen'] ?> kitchen(s)</span>
                            </span>
                        </div>
                        <!-- Buttons -->
                        <a href="property-single.php?room_id=<?= $room['room_id'] ?>" class="btn btn-primary py-2 px-3">See details</a>
                        <button type="button" class="btn btn-danger py-2 px-3" data-toggle="modal" data-target="#deleteModal" data-room-id="<?= $room['room_id'] ?>">Delete Bookmark</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Pagination Controls -->
<div class="row align-items-center py-5">
    <div class="col-lg-3">Page <?= $current_page ?> of <?= $total_pages ?></div>
    <div class="col-lg-6 text-center">
        <div class="custom-pagination">
            <!-- Displaying Pagination Links -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" <?= $i === $current_page ? 'class="active"' : '' ?>><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </div>
</div>
</div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Set room ID in delete modal form when delete button is clicked
            $('#deleteModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var roomId = button.data('room-id');
                var modal = $(this);
                modal.find('#deleteRoomId').val(roomId);
            });

            // Add event listener to delete button within modal
            $('#confirmDelete').on('click', function() {
                // Submit the form when delete button is clicked
                $('#deleteForm').submit();
            });
        });
    </script>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this bookmark?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteForm" action="../includes/config/delete-bookmark.php" method="post">
                    <input type="hidden" id="deleteRoomId" name="room_id" value="" />
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
