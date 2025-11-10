<?php
// Database configuration for Student ID: 24CE070
// Practical 13: Form Validation & User Authentication
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'authdb_24ce070'; // Student-specific authentication database

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die('DB Connection failed for Student 24CE070: ' . $conn->connect_error);
}
// Set charset
$conn->set_charset('utf8mb4');
?>
