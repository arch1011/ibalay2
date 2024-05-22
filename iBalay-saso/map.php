<?php require 'sidebar.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SASO ADMIN</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/evsu.png" rel="icon">
  <link href="assets/img/evsu.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>iBalay Maps</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/iBalay.com/iBalay-saso/index.php">Home</a></li>
          <li class="breadcrumb-item active">Navigate</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

<!--==========================================Start map =========================================================-->
<div class="card">
    <div class="card-body">
        <h5 class="card-title">iBalay Boarding Houses Map</h5>
        <div id="bingMap" style="height: 400px; width: 100%;"></div>
    </div>
</div>

<!-- Include Bing Maps SDK script from Microsoft -->
<script type="text/javascript" src="https://www.bing.com/api/maps/mapcontrol?key=AvFonBVo0VcCo1NO806rnp9M7EQkE7zV7fTBkCSlR0hzY-GbYE1w1RCE0emZcsHy&callback=loadMapScenario" async defer></script>

<!-- Initialize the Bing Map and load address data from the database -->
<script>
    <?php
    include '../database/config.php';

    $sqlRoomData = "SELECT bh_id, latitude, longitude, BH_name, BH_address, Status FROM bh_information WHERE Status = '1'";
    $resultRoomData = mysqli_query($conn, $sqlRoomData);

    $roomData = array();

    if ($resultRoomData && mysqli_num_rows($resultRoomData) > 0) {
        while ($row = mysqli_fetch_assoc($resultRoomData)) {
            $roomData[] = array(
                'bh_id' => $row['bh_id'],
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude'],
                'BH_name' => $row['BH_name'],
                'BH_address' => $row['BH_address'],
            );
        }
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

    var roomData = <?php echo json_encode($roomData); ?>;

    function loadMapScenario() {
        var map = new Microsoft.Maps.Map(document.getElementById('bingMap'), {
            credentials: 'AvFonBVo0VcCo1NO806rnp9M7EQkE7zV7fTBkCSlR0hzY-GbYE1w1RCE0emZcsHy',
            center: new Microsoft.Maps.Location(11.0511, 125.0144), // Centered at Tanauan, Leyte, Philippines
            zoom: 11
        });

        // Loop through room data and add pushpins to the map
        roomData.forEach(function (room) {
            var location = new Microsoft.Maps.Location(room.latitude, room.longitude);

            // Create a pushpin for each room
            var pushpin = new Microsoft.Maps.Pushpin(location, {
                title: room.BH_name,
                icon: 'assets/img/icon.png', // Optional: custom icon for the pushpin
            });

            // Create an infobox to show the room details
            var infobox = new Microsoft.Maps.Infobox(location, {
                visible: false
            });
            infobox.setMap(map);

            // Add mouseover event to show the infobox
            Microsoft.Maps.Events.addHandler(pushpin, 'mouseover', function () {
                infobox.setOptions({
                    location: pushpin.getLocation(),
                    title: room.BH_name,
                    description: '<strong>Boarding House:</strong> ' + room.BH_name + '<br>' +
                                 '<strong>Address:</strong> ' + room.BH_address + '<br>' +
                                 '<strong>Latitude:</strong> ' + room.latitude + '<br>' +
                                 '<strong>Longitude:</strong> ' + room.longitude
                });
                infobox.setOptions({ visible: true });
            });

            // Add mouseout event to hide the infobox
            Microsoft.Maps.Events.addHandler(pushpin, 'mouseout', function () {
                infobox.setOptions({ visible: false });
            });

            // Add pushpin to the map
            map.entities.push(pushpin);
        });
    }
</script>
<!--==========================================end map =========================================================-->

</section>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.min.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

</body>

</html>