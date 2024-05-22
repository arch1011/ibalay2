<?php
session_start(); 

session_unset();

session_destroy();


header("Location: /iBalay/tenant/authlog/authlog.php");
exit; 
?>
