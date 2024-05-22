<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/img/evsu.png" rel="icon">
    <link rel="stylesheet" href="css/login.css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
  .field.error input {
    border-color: red;
  }
  .error-message {
    color: red;
    font-size: 14px;
    display: none;
  }
</style>


</head>

<body>


<?php
  include('layouts/loginauth.php');
?>

<script src="js/auth.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    $("#loginForm").on("submit", function(event) {
      event.preventDefault(); // Prevent default form submission

      $.ajax({
        type: "POST",
        url: "tasks/login_process.php",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
          if (response.success) {
            window.location.href = response.redirectURL;
          } else {
            // Show error message and highlight input fields
            $("#loginError").text(response.message).show();
            $(".field input").addClass("error");
          }
        },
        error: function() {
          // Handle server errors
          $("#loginError").text("An unexpected error occurred. Please try again later.").show();
          $(".field input").addClass("error");
        }
      });
    });

    // Remove error state when user starts typing
    $("input").on("input", function() {
      $(this).removeClass("error");
      $("#loginError").hide();
    });
  });
</script>




</html> 