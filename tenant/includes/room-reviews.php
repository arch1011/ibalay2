      <?php 
         include('config/room-review.php');
       ?>


<div class="section sec-testimonials">
  <div class="container">
    <div class="row mb-5 align-items-center">
      <div class="col-md-6">
        <h4 class="font-weight-bold heading text-primary mb-4 mb-md-0">
          Reviews
        </h4>
      </div>
      <div class="col-md-6 text-md-end">
        <div id="testimonial-nav">
          <span class="prev" data-controls="prev">Prev</span>
          <span class="next" data-controls="next">Next</span>
        </div>
      </div>
    </div>

    <div class="testimonial-slider-wrap">
      <div class="testimonial-slider">
        <?php if (empty($reviews)): ?>
          <!-- Display message if there are no reviews -->
          <div class="item">
            <div class="testimonial">
              <p>No reviews at the moment.</p>
            </div>
          </div>
        <?php else: ?>
          <?php foreach ($reviews as $review): ?>
            <div class="item">
              <div class="testimonial">
                <!-- Display the rating as stars -->
                <div class="rate">
                  <?php for ($i = 0; $i < 5; $i++): ?>
                    <span class="icon-star <?= $i < $review['room_rating'] ? 'text-warning' : '' ?>"></span>
                  <?php endfor; ?>
                </div>

                <h3 class="h5 text-primary mb-4">
                  <?= htmlspecialchars($review['FirstName'] . ' ' . $review['LastName']) ?>
                </h3>
                
                <blockquote>
                  <p>
                    <?= htmlspecialchars($review['review_comment']) ?>
                  </p>
                </blockquote>
                
                <p class="text-black-50">Reviewed on <?= htmlspecialchars($review['review_date']) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
