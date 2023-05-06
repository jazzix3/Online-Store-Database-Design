<?php
require("procedures/dbconnect.php");

$sql = "SELECT category, title, price 
        FROM item 
        WHERE (category, price) IN 
            (SELECT category, MAX(price) 
            FROM item GROUP BY category)";

$result = mysqli_query($conn, $sql);

?>

<div class='list-container'>
    <h3><center>Most expensive items in each category</center></h3><br>
    <table>
        <tr>
            <th>Category</th>
            <th>Item</th>
            <th>Price</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row["category"]; ?></td>
                <td><?php echo $row["title"]; ?></td>
                <td><?php echo $row["price"]; ?></td>
            </tr>
        <?php } ?>

    </table>
</div>

<?php mysqli_close($conn);?>
