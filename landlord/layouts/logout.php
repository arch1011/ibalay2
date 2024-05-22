<?php
session_start(); 

session_unset();

session_destroy();


header("Location: /iBalay/landlord/authlog/login.php");
exit; 
?>
