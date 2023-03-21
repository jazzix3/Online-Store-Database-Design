<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "COMP440";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  exit("Database connection failed: " . $conn->connect_error);
}
echo "Successfully connected to the database";
?>