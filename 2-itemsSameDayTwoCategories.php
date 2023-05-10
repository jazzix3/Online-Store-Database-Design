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
                        <option value="5">5- Sellers who are favorited by a pair of users</option>
                        <option value="6">6- Users whose items never gained 3 or more excellent reviews</option>
                        <option value="7">7- Users who never wrote a "poor" review</option>
                        <option value="8">8- Users who posted some reviews, but each of them is "poor"</option>
                        <option value="9">9- Users whose items never gained "poor" reviews or any reviews at all</option>
                        <option value="10">10- Pairs of users who gave each other "excellent" reviews for every item they posted</option>   
                    </select>
                    <button type="submit" name="submit" class="button" style="width:50px; font-size: 14px; ">🔎</button>
                </form>
            </div>

        <div class='list-container'>
            <h3>Users who posted >= two items on the same day in two categories</h3>
            <?php
                $category1 = $_POST['category1'];
                $category2 = $_POST['category2'];
                $stmt = $conn->prepare("SELECT T.title AS title1, T.category AS category1, S.title AS title2, S.category AS category2, T.postDate, T.postedBy
                FROM item AS T, item AS S
                WHERE T.category <> S.category
                AND T.category = ? AND S.category = ?
                AND T.postDate = S.postDate AND T.postedBy = S.postedBy");
                $stmt->bind_param("ss", $category1, $category2);
                $stmt->execute();
                $result = $stmt->get_result();
            ?>
            <table>
                <tr>
                <th>User</th>
                    <th>Item1</th>
                    <th>Category1</th>
                    <th>Item2</th>
                    <th>Category2</th>
                    <th>Date</th>

                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row["postedBy"]; ?></td>
                        <td><?php echo $row["title1"]; ?></td>
                        <td><?php echo $row["category1"]; ?></td>
                        <td><?php echo $row["title2"]; ?></td>
                        <td><?php echo $row["category2"]; ?></td>
                        <td><?php echo $row["postDate"]; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

    </div>
</body>
</html>