<?php
// *** Change this to your server info***
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "COMP440";

// Create connection and display error if connection fails
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  exit("Database connection failed: " . $conn->connect_error);
}
?>