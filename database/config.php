<?php

//configure here

$host = 'localhost'; 
$dbname = 'iBalay_System'; 
$username = 'root'; 
$password = ''; 

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    error_log("Database connection failed: " . mysqli_connect_error(), 0); 
    die("Connection failed. Please try again later."); 
} else {
    mysqli_set_charset($conn, 'utf8');
    
}

?>
