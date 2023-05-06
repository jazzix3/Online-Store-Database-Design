<?php
require("procedures/dbconnect.php");

// Users who posted some reviews, but each of them is "poor"    
$sql = "SELECT r1.writtenBy, r1.score, r1.remark, r1.forItem
        FROM review r1
        LEFT JOIN review r2 ON r1.writtenBy = r2.writtenBy AND r2.score != 'Poor'
        WHERE r1.score = 'Poor' AND r2.score IS NULL
        GROUP BY r1.writtenBy, r1.score, r1.remark, r1.forItem";

$result = mysqli_query($conn, $sql);


echo "<div class='list-container'>
        <h3>Users who posted some reviews, but each of them is 'poor'</h3>
        <table>
        <tr>
            <th>User</th>
            <th>Score Given</th>
            <th>Item Reviewed</th>
        </tr>";
                        
        while ($row = mysqli_fetch_assoc($result)) {
            $stmt = $conn->prepare("SELECT title FROM item WHERE itemId = ?");
            $stmt->bind_param("s", $row['forItem']);
            $stmt->execute();
            $itemResult = $stmt->get_result();
            $item = mysqli_fetch_assoc($itemResult);
        
            echo "  <tr>
                        <td>".$row["writtenBy"]."</td>
                        <td>".$row["score"]."</td>
                        <td>".$item['title']."</td>
                    </tr>";
        }
        
echo "</table></div>";


mysqli_close($conn);
?>