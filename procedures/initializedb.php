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

$conn->query($sql);

$conn->close();
?>


<!DOCTYPE html>
    <html>
        <head>    
            <meta charset="TF-8">
            <meta name="viewport" content="width=device-width, initial scale=1.0">
            <title>Sign in</title>
            <link rel="stylesheet" href="../style.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        </head>
        <body>
            <div class = "container">
                <div class = "content">
                    <h2>Success!</h2>
                    <p>The database has been initialized.</p>
                    <form action="../index.php" method="post">
                        <button type="submit" name="submit" class="button">Go back</button>                
                    </form>
                </div>
            </div>
        </body>
