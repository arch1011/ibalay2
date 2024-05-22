
<main id="main" class="main">

<div class="pagetitle">
  <h1>Register your Boarding House!</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Registration</a></li>
      <li class="breadcrumb-item">Forms</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-6">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">BH Registration Form</h5>

          <form action="form2-process.php" method="post">
            
            <!-- Monthly Payment Rate -->
            <div class="row mb-3">
              <label for="monthlyPayment" class="col-sm-2 col-form-label">Monthly Payment Rate</label>
              <div class="col-sm-10">
                <input type="text" name="monthly_payment_rate" id="monthlyPayment" class="form-control" placeholder="1000 - 5000">
              </div>
            </div>

            <!-- Number of Kitchens -->
            <div class="row mb-3">
              <label for="numKitchens" class="col-sm-2 col-form-label">Number of Kitchens</label>
              <div class="col-sm-10">
                <input type="number" name="number_of_kitchen" id="numKitchens" class="form-control" placeholder="Enter number of kitchens">
              </div>
            </div>

            <!-- Number of Living Rooms -->
            <div class="row mb-3">
              <label for="numLivingRooms" class="col-sm-2 col-form-label">Number of Living Rooms</label>
              <div class="col-sm-10">
                <input type="number" name="number_of_living_room" id="numLivingRooms" class="form-control" placeholder="Enter number of living rooms">
              </div>
            </div>

            <!-- Number of Students -->
            <div class="row mb-3">
              <label for="numStudents" class="col-sm-2 col-form-label">Number of Students (Current)</label>
              <div class="col-sm-10">
                <input type="number" name="number_of_students" id="numStudents" class="form-control" placeholder="Enter number of students">
              </div>
            </div>

            <!-- Number of CR (Comfort Rooms) -->
            <div class="row mb-3">
              <label for="numCR" class="col-sm-2 col-form-label">Number of CR</label>
              <div class="col-sm-10">
                <input type="number" name="number_of_cr" id="numCR" class="form-control" placeholder="Enter number of comfort rooms">
              </div>
            </div>

            <!-- Number of Beds -->
            <div class="row mb-3">
              <label for="numBeds" class="col-sm-2 col-form-label">Number of Beds</label>
              <div class="col-sm-10">
                <input type="number" name="number_of_beds" id="numBeds" class="form-control" placeholder="Enter number of beds">
              </div>
            </div>

            <!-- Number of Rooms -->
            <div class="row mb-3">
              <label for="numRooms" class="col-sm-2 col-form-label">Number of Rooms</label>
              <div class="col-sm-10">
                <input type="number" name="number_of_rooms" id="numRooms" class="form-control" placeholder="Enter number of rooms">
              </div>
            </div>

            <!-- Boarding House Max Capacity -->
            <div class="row mb-3">
              <label for="maxCapacity" class="col-sm-2 col-form-label">BH Max Capacity</label>
              <div class="col-sm-10">
                <input type="number" name="bh_max_capacity" id="maxCapacity" class="form-control" placeholder="Enter max capacity">
              </div>
            </div>

            <!-- Gender Allowed -->
            <div class="row mb-3">
              <label for="genderAllowed" class="col-sm-2 col-form-label">Gender Allowed</label>
              <div class="col-sm-10">
                <select name="gender_allowed" id="genderAllowed" class="form-select">
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                  <option value="all">All</option>
                </select>
              </div>
            </div>

            <!-- Submit Button -->
            <div class="row mb-3">
              <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>

          </form>


        </div>
      </div>

    </div>

  </div>
</section>

</main><!-- End #main -->