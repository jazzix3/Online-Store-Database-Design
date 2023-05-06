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
            <a href="home.php">Search</a>
            <a href="postitem.php">Post</a>
            <a class="active" href="lists.php">Lists</a>
            <form action="procedures/logout.php" method="post">
                <button type="submit" class="button-3">Log out</button>                
            </form>
        </div>


        <div class="content">
            <h2>Lists of items and users by special cases</h2>

            <div class="search-form" >
                <form action="lists.php" method="post">
                    <select id="case" name="case" required>
                        <option value="" disabled selected>Select a special case</option>
                        <option value="1">1- Most expensive items in each category</option>
                        <option value="2">2- Users who posted at least two items that are posted on the same day, one has a category of X, and another has a category of Y</option>
                        <option value="3">3- Items posted by user X, such that all the comments are "Excellent" or "good" for these items</option>
                        <option value="4">4- Users who posted the most number of items since 5/1/2020 (inclusive)</option>
                        <option value="5">5- Other users who are favorited by both users X, and Y </option>
                        <option value="6">6- Users who never posted any "excellent" items</option>
                        <option value="7">7- Users who never posted a "poor" review</option>
                        <option value="8">8- Users who posted some reviews, but each of them is "poor"</option>
                        <option value="9">9- Users such that each item they posted so far never received any "poor" reviews</option>
                        <option value="10">10- User pair (A, B) such that they always gave each other "excellent" reviews for every single item they posted</option>   
                    </select>
                    <button type="submit" name="submit" class="button" style="width:50px; font-size: 14px; ">🔎</button>
                </form>
            </div>


            </div>

            <div class="search-results">

            <?php 
                if (isset($_POST['submit'])) {
                    $case = $_POST['case'];
                
                    switch ($case) {
                        case "1": // Most expensive items in each category  
                            include("procedures/cases/1-mostExpensiveInCategory.php");
                            break;
                        case "2": // Atleast two items posted on the same day, category X and Y
                            echo "<div class='forms'>                            
                            <form action='2items.php' method='post'>
                                    <select id='category1' name='category1' required>
                                        <option value='' disabled selected>Select a category</option>
                                        <option value='Art & Collectibles'>Art & Collectibles</option>
                                        <option value='Baby & Kids'>Baby & Kids</option>
                                        <option value='Clothing & Accessories'>Clothing & Accessories</option>
                                        <option value='Electronics'>Electronics</option>
                                        <option value='Furniture'>Furniture</option>
                                        <option value='Home & Garden'>Home & Garden</option>
                                        <option value='Pet Supplies'>Pet Supplies</option>
                                        <option value='Sporting Goods'>Sporting Goods</option>
                                        <option value='Toys'>Toys</option>
                                        <option value='Other'>Other</option>
                                    </select>
                                    <select id='category2' name='category2' required>
                                        <option value='' disabled selected>Select a category</option>
                                        <option value='Art & Collectibles'>Art & Collectibles</option>
                                        <option value='Baby & Kids'>Baby & Kids</option>
                                        <option value='Clothing & Accessories'>Clothing & Accessories</option>
                                        <option value='Electronics'>Electronics</option>
                                        <option value='Furniture'>Furniture</option>
                                        <option value='Home & Garden'>Home & Garden</option>
                                        <option value='Pet Supplies'>Pet Supplies</option>
                                        <option value='Sporting Goods'>Sporting Goods</option>
                                        <option value='Toys'>Toys</option>
                                        <option value='Other'>Other</option>
                                    </select>
                            <button type='submit' name='submitC' class='button' style='width:50px; font-size: 14px; '>🔎</button>
                            </div>";
                            //include("procedures/cases/2-itemsSameDayXY.php");
                            break;
                        case "7": // Users who never posted a "poor" review
                            include("procedures/cases/7-noPoorReviews.php");
                            break;

                    }
                }

                
                ?>

            </div>
        </div>
    </div>
</body>
</html>
