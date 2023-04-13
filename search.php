<?php 
session_start();

// If user is not logged in, redirect to index.php to log in
if (!isset($_SESSION["username"])){
    header("Location: index.php?error=invalidsession");
    exit();
}

require("procedures/dbconnect.php");
?>


<!DOCTYPE html>
<html>
<head>    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
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


        <div class="content">
            <h2>Search for an item</h2>
            
            <div class="search-form">
                <form action="search.php" method="post">
                    <select id="category" name="category" required>
                        <option value="" disabled selected>Select a category</option>
                        <option value="Art & Collectibles">Art & Collectibles</option>
                        <option value="Baby & Kids">Baby & Kids</option>
                        <option value="Clothing & Accessories">Clothing & Accessories</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Home & Garden">Home & Garden</option>
                        <option value="Pet Supplies">Pet Supplies</option>
                        <option value="Sporting Goods">Sporting Goods</option>
                        <option value="Toys">Toys</option>
                        <option value="Other">Other</option>
                    </select>
                    <button type="submit" name="submit" class="button" style="width:50px; font-size: 14px; ">🔎</button>
                </form>
            </div>

            <div class="search-results">
                <?php
                    if (isset($_POST["submit"])) {
                        
                        
                        $category = $_POST["category"];

                        $stmt = $conn->prepare("SELECT * FROM item WHERE category = ?");
                        $stmt->bind_param("s", $category);
                        $stmt->execute();
                        $itemResult = $stmt->get_result();
                        $numItems = mysqli_num_rows($itemResult);
                        
                        if ($numItems> 0) {
                            if ($numItems == 1){
                                echo "<h3>".$numItems." result found in '" .$category."':</h3>";
                            }
                            else {
                                    echo "<h3>".$numItems." results found in '" .$category."':</h3>";
                            }
                            

                                while ($itemRow = mysqli_fetch_assoc($itemResult)) {
                                    $stmt2 = $conn->prepare("SELECT * FROM review WHERE forItem = ?");
                                    $stmt2->bind_param("s", $itemRow['itemId']);
                                    $stmt2->execute();
                                    $reviewResult = $stmt2->get_result();
                                    $numReviews = mysqli_num_rows($reviewResult);

                                    echo "<div class='item-container'>
                                        <h2>".$itemRow['title']." ( ";
                                        if ($numReviews > 0) {
                                            if ($numReviews == 1) {
                                                echo "<a href='reviews.php?itemId=" . $itemRow['itemId'] . "'>" . $numReviews . " review</a>";
                                            } else {
                                                echo "<a href='reviews.php?itemId=" . $itemRow['itemId'] . "'>" . $numReviews . " reviews</a>";
                                            } 
                                        } else {
                                            echo "<a href='reviews.php?itemId=" . $itemRow['itemId'] . "'>No reviews</a>";
                                        }
                                                                
                                    echo " )</h2>
                                        <p>".$itemRow['description']."</p>
                                        <p>Price: $".$itemRow['price']."</p>
                                        <p style='font-size:12px'>Posted by: ".$itemRow['postedBy']." on ".date('F d, Y', strtotime($itemRow['postDate']))."</p>
                                        </div><hr>";
                                }
                        } else {
                            echo "<h3>No results found for '".$category."'</h3>";
                        }
                        
                        
                }
                else{
                    header("Location: ../home.php");
                    exit();
                }
                ?>

            </div>
    

        </div>
    </div>
</body>
</html>
