       <?php 
         include('config/property-cheap.php');
       ?>

       
<!-- CSS to ensure consistent image size -->
<style>
.property-item .img {
    height: 400px; /* Adjust as needed */
    overflow: hidden; /* Hide overflow to ensure consistency */
    display: flex;
    justify-content: center;
    align-items: center;
}

.property-item .img img {
    max-height: 100%; /* Keep images within the defined height */
    max-width: 100%; /* Ensure images don't exceed the container */
    object-fit: cover; /* Maintain aspect ratio while filling the container */
}
</style>

<div class="section">
  <div class="container">
    <div class="row mb-5 align-items-center">
      <div class="col-lg-6 text-center mx-auto">
        <h2 class="font-weight-bold text-primary heading">
          10 Cheapest Rooms
        </h2>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="property-slider-wrap">
          <div class="property-slider">
            <?php foreach ($rooms as $room): ?>
              <div class="property-item">
                <a href="property-single.php?room_id=<?= $room['room_id'] ?>" class="img">
                  <img src="<?= "/iBalay/uploads/roomphotos/room{$room['room_number']}_landlord{$room['landlord_id']}/{$room['room_photo1']}" ?>" alt="Image" class="img-fluid" />
                </a>

                <div class="property-content">
                  <div class="price mb-2"><span><?= "₱" . number_format($room['room_price'], 2) ?></span></div>
                  <div>
                    <span class="d-block mb-2 text-black-50"><?= $room['BH_address'] ?></span>
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

                    <a href="property-single.php?room_id=<?= $room['room_id'] ?>" class="btn btn-primary py-2 px-3">See details</a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <div
            id="property-nav"
            class="controls"
            tabindex="0"
            aria-label="Carousel Navigation"
          >
            <span
              class="prev"
              data-controls="prev"
              aria-controls="property"
              tabindex="-1"
              >Prev</span
            >
            <span
              class="next"
              data-controls="next"
              aria-controls="property"
              tabindex="-1"
              >Next</span
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</div>