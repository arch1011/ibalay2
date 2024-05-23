<div class="section" >
      <div class="container">
        <div class="row mb-5 align-items-center">
          <div class="col-lg-6">
            <h2 class="font-weight-bold text-primary heading">
              Popular Properties
            </h2>
          </div>
          <div class="col-lg-6 text-lg-end">
            <p>
              <a
                href="properties.php"
                class="btn btn-primary text-white py-3 px-4"
                style="margin-bottom: -10px;"
                >View all properties</a
              >
            </p>
          </div>
        </div>

       <?php
         include('config/property-config.php');
       ?>

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
                      <div class="price mb-2">
                        <span><?= "Room price: ₱ " . number_format($room['room_price'], 2) ?></span> <!-- Displaying the room price -->
                      </div>
                      <div>
                        <span class="d-block mb-2 text-black-50"><?= $room['BH_address'] ?></span> <!-- Displaying the building address -->
                        <div class="specs d-flex mb-4">
                          <span class="d-block d-flex align-items-center me-3">
                            <span class="icon-bed me-2"></span>
                            <span class="caption"><?= $room['capacity'] ?> beds availabe</span>
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
                    >Prev</span>
                  
                  <span
                    class="next"
                    data-controls="next"
                    aria-controls="property"
                    tabindex="-1"
                    >Next</span>
                  
                </div>
    </div>
  </div>
</div>

<hr>

</div>
    </div>

