<main id="main" class="main">
    <div class="pagetitle">
        <h1>Register your Boarding House!</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Registration</a></li>
                <li class="breadcrumb-item">Forms</li>
            </ol>
        </nav>
    </div>
 
    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">BH Registration Form</h5>

<!-- Form to submit details -->
<form action="form1-process.php" method="post" enctype="multipart/form-data">
    <!-- Boarding House Name Field -->
    <div class="mb-3">
        <label for="BH_name" class="form-label">Boarding House Name</label>
        <input type="text" class="form-control" id="BH_name" name="BH_name" required>
    </div>

    <div class="mb-3">
    <label for="map" class="form-label">Please Point Your Boarding House</label>
    <!-- Bing Map for pinpointing location -->
    <div id="bingMap" style="height: 300px; width: 100%;"></div>
    </div>
    <!-- Fields for storing longitude and latitude -->
    <div class="mb-3">
        <label for="Latitude" class="form-label" hidden>Latitude</label>
        <input type="text" class="form-control" id="Latitude" name="Latitude" readonly hidden> <!-- Read-only -->
    </div>

    <div class="mb-3">
        <label for="Longitude" class="form-label" hidden>Longitude</label>
        <input type="text" class="form-control" id="Longitude" name="Longitude" readonly hidden> <!-- Read-only -->
    </div>

    <!-- Address Input Field -->
    <div class="mb-3">
        <label for="User_Address" class="form-label">Address</label>
        <input type="text" class="form-control" id="User_Address" name="User_Address" placeholder="Enter your address" required>
    </div>

    <!-- Document upload fields -->
    <div class="mb-3">
        <label for="Document1" class="form-label">Document 1</label>
        <input type="file" class="form-control" id="Document1" name="Document1">
    </div>

    <div class="mb-3">
        <label for="Document2" class="form-label">Document 2</label>
        <input type="file" class="form-control" id="Document2" name="Document2">
    </div>

    <!-- Submit button -->
    <button type="submit" class="btn btn-primary">Register BH</button>
</form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
