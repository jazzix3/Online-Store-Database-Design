<?php   
require("procedures/dbconnect.php");

// Users who posted the most number of items since 5/1/2020 (inclusive)
$sql = "SELECT u.username, COUNT(*) AS num_items
        FROM user u
        INNER JOIN item i ON u.username = i.postedBy
        WHERE i.postDate >= '2020-05-01'
        GROUP BY u.username
        HAVING COUNT(*) = (
            SELECT COUNT(*) AS num_items
            FROM item
            WHERE postDate >= '2020-05-01'
            GROUP BY postedBy
            ORDER BY num_items DESC
            LIMIT 1
        )";

$result = mysqli_query($conn, $sql);


echo "<div class='list-container'>
        <h3>Users who posted the most number of items since 5/1/2020 (inclusive)</h3><br>
        <table>
            <tr>
                <th>User</th>
                <th>Number Items Posted</th>
            </tr>";

while ($row = mysqli_fetch_assoc($result)) {
echo "      <tr>
                <td>".$row["username"]."</td>
                <td>".$row["num_items"]."</td>
            </tr>
            
    ";
}
echo "</table></div>";

mysqli_close($conn);

?>
