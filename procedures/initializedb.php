<?php

require ("dbconnect.php");

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "DROP TABLE IF EXISTS user;";
$conn->query($sql);


$userTable = "CREATE TABLE IF NOT EXISTS user (
    username VARCHAR(32) NOT NULL PRIMARY KEY,
    password VARCHAR(64) NOT NULL,
    firstName TEXT (64) NOT NULL,
    lastName TEXT(64) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE);";
$conn->query($userTable);


$sql = "DROP TABLE IF EXISTS item;";
$conn->query($sql);

$itemTable = "CREATE TABLE IF NOT EXISTS item (
    itemId INT(5) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(64) NOT NULL,
    description VARCHAR(255),
    category TEXT(32),
    price DECIMAL(10,2),
    postDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    username VARCHAR(32) NOT NULL,
    FOREIGN KEY (username) REFERENCES user(username));";
$conn->query($itemTable);



$queries = array(
    "INSERT INTO user(username, password, firstName, lastName, email) VALUES
    ('john1', 'p@ssword1', 'John', 'Smith', 'john.smith@example.com'),
    ('jane2', 'p@ssword2', 'Jane', 'Doe', 'jane.doe@example.com'),
    ('matt3', 'p@ssword3', 'Matt', 'Garcia', 'jason.garcia@example.com'),
    ('lisa4', 'p@ssword4', 'Lisa', 'Kim', 'lisa.kim@example.com'),
    ('alice5', 'p@ssword5', 'Alice', 'Williams', 'alice.williams@example.com')",
    
    "INSERT INTO item(title, description, category, price, username) VALUES
    ('item1', 'description1', 'category1', '100.00', 'john1'),
    ('item2', 'description2', 'category1', '200.00', 'john1'),
    ('item3', 'description3', 'category2', '300.00', 'john1'),
    ('item4', 'description4', 'category2', '400.00', 'john1'),
    ('item5', 'description5', 'category3', '500.00', 'john1')"
);

foreach ($queries as $query) {
    if ($conn->query($query) === TRUE) {
        header("Location: ../index.php?error=initsuccess");
    } else {
        echo "Error inserting into database: " . $conn->error;
    }
}
    

$conn->close();
?>



