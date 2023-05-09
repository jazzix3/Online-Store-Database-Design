<?php 
session_start();


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
                        <option value="10">10- User pair (A, B) such that they always gave each other "excellent" reviews for every single item they posted</option>   
                    </select>
                    <button type="submit" name="submit" class="button" style="width:50px; font-size: 14px; ">🔎</button>
                </form>
            </div>

        <div class='list-container'>
        
            
            <?php 
                if (isset($_POST['submitC'])) {
                    $selected_user = $_POST['selected_user'];
                }

                // Items posted by user X with only "excellent" or "good" reviews
                $sql = "SELECT i.postedBy, i.title, r.remark
                    FROM item i
                    JOIN review r ON i.itemId = r.forItem
                    WHERE postedBy = '$selected_user'
                    AND i.itemId NOT IN (
                        SELECT i2.itemId
                        FROM item i2
                        JOIN review r2 ON i2.itemId = r2.forItem 
                        WHERE r2.score = 'Poor' OR r2.score IS NULL
                        GROUP BY i2.itemId
                        HAVING COUNT(*) > 0)
                    AND r.score IN ('Excellent', 'Good')
                    GROUP BY i.postedBy, i.title, r.remark";

                $result = mysqli_query($conn, $sql);
            ?>
            
            <h3>Items posted by <?php echo $selected_user ?> with only \"excellent\" or \"good\" reviews</h3>
            <table>
                    <tr>
                        <th>User</th>
                        <th>Good/Excellent Review</th>
                        <th>Remark</th>
                    </tr>
                                    
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row["postedBy"]; ?></td>
                            <td><?php echo $row["title"]; ?></td>
                            <td><?php echo $row["remark"]; ?></td>

                        </tr>
                    <?php } ?>
            </table>
            </div>

        </div>
</body>
</html>

