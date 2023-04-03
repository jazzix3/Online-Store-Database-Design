<?php

require ("dbconnect.php");

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "DROP TABLE IF EXISTS user;";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS user (
    username VARCHAR(32) NOT NULL PRIMARY KEY,
    password VARCHAR(64) NOT NULL,
    firstName TEXT (64) NOT NULL,
    lastName TEXT(64) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE);";
$conn->query($sql);


$sql = " INSERT INTO user(username, password, firstName, lastName, email) VALUES
    ('john1', 'p@ssword1', 'John', 'Smith', 'john.smith@example.com'),
    ('jane2', 'p@ssword2', 'Jane', 'Doe', 'jane.doe@example.com'),
    ('matt3', 'p@ssword3', 'Matt', 'Garcia', 'jason.garcia@example.com'),
    ('lisa4', 'p@ssword4', 'Lisa', 'Kim', 'lisa.kim@example.com'),
    ('alice5', 'p@ssword5', 'Alice', 'Williams', 'alice.williams@example.com')";

if ($conn->query($sql) === TRUE) {
    // Query was successful, redirect the user
    header("Location: ../index.php?error=initsuccess");
}

$conn->close();
?>



