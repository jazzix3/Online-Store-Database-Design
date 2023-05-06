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
            <h2>Users who posted at least two items that are posted on the same day, one has a category of X, and another has a category of Y</h2>
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
                    <th>Item1</th>
                    <th>Category1</th>
                    <th>Item2</th>
                    <th>Category2</th>
                    <th>Date</th>
                    <th>User</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row["title1"]; ?></td>
                        <td><?php echo $row["category1"]; ?></td>
                        <td><?php echo $row["title2"]; ?></td>
                        <td><?php echo $row["category2"]; ?></td>
                        <td><?php echo $row["postDate"]; ?></td>
                        <td><?php echo $row["postedBy"]; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

    </div>
</body>
</html>