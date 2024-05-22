
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

        <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Add Room Form!</h5>
                       
                  <form class="row g-3" action="views/tasks/add-room-process.php" method="post" enctype="multipart/form-data">
    <div class="col-md-6">
        <label for="inputRoomNumber" class="form-label">Room Number</label>
        <input type="number" name="inputRoomNumber" class="form-control" placeholder="Enter Room Number" required>
    </div>

    <div class="col-12">
        <label for="inputDescription" class="form-label">Description</label>
        <textarea name="inputDescription" class="form-control" rows="3" placeholder="Enter Room Description" required></textarea>
    </div>

    <div class="col-md-6">
        <label for="inputCapacity" class="form-label">Capacity</label>
        <input type="number" name="inputCapacity" class="form-control" placeholder="Enter Room Capacity" required>
    </div>

    <div class="col-md-6">
        <label for="inputRoomPrice" class="form-label">Room Price</label>
        <input type="number" step="0.01" name="inputRoomPrice" class="form-control" placeholder="Enter Room Price" required>
    </div>

    <div class="col-md-6">
        <label for="inputRoomPhoto1" class="form-label">Room Photo 1</label>
        <input type="file" name="inputRoomPhoto1" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label for="inputRoomPhoto2" class="form-label">Room Photo 2</label>
        <input type="file" name="inputRoomPhoto2" class="form-control" required>
    </div>

    <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </div>
</form>




                </div>
            </div>
        </div>

</section>

</main><!-- End #main -->