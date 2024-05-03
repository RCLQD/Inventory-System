<?php
session_start();

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    require('connection.php');

    $sql = "DELETE FROM driversinventory WHERE D_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->execute()) {
        $_SESSION['delete_success'] = true;
    }

    $stmt->close();

    $conn->close();

    header("Location: dashboard.php");
    exit();
} else {
    header("Location: dashboard.php");
    exit();
}
?>