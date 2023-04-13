<?php 
session_start();

// If user is not logged in, redirect to index.php to log in
if (!isset($_SESSION["username"])){
    header("Location: index.php?error=invalidsession");
    exit();
}

require("procedures/dbconnect.php");

$itemId = $_GET["itemId"];
?>


<!DOCTYPE html>
<html>
<head>    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Reviews</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
</head>
<body>
    <div class="container-main">
        <div class="navbar">
            <a class="active" href="home.php">Search</a>
            <a href="postitem.php">Post</a>
            <form action="procedures/logout.php" method="post">
                <button type="submit" class="button-3">Log out</button>                
            </form>
        </div>
        
        <div class="search-results">
            <?php

                $stmt = $conn->prepare("SELECT * FROM item WHERE itemId = ?");
                $stmt->bind_param("s", $itemId);
                $stmt->execute();
                $itemsResult = $stmt->get_result();
                $itemRow = mysqli_fetch_assoc($itemsResult);

                $stmt2 = $conn->prepare("SELECT * FROM review WHERE forItem = ?");                                   
                $stmt2->bind_param("s", $itemRow['itemId']);
                $stmt2->execute();
                $reviewResult = $stmt2->get_result();
                $reviewRow = mysqli_fetch_assoc($reviewResult);
                $numReviews = mysqli_num_rows($reviewResult);

                echo "<h2>".$itemRow['title']." ( ";
                    if ($numReviews > 0) {
                        if ($numReviews == 1) {
                            echo $numReviews . " review";
                        } else {
                            echo $numReviews . " reviews";
                        } 
                    } else {
                        echo "No reviews";
                    }
                                        
                    echo " )</h2>
                    <p>".$itemRow['description']."</p>
                    <p>Price: $".$itemRow['price']."</p>
                    <p style='font-size:12px'>Posted by: ".$itemRow['postedBy']." on ".date('F d, Y', strtotime($itemRow['postDate']))."</p>";
            ?>
                
                    <form action="procedures/post.php" method="post">
                    <button type="submit" class="button">Write a review</button>
        </div>

        <div class="review-container">
            <?php


                 
            ?>
        </div>    
        
    </div>
</body>
</html>
