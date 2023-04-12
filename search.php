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
                        $result = $stmt->get_result();
                        
                        $queryResult = mysqli_num_rows($result);
                        
                        if ($queryResult > 0) {
                            echo "<h3>".$queryResult." results found in '".$category."':</h3>";
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<div class='item-container'>
                                <h2>".$row['title']."</h2>
                                <p>".$row['description']."</p>
                                <p>Price: $".$row['price']."</p>
                                <p>Posted by: ".$row['postedBy']." on ".date('F d, Y', strtotime($row['postDate']))."</p>";
                        
                                $stmt2 = $conn->prepare("SELECT COUNT(*) AS reviewCount FROM review WHERE forItem = ? GROUP BY forItem");
                                $stmt2->bind_param("s", $row['itemId']);
                                $stmt2->execute();
                                $result2 = $stmt2->get_result();
                        
                                if ($result2->num_rows > 0) {
                                    $row2 = $result2->fetch_assoc();
                                    $reviewCount = $row2["reviewCount"];
                                    if ($reviewCount == 1) {
                                        echo $reviewCount." review";
                                    }
                                    else {
                                        echo $reviewCount." reviews";
                                    } 
                                } 
                                else {
                                    echo "No reviews";
                                }
                                
                                echo "</div><hr>";
                            }
                        } else {
                            echo "No results found for '".$category."'";
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
