<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "eventmaster_24ce070"; // EventMaster Pro database for Student 24CE070

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("DB Connection failed for Student 24CE070: " . $conn->connect_error);
}

// Event Management Database for Practical 12 - Student ID: 24CE070
?>
