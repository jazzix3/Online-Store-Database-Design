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
                        <option value="2">2- Users who posted >= two items on the same day in two categories</option>
                        <option value="3">3- Items posted by user X with only "excellent" or "good" reviews</option>
                        <option value="4">4- Users who posted the most number of items since 5/1/2020 (inclusive)</option>
                        <option value="5">5- Users who have favorite sellers in common</option>
                        <option value="6">6- Users whose items never gained 3 or more excellent reviews</option>
                        <option value="7">7- Users who never posted a "poor" review</option>
                        <option value="8">8- Users who posted some reviews, but each of them is "poor"</option>
                        <option value="9">9- Users whose items never gained "poor" reviews or any reviews at all</option>
                        <option value="10">10- Pairs of users who gave each other "excellent" reviews for every item they posted</option>   
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
                        case "2": // Users who posted >= two items on the same day in two categories
                            echo "<div class='list-container'>
                            <h3>Users who posted >= two items on the same day in two categories</h3>
                            <div class='forms'><center>                            
                            <form action='2-itemsSameDayTwoCategories.php' method='post'>
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
                                    </center></select>
                            <button type='submit' name='submitC' class='button' style='width:50px; font-size: 14px; '>🔎</button>
                            </div>";
                            break;
                            case "3": // Items posted by user X with only "excellent" or "good" reviews
                                echo "  <div class='content'>
                                            <div class='list-container'>
                                                <h3>Items posted by user X with only 'excellent' or 'good' reviews</h3>
                                            </div>
                                            <div class='search-form'>
                                                <form action='3-itemUserExellentOrGoodReview.php' method='post'>
                                                    <input type='text' name='selected_user' placeholder='Enter username' required>
                                                    <button type='submit' name='submitC' class='button' style='width:50px; font-size: 14px;'>🔎</button>
                                                </form>
                                            </div>
                                        </div>";
                                break;
                              
                        case "4": // Users who posted the most number of items since 5/1/2020 (inclusive)
                            include("procedures/cases/4-postedMostItems.php");
                            break;
                        case "5": // Users who have favorite sellers in common
                            echo "<div class='list-container'>
                            <h3>Users who have favorite sellers in common</h3>
                            <div class='forms'><center>                             
                            <form action='5-usersCommonFavorites.php' method='post'>
                                    <select id='category1' name='category1' required>
                                        <option value='' disabled selected>Select a category</option>
                                        <option value='alice5'>alice5</option>
                                        <option value='jane2'>jane2</option>
                                        <option value='john1'>john1</option>
                                        <option value='lisa4'>lisa4</option>
                                        <option value='matt3'>matt3</option>
                                    </select>
                                    <select id='category2' name='category2' required>
                                        <option value='' disabled selected>Select a category</option>
                                        <option value='alice5'>alice5</option>
                                        <option value='jane2'>jane2</option>
                                        <option value='john1'>john1</option>
                                        <option value='lisa4'>lisa4</option>
                                        <option value='matt3'>matt3</option>
                                    </select>
                            <button type='submit' name='submitC' class='button' style='width:50px; font-size: 14px; '>🔎</button>
                            </div>";
                            break;
                        case "6": // Users whose items never gained 3 or more excellent reviews
                            include("procedures/cases/6-noExcellentItems.php");
                            break;
                        case "7": // Users who never posted a "poor" review
                            include("procedures/cases/7-noPoorReviews.php");
                            break;
                        case "8": // Users who posted some reviews, but each of them is "poor"
                            include("procedures/cases/8-poorReviewsOnly.php");
                            break;
                        case "9": // Users whose items never gained poor reviews or any reviews at all
                            include("procedures/cases/9-noPoorItems.php");
                            break;
                        case "10": // Pairs of users who gave each other "excellent" reviews for every item they posted
                            include("procedures/cases/10-pairUsersExcellentReviews.php");
                            break;
                    }
                }

                
                ?>

            </div>
        </div>
    </div>
</body>
</html>
