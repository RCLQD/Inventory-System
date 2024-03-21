<?php
    require('connection.php');

    $currentDate = date('Y-m-d');

    $thirtyDaysAhead = date('Y-m-d', strtotime('+30 days'));

    $sql = "SELECT FName, ExpDate FROM driversinventory WHERE ExpDate BETWEEN '$currentDate' AND '$thirtyDaysAhead' ORDER BY FName ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
    ?>
        <tr>
            <td><?php echo $row["FName"]; ?></td>
            <td><?php echo $row["ExpDate"]; ?></td>
        </tr>
    <?php
        }
    } else {
        echo "<tr><td colspan='2'>No records found</td></tr>";
    }

    $conn->close();
?>