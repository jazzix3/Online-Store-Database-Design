<?php
require("procedures/dbconnect.php");

// Users who posted some reviews, but each of them is "poor"    
$sql = "SELECT r1.writtenBy, r1.score, r1.remark
        FROM review r1
        LEFT JOIN review r2 ON r1.writtenBy = r2.writtenBy AND r2.score != 'Poor'
        WHERE r1.score = 'Poor' AND r2.score IS NULL
        GROUP BY r1.writtenBy, r1.score, r1.remark ";
$result = mysqli_query($conn, $sql);


echo "<div class='list-container'><table>
        <h3>Users who posted some reviews, but each of them is 'poor'</h3>
        <tr>
            <th>User</th>
            <th>Score Given</th>
            <th>Item Reviewed</th>
        </tr>";
                        
while ($row = mysqli_fetch_assoc($result)) {
echo "  <tr>
            <td>".$row["writtenBy"]."</td>
            <td>".$row["score"]."</td>
            <td>".$row["remark"]."</td>
        </tr>";
}
echo "</table></div>";


mysqli_close($conn);
?>