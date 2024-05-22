<?php
include('../../tenant/session.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Untree.co" />
    <link rel="shortcut icon" href="../../assets/img/evsufav.png" />

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap5" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href=".././../Resources/fonts/icomoon/style.css" />
    <link rel="stylesheet" href="../../Resources/fonts/flaticon/font/flaticon.css" />

    <link rel="stylesheet" href="../../Resources/css/tiny-slider.css" />
    <link rel="stylesheet" href="../../Resources/css/aos.css" />
    <link rel="stylesheet" href="../../Resources/css/style.css" />

    <!-- CSS to set consistent image size -->
    <link rel="stylesheet" href="../includes/css/property-list.css" />
    
   <title>
      Searched Property
    </title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  </head>

  <body>

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close">
          <span class="icofont-close js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    </div>

    <?php
      include('../includes/nav-top.php');
    ?>

    <div
      class="hero page-inner overlay"
      style="background-image: url('../../Resources/images/hero_bg_1_copy.jpg')"
      >
      <div class="container">
        <div class="row justify-content-center align-items-center">
          <div class="col-lg-9 text-center mt-5">
            <h1 class="heading" data-aos="fade-up">Properties Result</h1>

            <nav
              aria-label="breadcrumb"
              data-aos="fade-up"
              data-aos-delay="200"
            >
              <ol class="breadcrumb text-center justify-content-center">
                <li class="breadcrumb-item"><a href="/iBalay/tenant/public/home.php">Home</a></li>
                <li
                  class="breadcrumb-item active text-white-50"
                  aria-current="page"
                >
                  Properties Result
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>

    <br>

                <?php

            $host = 'localhost';
            $dbname = 'iBalay_System';
            $username = 'root';
            $password = '';

            // Create a connection using MySQLi
            $conn = mysqli_connect($host, $username, $password, $dbname);

            // Check for successful connection
            if (!$conn) {
                error_log("Database connection failed: " . mysqli_connect_error(), 0);
                die("Connection failed. Please try again later.");
            }

            // Set character set to UTF-8
            mysqli_set_charset($conn, 'utf8');

            // Turn on error reporting
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            if(isset($_GET['query'])) {
                $search_query = $_GET['query'];

                $sql = "SELECT room.*, bh_information.*
                FROM room
                LEFT JOIN bh_information ON room.landlord_id = bh_information.landlord_id
                WHERE room.description LIKE '%$search_query%' OR 
                      room.capacity LIKE '%$search_query%' OR 
                      room.room_price = '$search_query' OR 
                      bh_information.BH_address LIKE '%$search_query%' OR
                      bh_information.BH_name LIKE '%$search_query%'";

                $result = mysqli_query($conn, $sql);

                // Fetch the rooms into an array
                $rooms = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $rooms[] = $row;
                }

                $items_per_page = 6; // Adjust as needed
                $total_rooms = count($rooms);
                $total_pages = ceil($total_rooms / $items_per_page);
                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start_index = ($current_page - 1) * $items_per_page;
                $rooms_on_current_page = array_slice($rooms, $start_index, $items_per_page);
            ?>
            <div class="row mb-5 align-items-center">
                <div class="col-lg-6 text-center mx-auto">
                    <h2 class="font-weight-bold text-primary heading">Searched Property</h2>
                </div>
            </div>

            <!-- HTML and Pagination Controls -->
            <div class="section section-properties">
                <div class="container">
                    <?php if(empty($rooms_on_current_page)): ?>
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <p>No results found.</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($rooms_on_current_page as $room): ?>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                                    <div class="property-item mb-30">
                                        <a href="property-single.php?room_id=<?= $room['room_id'] ?>" class="img">
                                            <img src="<?= "/iBalay/uploads/roomphotos/room{$room['room_number']}_landlord{$room['landlord_id']}/{$room['room_photo1']}" ?>" alt="Room Image" class="img-fluid" />
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
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Pagination Controls -->
                    <div class="row align-items-center py-5">
                        <div class="col-lg-3">Page <?= $current_page ?> of <?= $total_pages ?></div>
                        <div class="col-lg-6 text-center">
                            <div class="custom-pagination">
                                <!-- Displaying Pagination Links -->
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <a href="?query=<?= $search_query ?>&page=<?= $i ?>" <?= $i == $current_page ? 'class="active"' : '' ?>><?= $i ?></a>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

    <!-- Preloader -->
    <div id="overlayer"></div>
    <div class="loader">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <script src="../../Resources/js/bootstrap.bundle.min.js"></script>
    <script src="../../Resources/js/tiny-slider.js"></script>
    <script src="../../Resources/js/aos.js"></script>
    <script src="../../Resources/js/navbar.js"></script>
    <script src="../../Resources/js/counter.js"></script>
    <script src="../../Resources/js/custom.js"></script>


  </body>
</html>
