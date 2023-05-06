<?php 
session_start();

// If user is not logged in, redirect to index.php to log in
if (!isset($_SESSION["username"])){
    header("Location: index.php?error=invalidsession");
    exit();
}

require("procedures/dbconnect.php");

if (isset($_GET["postedBy"])){ 
    $postedBy = $_GET["postedBy"];
}

if (isset($_GET['seller'])) {
    $seller = $_GET['seller'];

    $postedBy= $seller;
}

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
            <a href="lists.php">Lists</a>
            <form action="procedures/logout.php" method="post">
                <button type="submit" class="button-3">Log out</button>                
            </form>
        </div>

        <div class="content">
            <?php
                echo "<h2>" .$postedBy. "'s items for sale</h2>" ;

                if (isset($_GET["error"])){ ;
                    if($_GET["error"] == "none"){
                        echo "<p class='errormsg'>Seller was added to your favorites</p>";
                    }
                    else if($_GET["error"] == "duplicate"){
                        echo "<p class='errormsg'>Seller is in your favorites already</p>";
                    }
                    else if($_GET["error"] == "sameuser"){
                        echo "<p class='errormsg'>Cannot add yourself to favorites</p>";
                    }
                }
            ?>

            <form action="procedures/addseller.php" method="post">
                <input type="hidden" name="postedBy" value="<?php echo $postedBy; ?>">
                <button type="submit" name="submit" class="button">Add seller to favorites</button>
            </form>
        
            <div class="search-results">
                <?php

                $stmt = $conn->prepare("SELECT * FROM item WHERE postedBy = ?");
                $stmt->bind_param("s", $postedBy);
                $stmt->execute();
                $itemResult = $stmt->get_result();
                $numItems = mysqli_num_rows($itemResult);
                
                if ($numItems> 0) {
                        while ($itemRow = mysqli_fetch_assoc($itemResult)) {
                            $stmt2 = $conn->prepare("SELECT * FROM review WHERE forItem = ?");
                            $stmt2->bind_param("s", $itemRow['itemId']);
                            $stmt2->execute();
                            $reviewResult = $stmt2->get_result();
                            $numReviews = mysqli_num_rows($reviewResult);

                            echo "<div class='item-container'>
                                <div class='left-column'><a href='reviews.php?itemId=" .$itemRow['itemId'] . "'>" .$itemRow['title']. " ( ";
                                if ($numReviews > 0) {
                                    if ($numReviews == 1) {
                                        echo $numReviews . " review )</a>";
                                    } else {
                                        echo $numReviews . " reviews )</a>";
                                    } 
                                } else {
                                    echo  "No reviews )</a>";
                                }
                                                        
                            echo "<p>".$itemRow['description']."</p>
                                <p>Price: $".$itemRow['price']."</p>
                                <p style='font-size:12px'>Posted by: ".$itemRow['postedBy']." on ".date('F d, Y', strtotime($itemRow['postDate']))."</p>
                                </div>
                                
                                <div class='right-column'>
                                <p><a href='reviewitem.php?itemId=" . $itemRow['itemId'] . "'class='button-4'>Write a review</a></p>
                                </div>

                                
                                </div><hr>";
                        }
                } else {
                    echo "<h3>".$postedBy. " has no items for sale at the moment</h3>";
                }

                
                $stmt2 = $conn->prepare("SELECT * FROM review WHERE writtenBy = ?");
                $stmt2->bind_param("s", $postedBy);
                $stmt2->execute();
                $reviewResult = $stmt2->get_result();
                $numReviews = mysqli_num_rows($reviewResult);
                
                echo "<br><br><h2>" .$postedBy. "'s reviews</h2> <div class='review-container'>" ;
                
                if ($numReviews > 0) {
                    while ($reviewRow = mysqli_fetch_assoc($reviewResult)) {
                        $stmt3 = $conn->prepare("SELECT title FROM item WHERE itemId = ?");
                        $stmt3->bind_param("s", $reviewRow['forItem']);
                        $stmt3->execute();
                        $itemResult = $stmt3->get_result();
                        $itemRow = mysqli_fetch_assoc($itemResult);
                        
                        echo "<div class='item-container' style='display:inline-block'>
                              <h2>".$itemRow['title']." <span style='font-size:12px'> on ".date('F d, Y', strtotime($reviewRow['reviewDate']))."</span></h2>
                              <p>Score: ".$reviewRow['score']."</p>
                              <p><i>'".$reviewRow['remark']."'</i></p>
                              </div><hr>";
                    }
                }
                else{
                    echo "<h3>".$postedBy. " has not written any reviews</h3>";
                }
                

                 
            ?>
        </div>
                
            </div>
        </div>
    </div>
</body>
</html>