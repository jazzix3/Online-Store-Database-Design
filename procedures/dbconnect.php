<?php
// *** Change this to your server info***
$servername = "127.0.0.1";
$username = "root";
$password = "mysql";
$dbname = "Comp440Project";

// Create connection and display error if connection fails
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  exit("Database connection failed: " . $conn->connect_error);
}
?>