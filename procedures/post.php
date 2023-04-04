<?php
session_start();

// If user is not logged in, redirect to index.php to log in
if (!isset($_SESSION["username"])){
    header("Location: index.php?error=invalidsession");
    exit();
}

require("dbconnect.php");

$username = $_SESSION["username"];


// Count number of items posted by user today
$sql = "SELECT COUNT(*) FROM item WHERE username = '$username' AND DATE(postDate) = DATE(NOW());";
$result = mysqli_query($conn, $sql);
$count = mysqli_fetch_array($result)[0];

if ($count >= 3) {
    header("Location: ../postitem.php?error=reachedlimit");
    exit();
}

// If user has not posted 3 items today and user accessed using post method, insert item
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $category = $_POST["category"];
    $price = $_POST["price"];

    $stmt = $conn->prepare("INSERT INTO item (title, description, category, price, username) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $description, $category, $price, $username);

    if ($stmt->execute()) {
        header("Location: ../index.php?error=none");
            exit();   
    } else {
        echo "Error inserting data: " . $conn->error;
    }
}

?>
