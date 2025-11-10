<?php
$host = "localhost";
$user = "root";    
$pass = "";        
$dbname = "college_24ce070"; // Student-specific database for 24CE070

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed for Student 24CE070: " . mysqli_connect_error());
}

// Database configured for Practical 11 - Student ID: 24CE070
?>
