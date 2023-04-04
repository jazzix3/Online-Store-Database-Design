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
        <meta name="viewport" content="width=device-width, initial scale=1.0">
        <title>Post an Item</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    </head>
    <body>
        <div class="container-main">
            <div class="navbar">
                <a href="home.php">Search</a>
                <a class="active" href="postitem.php">Post</a>
                <form action="procedures/logout.php" method="post">
                    <button type="submit" class="button-3">Log out</button>                
                </form>
            </div>

            <div class="content">
                <h2>Post an Item</h2>
                <?php
                        if (isset($_GET["error"])){
                            if($_GET["error"] == "none"){
                                echo "<p class='errormsg'>New user was registered successfully! </p>";
                            }
                            if($_GET["error"] == "reachedlimit"){
                                echo "<p class='errormsg'>Unable to post item. You have reached the limit of 3 posts per day. </p>";
                            }
                        }
                    ?>
                <div class="postItem-container">
                    <div class="postItem-form">
                        <form action="procedures/post.php" method="post">
                            <label for="title">Title: </label><br>
                            <input name="title" type="text" required><br><br>

                            <label for="description">Description: </label><br>
                            <textarea name="description" rows="5" cols="40" required></textarea><br><br>

                            <label for="category">Category: </label><br>
                            <input name="category" type="text" required><br><br>

                            <label for="price">Price: </label><br>
                            <input name="price" type="number" min="0" step="0.01" required><br><br>

                            <button type="submit" class="button">Post Item</button>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </body>
</html>
