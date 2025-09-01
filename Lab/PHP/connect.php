<?php
$host="localhost";
$user="Aryan";
$pass="08Aryan@06Parikh";
$db="D1";

$conn = mysqli_connect($host,$user,$pass,$db);
if(!$conn)
{
    die("Connection Failed!". mysqli_connect_error());
}
echo"Connected Succesfully";

$tableCreationQuery="
";
?>