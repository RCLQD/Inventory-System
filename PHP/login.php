<?php
    require('connection.php');

    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $accesskey = $_POST['Accesskey'];

        $stmt = $conn->prepare("SELECT * FROM adminaccesskey WHERE Accesskey = ?");
        $stmt->bind_param("s", $accesskey);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['authenticated'] = true;
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Invalid access key";
            header("Location: login.php");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License Inventory</title>
    <link rel="stylesheet" href="../CSS/login.css">
</head>
<body>
    <main class="Login-MainContent">
        <div class="login-header">
            <h1>PKII</h1>
            <h2>License Inventory System</h2>
        </div>
        <div class="access-inputP">
            <form action="" method="post">
                <div class="access-input">
                    <p>Accesskey<span>*</span></p>
                    <input type="password" name="Accesskey" placeholder="Enter Accesskey" required>
                </div>
                <div class="btnsubmit">
                    <input type="submit">
                </div>
            </form>
        </div>
    </main>
    <script>
        <?php if(isset($_SESSION['error_message'])) : ?>
            alert("<?php echo $_SESSION['error_message']; ?>");
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    </script>
</body>
</html>
