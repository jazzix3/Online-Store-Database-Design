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
        <meta name="viewport" content="width=device-width, initial scale=1.0">
        <title>Review an Item</title>
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
                <?php

                    $stmt = $conn->prepare("SELECT title FROM item WHERE itemId = ?");
                    $stmt->bind_param("s", $itemId);
                    $stmt->execute();
                    $itemResult = $stmt->get_result();
                    $itemRow = mysqli_fetch_assoc($itemResult);

                    echo "<h2>".$itemRow['title']."</h2>";
            
                    ?>
                <div class="reviewItem-container">
                    <div class="reviewItem-form">
                        <form action="procedures/review.php" method="post">
                            <input type="hidden" name="itemId" value="<?php echo (int) $itemId; ?>">


                            <label for="remark">Remark: </label><br>
                            <textarea name="remark" rows="5" cols="40" required></textarea><br><br>

                            <label for="score">Score:</label><br>
                            <select id="score" name="score" required>
                                <option value="Excellent">Excellent</option>
                                <option value="Good">Good</option>
                                <option value="Fair">Fair</option>
                                <option value="Poor">Poor</option>
                            </select><br><br>

                            <button type="submit" class="button">Review Item</button>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </body>
</html>

