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
            <h2>Common Favorite Seller</h2>
            <?php
                $category1 = $_POST['category1'];
                $category2 = $_POST['category2'];
                $stmt = $conn->prepare("SELECT X.buyer AS buyer1, Y.buyer AS buyer2, X.seller
                FROM favorite AS X, favorite AS Y 
                WHERE X.buyer = ? AND Y.buyer = ?
                AND X.buyer <> Y.buyer 
                AND X.seller = Y.seller");
                $stmt->bind_param("ss", $category1, $category2);
                $stmt->execute();
                $result = $stmt->get_result();
            ?>
            <table>
                <tr>
                    <th>Buyer 1</th>
                    <th>Buyer 2</th>
                    <th>Seller</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row["buyer1"]; ?></td>
                        <td><?php echo $row["buyer2"]; ?></td>
                        <td><?php echo $row["seller"]; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

    </div>
</body>
</html>