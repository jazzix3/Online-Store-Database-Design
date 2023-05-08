<?php   
require("procedures/dbconnect.php");

// Users whose items never gained 3 or more excellent reviews
$sql = "SELECT i1.postedBy
         FROM item i1 
         LEFT JOIN review r ON i1.postedBy = r.writtenBy
         WHERE i1.postedBy NOT IN (
            SELECT i2.postedBy
            FROM item i2
            JOIN review r2 ON i2.itemId = r2.forItem 
            WHERE r2.score = 'Excellent' 
            GROUP BY i2.itemId, i2.postedBy
            HAVING COUNT(CASE WHEN r2.score = 'Excellent' THEN 1 END) >= 3
            OR i2.postedBy IS NULL)
         GROUP BY i1.postedBy;";

$result = mysqli_query($conn, $sql);

echo "<div class='list-container'><table>
            <h3>Users whose items never gained 3 or more excellent reviews</h3>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td>".$row["postedBy"]."</td></tr>";
   }
   echo "</table></div>";

mysqli_close($conn);
?>