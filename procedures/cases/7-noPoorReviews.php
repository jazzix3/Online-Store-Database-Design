

<div class='list-container'>
    <h3><center>Users who never posted a "poor" review</center></h3><br>
    <table>
        <tr>
            <th>User</th>
            <th>Score</th>
            <th>Remark</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row["writtenBy"] ?></td>
                <td><?php echo $row["score"] ?></td>
                <td><?php echo $row["remark"] ?></td>
            </tr>
        <?php } ?>

    </table>
</div>

<?php mysqli_close($conn); ?>
