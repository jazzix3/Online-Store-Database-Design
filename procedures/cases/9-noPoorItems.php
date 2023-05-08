<?php   
require("procedures/dbconnect.php");

// User whose items never gained poor reviews or any reviews at all
$sql = "SELECT i1.postedBy
          FROM item i1 
          LEFT JOIN review r ON i1.itemId = r.forItem
          WHERE i1.postedBy NOT IN (
            SELECT i2.postedBy
            FROM item i2
            JOIN review r2 ON i2.itemId = r2.forItem 
            WHERE r2.score = 'Poor' 
            GROUP BY i2.itemId, i2.postedBy
            HAVING COUNT(CASE WHEN r2.score = 'Poor' THEN 1 END) >= 1
            OR i2.postedBy IS NULL)
           GROUP BY i1.postedBy; ";
$result = mysqli_query($conn, $sql);

echo "<div class='list-container'>
        <h3>User whose items never gained poor reviews or any reviews at all</h3>";
                            
while ($row = mysqli_fetch_assoc($result)) {
         echo "<tr><td>".$row["postedBy"]."</td><td>";
   }
   echo "</table></div>";


mysqli_close($conn);
?>