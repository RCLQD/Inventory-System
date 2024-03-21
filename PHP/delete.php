<?php
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    require('connection.php');

    $sql = "DELETE FROM driversinventory WHERE D_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->close();

    $conn->close();

    header("Location: dashboard.php");
    exit();
} else {
    header("Location: dashboard.php");
    exit();
}
?>