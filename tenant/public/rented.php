<?php
include('../../tenant/session.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Untree.co" />
    <link rel="shortcut icon" href="favicon.png" />

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap5" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <link rel="stylesheet" href=".././../Resources/fonts/icomoon/style.css" />
    <link rel="stylesheet" href="../../Resources/fonts/flaticon/font/flaticon.css" />

    <link rel="stylesheet" href="../../Resources/css/tiny-slider.css" />
    <link rel="stylesheet" href="../../Resources/css/aos.css" />
    <link rel="stylesheet" href="../../Resources/css/style.css" />

        <!-- CSS to set consistent image size -->
        <link rel="stylesheet" href="../includes/css/room-review.css" />

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        

    <title>
      My Room
    </title>

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

          <?php
            include('../includes/nav-top.php');
          ?>

          <?php
            include('../includes/my-room.php');
          ?>

          <hr>

      </div>
    </div>
  </div>
</div>



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



    <script>
    function openReportModal() {
        $('#addReportModal').modal('show');
    }
</script>


  </body>
</html>
