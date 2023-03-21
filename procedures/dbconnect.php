<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "COMP440";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  exit("Database connection failed: " . $conn->connect_error);
}
echo "Successfully connected to the database";
?>