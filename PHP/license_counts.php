<?php
require('connection.php');

$sql = "SELECT * FROM driversinventory ORDER BY FName ASC";
$result = $conn->query($sql);

$activeCount = 0;
$expiryCount = 0;

$currentDate = date('Y-m-d');

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $expiryDate = $row['ExpDate'];

        $daysDifference = floor((strtotime($expiryDate) - strtotime($currentDate)) / (60 * 60 * 24));

        if ($daysDifference <= 30) {
            $expiryCount++;
        } else {
            $activeCount++;
        }
    }
}
$conn->close();
?>