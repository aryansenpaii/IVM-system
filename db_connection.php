<?php
$host = "localhost";  // e.g., "localhost"
$username = "root";
$password = "";
$database = "logininfo";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
