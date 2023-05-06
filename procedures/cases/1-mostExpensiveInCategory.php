<?php   
require("procedures/dbconnect.php");

// Most expensive items in each category
$sql = "SELECT category, title, price 
        FROM item 
        WHERE (category, price) IN 
            (SELECT category, MAX(price) 
            FROM item GROUP BY category)";

$result = mysqli_query($conn, $sql);


echo "<div class='list-container'>
        <h3>Most expensive items in each category</h3><br>
        <table>
            <tr>
                <th>Category</th>
                <th>Item</th>
                <th>Price</th>
            </tr>";

while ($row = mysqli_fetch_assoc($result)) {
echo "      <tr>
                <td>".$row["category"]."</td>
                <td>".$row["title"]."</td>
                <td>".$row["price"]."</td>
            </tr>";
}
echo "</table></div>";

mysqli_close($conn);
?>
