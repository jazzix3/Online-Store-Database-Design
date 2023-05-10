<?php   
require("procedures/dbconnect.php");

// Users who never wrote a "poor" review
$sql = "SELECT writtenBy, score, remark FROM review
                                    WHERE writtenBy 
                                    NOT IN (SELECT writtenBy FROM review
                                            WHERE score = ('Poor')
                                            GROUP BY writtenBy) ";
$result = mysqli_query($conn, $sql);


echo "<div class='list-container'>
        <h3>Users who never wrote a 'poor' review</h3>
        <table>
            <tr>
                <th>User</th>
                <th>Title</th>
                <th>Review</th>
            </tr>";

while ($row = mysqli_fetch_assoc($result)) {
echo "      <tr>
                <td>".$row["writtenBy"]."</td>
                <td>".$row["score"]."</td>
                <td>".$row["remark"]."</td>
            </tr>";
}
echo "</table></div>";

mysqli_close($conn);
?>