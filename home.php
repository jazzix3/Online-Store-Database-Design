<?php 
session_start();

// If user is not logged in, redirect to index.php to log in
if (!isset($_SESSION["username"])){
    header("Location: index.php?error=invalidsession");
    exit();
}

require ("procedures/dbconnect.php");
?>

<!DOCTYPE html>
<html>
<head>    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search for an Item</title>
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
                <form action="procedures/search.php" method="post">
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
                    <button type="submit" class="button" style="width:50px; font-size: 14px; ">🔎</button>
                </form>
            </div>

            <!--  TEMPORARILY DISPLAYING ALL RESULTS, NEED TO DISPLAY RESULTS WHEN CATEGORY IS SELECTED -->
            <div class="search-results">
                
                    <table>
                        <thead>
                            <tr>
                                <th>Item ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                <?php 
                    $sql = "SELECT * FROM item";
                    $result = mysqli_query($conn, $sql);

                    if (!$result) {
                        echo "Error in query: ".mysqli_error($conn);
                    }

                    $queryResults = mysqli_num_rows($result);

                    if ($queryResults > 0) {
                        echo $queryResults . " results found!";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['itemId'] . "</td>";
                            echo "<td>" . $row['title'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>" . $row['price'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No results found.</td></tr>";
                    }
                    ?>
                    </body>
                </table>

                </div>
        </div>
    </div>
</body>
</html>
