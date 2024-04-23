<?php
session_start(); // Start session if not already started
require('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['FName'], $_POST['Address'], $_POST['LicNo'], $_POST['EDate'], $_POST['id'])) {
        $id = $_POST['id'];

        $FName = htmlspecialchars($_POST['FName']);
        $Address = htmlspecialchars($_POST['Address']);
        $LicNo = htmlspecialchars($_POST['LicNo']);
        $EDate = $_POST['EDate'];

        $stmt = $conn->prepare("UPDATE driversinventory SET FName=?, Address=?, LicNo=?, ExpDate=? WHERE D_id=?");
        $stmt->bind_param("ssssi", $FName, $Address, $LicNo, $EDate, $id);

        if ($stmt->execute()) {
            $_SESSION['update_success_message'] = true;
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required";
    }
} else {
    echo "Form submission method not allowed";
}

$conn->close();
?>