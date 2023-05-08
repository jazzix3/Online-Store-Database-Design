<?php   
require("procedures/dbconnect.php");

//Items posted by user X with only "excellent" or "good" reviews for these items
$sql = "SELECT i.postedBy, i.title, r.remark
    FROM item i
    JOIN review r ON i.itemId = r.forItem
    WHERE i.itemId NOT IN (
        SELECT i2.itemId
        FROM item i2
        JOIN review r2 ON i2.itemId = r2.forItem 
        WHERE r2.score = 'Poor' OR r2.score IS NULL
        GROUP BY i2.itemId
        HAVING COUNT(*) > 0)
    AND r.score IN ('Excellent', 'Good')
    GROUP BY i.postedBy, i.title, r.remark";

 $result = mysqli_query($conn, $sql);

  echo "<div class='list-container'>
            <h3>Items posted by user X with only 'excellent' or 'good' reviews for these items</h3>
            <table>
            <tr>
                <th>User</th>
                <th>Good/Excellent Review</th>
                <th>Remark</th>
            </tr>";
                            
           while ($row = mysqli_fetch_assoc($result)) {
   echo "<tr><td>".$row["postedBy"]."</td><td>".$row["title"]."</td><td>".$row["remark"]."</td></tr>";
   }
   echo "</table></div>";

