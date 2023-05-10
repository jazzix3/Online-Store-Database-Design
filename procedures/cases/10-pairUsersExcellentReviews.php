<?php   
require("procedures/dbconnect.php");

// Pairs of users who gave each other "excellent" reviews for every item they posted
$sql = "SELECT i1.postedBy as user1, i2.postedBy as user2
            FROM item i1
            INNER JOIN review r1 ON i1.itemId = r1.forItem AND r1.score = 'Excellent'
            INNER JOIN item i2 ON i2.postedBy = r1.writtenBy AND i1.itemId != i2.itemId
            INNER JOIN review r2 ON i2.itemId = r2.forItem AND r2.score = 'Excellent' AND r2.writtenBy = i1.postedBy
            GROUP BY i1.postedBy, i2.postedBy
            HAVING COUNT(DISTINCT i1.itemId) = (
                SELECT COUNT(*)
                FROM item
                WHERE postedBy = i1.postedBy
            )
            AND COUNT(DISTINCT i2.itemId) = (
                SELECT COUNT(*)
                FROM item
                WHERE postedBy = i2.postedBy
            )";
$result = mysqli_query($conn, $sql);

echo "<div class='list-container'>
        <h3>Pairs of users who gave each other 'excellent' reviews for every item they posted</h3>
        <table>
        <tr>
            <th>User1</th>
            <th>User2</th>
        </tr>";
                            
while ($row = mysqli_fetch_assoc($result)) {

    echo "  <tr>
                <td>".$row["user1"]."</td>
                <td>".$row["user2"]."</td>
            </tr>";
   }
   echo "</table></div>";


mysqli_close($conn);
?>